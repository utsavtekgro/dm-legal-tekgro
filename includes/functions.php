<?php
/**
 * Shared helper functions used across all pages.
 */

/** Escape a string for safe HTML output (XSS protection). */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Resolve an asset/page path against BASE_URL. */
function url(string $path): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/** Slugify a title the same way utils/generateSlug.ts did. */
function slugify(string $title): string
{
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/** Truncate text to a maximum word count, matching utils/truncate.ts. */
function truncate_words(string $text, int $maxWords): string
{
    $words = preg_split('/\s+/', trim($text));
    if (count($words) > $maxWords) {
        return implode(' ', array_slice($words, 0, $maxWords)) . '....';
    }
    return $text;
}

/** Generate (or reuse) a CSRF token for the current session. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Render a hidden CSRF input field. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/** Verify a submitted CSRF token using constant-time comparison. */
function verify_csrf(?string $submitted): bool
{
    return is_string($submitted)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $submitted);
}

/** Trim + strip tags from user input (defense-in-depth; output is still escaped with e() on display). */
function clean_input(?string $value): string
{
    return trim(strip_tags($value ?? ''));
}

/** Basic safe-redirect helper to avoid open-redirect vulnerabilities. */
function safe_redirect(string $path): void
{
    // Only allow relative, in-site paths.
    if (preg_match('#^https?://#i', $path) || strpos($path, '//') === 0) {
        $path = '/';
    }
    header('Location: ' . $path);
    exit;
}

/** Find a blog post by slug from the global $blogs data set. */
function find_blog_by_slug(string $slug): ?array
{
    global $blogs;
    foreach ($blogs as $blog) {
        if (slugify($blog['title']) === $slug) {
            return $blog;
        }
    }
    return null;
}

/** Find a practice area by slug from $legalServicesData. */
function find_practice_area_by_slug(string $slug): ?array
{
    global $legalServicesData;
    foreach ($legalServicesData as $area) {
        if (slugify($area['title']) === $slug) {
            return $area;
        }
    }
    return null;
}

/**
 * Render a breadcrumb trail. $items is a list of ['label' => string, 'href' => string|null].
 * The last item (or any item with href === null) is rendered as plain text (current page).
 * Omitted entirely on the home page, matching Breadcrumb.tsx returning null for "/".
 */
function render_breadcrumb(array $items): void
{
    if (empty($items)) return;
    echo '<nav class="breadcrumb" aria-label="Breadcrumb"><ol>';
    echo '<li><a href="' . e(url('index.php')) . '" aria-label="Home">&#8962;</a></li>';
    foreach ($items as $i => $item) {
        $isLast = $i === count($items) - 1;
        echo '<li><span aria-hidden="true">&rsaquo;</span> ';
        if ($isLast || empty($item['href'])) {
            echo '<span class="current">' . e($item['label']) . '</span>';
        } else {
            echo '<a href="' . e(url($item['href'])) . '">' . e($item['label']) . '</a>';
        }
        echo '</li>';
    }
    echo '</ol></nav>';
}

/**
 * Render the lightweight markdown used in the legal text pages (bold,
 * bullet lists, paragraphs) as safe HTML. The original React component
 * rendered this content as plain escaped text with the markdown markers
 * left in literally — fixed here so policy pages are actually readable.
 */
function render_markdown_lite(string $text): void
{
    $blocks = preg_split('/\n\s*\n/', trim($text));
    foreach ($blocks as $block) {
        $lines = array_filter(array_map('trim', explode("\n", $block)));
        $isList = true;
        foreach ($lines as $line) {
            if (mb_substr($line, 0, 2) !== '- ') { $isList = false; break; }
        }
        if ($isList && count($lines) > 0) {
            echo '<ul>';
            foreach ($lines as $line) {
                echo '<li>' . bold_inline(mb_substr($line, 2)) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . bold_inline(implode(' ', $lines)) . '</p>';
        }
    }
}

/** Escape text then convert **bold** markers to <strong>. */
function bold_inline(string $text): string
{
    $escaped = e($text);
    return preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped);
}

/** Find a case study by slug from $caseStudies. */
function find_case_study_by_slug(string $slug): ?array
{
    global $caseStudies;
    foreach ($caseStudies as $cs) {
        if (slugify($cs['title']) === $slug) {
            return $cs;
        }
    }
    return null;
}
