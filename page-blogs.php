<?php
/**
 * News & Blog listing — ported from the legacy static blogs.php.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

/*
 * Hero content is editable per-page via the "Hero Section" metabox
 * (Pages → News & Blog). Anything left blank there falls back to the
 * defaults below, so the page renders unchanged until it's overridden.
 */
$dm_hero = dm_legal_hero_args(
	array(
		'heroTitle'      => 'Explore, Learn, and Grow – Your Journey Starts Here',
		'heroSubtitle'   => 'With a proven track record of dismissed charges and reduced penalties, we defend your rights.',
		'heroFeatures'   => array( 'Expert Legal Guidance', 'Tailored Legal Solutions', 'Free Initial Consultation', 'Fast & Efficient Process' ),
		'heroPrimaryBtn' => array( 'text' => 'Explore more', 'href' => 'index.php' ),
		'heroRightSide'  => 'image',
		'heroImage'      => '/assets/images/blogheroimg.png',
	)
);

$heroTitle      = $dm_hero['heroTitle'];
$heroSubtitle   = $dm_hero['heroSubtitle'];
$heroFeatures   = $dm_hero['heroFeatures'];
$heroPrimaryBtn = $dm_hero['heroPrimaryBtn'];
$heroRightSide  = $dm_hero['heroRightSide'];
$heroImage      = $dm_hero['heroImage'];
$heroMinimal    = $dm_hero['heroMinimal'];
$heroBreadcrumb = array( array( 'label' => 'Blogs' ) );

// Only set when provided (this page has no secondary button by default).
if ( ! empty( $dm_hero['heroSecondaryBtn'] ) ) {
	$heroSecondaryBtn = $dm_hero['heroSecondaryBtn'];
}

include DM_LEGAL_DIR . '/inc/parts/hero.php';

/*
 * The grid is driven by real WordPress posts (Posts → All Posts), so blogs are
 * managed from wp-admin. Category buttons are built from the categories that
 * actually have posts. "All Information" is the reset filter that blog-filter.js
 * looks for by name, so it always comes first.
 */
$dm_blog_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
	)
);

$dm_blog_cats  = get_categories( array( 'hide_empty' => true ) );
$dm_fallback_img = '/assets/images/Blogs.jpeg';
?>

<section class="content-width content-gapping">
  <div class="blog-toolbar">
    <div class="blog-toolbar__categories">
      <button type="button" data-blog-category="All Information" class="is-active">All Information</button>
      <?php foreach ( $dm_blog_cats as $cat ) : ?>
        <button type="button" data-blog-category="<?= e( $cat->name ) ?>"><?= e( $cat->name ) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="blog-toolbar__search">
      <input type="text" data-blog-search placeholder="Search" aria-label="Search blog posts">
      <span aria-hidden="true">&#128269;</span>
    </div>
  </div>

  <div class="blog-grid" data-blog-grid>
    <?php
    if ( $dm_blog_query->have_posts() ) :
      while ( $dm_blog_query->have_posts() ) :
        $dm_blog_query->the_post();

        $post_cats  = get_the_category();
        $primary    = ! empty( $post_cats ) ? $post_cats[0]->name : '';
        $post_tags  = get_the_tags();
        $tag_names  = $post_tags ? wp_list_pluck( $post_tags, 'name' ) : array();
        $thumb      = get_the_post_thumbnail_url( get_the_ID(), 'large' );
        $image      = $thumb ? $thumb : url( $dm_fallback_img );
        $avatar     = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 96 ) );
        $keywords   = mb_strtolower( get_the_title() . ' ' . $primary . ' ' . implode( ' ', $tag_names ) );
        ?>
        <div class="card-blog" data-blog-card data-category="<?= e( $primary ) ?>" data-keywords="<?= e( $keywords ) ?>">
          <div class="card-blog__media">
            <a href="<?php the_permalink(); ?>"><img src="<?= e( $image ) ?>" alt="<?= e( get_the_title() ) ?>" loading="lazy" decoding="async"></a>
          </div>
          <div class="card-blog__meta">
            <div class="card-blog__author">
              <img src="<?= e( $avatar ) ?>" alt="" loading="lazy" decoding="async">
              <div>
                <p><?= e( get_the_author() ) ?></p>
                <p><?= e( get_the_date( 'F j, Y' ) ) ?></p>
              </div>
            </div>
            <div class="card-blog__tags">
              <?php foreach ( $tag_names as $tag ) : ?><span><?= e( $tag ) ?></span><?php endforeach; ?>
            </div>
          </div>
          <h3><?= e( get_the_title() ) ?></h3>
          <p class="excerpt"><?= e( truncate_words( wp_strip_all_tags( get_the_excerpt() ), 20 ) ) ?></p>
          <div class="card-blog__link"><a href="<?php the_permalink(); ?>">More Info &rsaquo;</a></div>
        </div>
        <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </div>

  <?php if ( 0 === $dm_blog_query->post_count ) : ?>
    <p class="no-results">No blog posts published yet.</p>
  <?php endif; ?>

  <p class="no-results hidden" data-blog-empty>No blogs found matching your search.</p>

  <div class="blog-toolbar__buttons">
    <button type="button" class="btn-pill btn-pill--primary hidden" data-blog-more>Show More</button>
    <button type="button" class="btn-pill btn-pill--muted hidden" data-blog-less>Show Less</button>
  </div>
</section>

<?php get_footer(); ?>
