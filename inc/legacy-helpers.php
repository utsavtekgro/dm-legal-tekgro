<?php
/**
 * Legacy static-site content layer, ported into WordPress.
 *
 * Defines the firm constants, output helpers and the WordPress-aware url()
 * router that let the original DM Legal templates render 1:1 inside the theme.
 * The bulky content arrays live in inc/data.php and are loaded from
 * functions.php at global scope so page templates can read them directly.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ---------------------------------------------------------------------
// Firm constants (from the legacy includes/config.php)
// ---------------------------------------------------------------------
defined( 'SITE_NAME' )          || define( 'SITE_NAME', 'DM Legal' );
defined( 'SITE_TAGLINE' )       || define( 'SITE_TAGLINE', 'Expert legal advice and representation for your needs.' );
defined( 'SITE_PHONE_DISPLAY' ) || define( 'SITE_PHONE_DISPLAY', '0426 269 954' );
defined( 'SITE_PHONE_TEL' )     || define( 'SITE_PHONE_TEL', '+610426269954' );
defined( 'SITE_WHATSAPP' )      || define( 'SITE_WHATSAPP', 'https://wa.me/+610426269954' );
defined( 'SITE_EMAIL' )         || define( 'SITE_EMAIL', 'info@dmlegalservices.com.au' );
defined( 'SITE_ADDRESS_SHORT' ) || define( 'SITE_ADDRESS_SHORT', 'Meriton Suites World Tower, Sydney' );
defined( 'SITE_MAPS_URL' )      || define( 'SITE_MAPS_URL', 'https://maps.app.goo.gl/jhzb5NCbfToYvgmy5' );

if ( ! function_exists( 'e' ) ) {
	/** Escape a string for safe HTML output (XSS protection). */
	function e( $value ) {
		return htmlspecialchars( (string) ( $value ?? '' ), ENT_QUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'url' ) ) {
	/**
	 * WordPress-aware replacement for the legacy url() helper.
	 *
	 * - assets/…              -> theme asset URL
	 * - external/mailto/tel/# -> returned untouched
	 * - foo.php?slug=bar      -> home_url('/foo/') . '?slug=bar'
	 * - index.php / ''        -> home_url('/')
	 *
	 * This lets every legacy template's link and image path resolve to the
	 * right place without editing the markup.
	 *
	 * @param string $path Legacy path.
	 * @return string
	 */
	function url( $path ) {
		$path = (string) $path;

		if ( '' === $path ) {
			return home_url( '/' );
		}

		// Pass through absolute URLs, protocol-relative, mailto:, tel:, anchors.
		if ( preg_match( '#^(https?:|mailto:|tel:|//|#)#i', $path ) ) {
			return $path;
		}

		$path = ltrim( $path, '/' );

		if ( '' === $path || 'index.php' === $path ) {
			return home_url( '/' );
		}

		// Theme-bundled assets.
		if ( 0 === strpos( $path, 'assets/' ) ) {
			return trailingslashit( get_template_directory_uri() ) . $path;
		}

		// Split off ?query and #fragment so we can map the .php filename.
		$fragment = '';
		$query    = '';

		$hash = strpos( $path, '#' );
		if ( false !== $hash ) {
			$fragment = substr( $path, $hash );
			$path     = substr( $path, 0, $hash );
		}

		$qmark = strpos( $path, '?' );
		if ( false !== $qmark ) {
			$query = substr( $path, $qmark );
			$path  = substr( $path, 0, $qmark );
		}

		$slug = preg_replace( '/\.php$/', '', $path );

		if ( '' === $slug || 'index' === $slug ) {
			return home_url( '/' ) . $query . $fragment;
		}

		return home_url( '/' . $slug . '/' ) . $query . $fragment;
	}
}

if ( ! function_exists( 'slugify' ) ) {
	/** Slugify a title the same way the original generateSlug.ts did. */
	function slugify( $title ) {
		$slug = strtolower( (string) $title );
		$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
		return trim( $slug, '-' );
	}
}

if ( ! function_exists( 'truncate_words' ) ) {
	/** Truncate text to a maximum word count, matching truncate.ts. */
	function truncate_words( $text, $max_words ) {
		$text  = (string) $text;
		$words = preg_split( '/\s+/', trim( $text ) );
		if ( count( $words ) > $max_words ) {
			return implode( ' ', array_slice( $words, 0, $max_words ) ) . '....';
		}
		return $text;
	}
}

if ( ! function_exists( 'clean_input' ) ) {
	/** Trim + strip tags from user input; output is still escaped with e(). */
	function clean_input( $value ) {
		return trim( wp_strip_all_tags( (string) ( $value ?? '' ) ) );
	}
}

if ( ! function_exists( 'find_blog_by_slug' ) ) {
	/** Find a blog post by slug from the global $blogs data set. */
	function find_blog_by_slug( $slug ) {
		global $blogs;
		foreach ( (array) $blogs as $blog ) {
			if ( slugify( $blog['title'] ) === $slug ) {
				return $blog;
			}
		}
		return null;
	}
}

if ( ! function_exists( 'find_practice_area_by_slug' ) ) {
	/** Find a practice area by slug from $legalServicesData. */
	function find_practice_area_by_slug( $slug ) {
		global $legalServicesData;
		foreach ( (array) $legalServicesData as $area ) {
			if ( slugify( $area['title'] ) === $slug ) {
				return $area;
			}
		}
		return null;
	}
}

if ( ! function_exists( 'find_case_study_by_slug' ) ) {
	/** Find a case study by slug from $caseStudies. */
	function find_case_study_by_slug( $slug ) {
		global $caseStudies;
		foreach ( (array) $caseStudies as $cs ) {
			if ( slugify( $cs['title'] ) === $slug ) {
				return $cs;
			}
		}
		return null;
	}
}

if ( ! function_exists( 'render_breadcrumb' ) ) {
	/**
	 * Render a breadcrumb trail. $items is a list of ['label','href'].
	 * The last item (or any item with no href) renders as the current page.
	 */
	function render_breadcrumb( array $items ) {
		if ( empty( $items ) ) {
			return;
		}
		echo '<nav class="breadcrumb" aria-label="Breadcrumb"><ol>';
		echo '<li><a href="' . e( url( 'index.php' ) ) . '" aria-label="Home">&#8962;</a></li>';
		foreach ( $items as $i => $item ) {
			$is_last = $i === count( $items ) - 1;
			echo '<li><span aria-hidden="true">&rsaquo;</span> ';
			if ( $is_last || empty( $item['href'] ) ) {
				echo '<span class="current">' . e( $item['label'] ) . '</span>';
			} else {
				echo '<a href="' . e( url( $item['href'] ) ) . '">' . e( $item['label'] ) . '</a>';
			}
			echo '</li>';
		}
		echo '</ol></nav>';
	}
}

if ( ! function_exists( 'bold_inline' ) ) {
	/** Escape text then convert **bold** markers to <strong>. */
	function bold_inline( $text ) {
		$escaped = e( $text );
		return preg_replace( '/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped );
	}
}

if ( ! function_exists( 'render_markdown_lite' ) ) {
	/**
	 * Render the lightweight markdown used on the legal text pages
	 * (bold, bullet lists, paragraphs) as safe HTML.
	 */
	function render_markdown_lite( $text ) {
		$blocks = preg_split( '/\n\s*\n/', trim( (string) $text ) );
		foreach ( $blocks as $block ) {
			$lines   = array_filter( array_map( 'trim', explode( "\n", $block ) ) );
			$is_list = true;
			foreach ( $lines as $line ) {
				if ( mb_substr( $line, 0, 2 ) !== '- ' ) {
					$is_list = false;
					break;
				}
			}
			if ( $is_list && count( $lines ) > 0 ) {
				echo '<ul>';
				foreach ( $lines as $line ) {
					echo '<li>' . bold_inline( mb_substr( $line, 2 ) ) . '</li>';
				}
				echo '</ul>';
			} else {
				echo '<p>' . bold_inline( implode( ' ', $lines ) ) . '</p>';
			}
		}
	}
}
