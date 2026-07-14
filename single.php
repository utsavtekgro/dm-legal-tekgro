<?php
/**
 * Single post template — renders a WordPress post in the DM Legal blog-detail
 * design (hero + article + "Talk to an Expert" sidebar), so posts created in
 * wp-admin match the rest of the site.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$heroTitle      = 'Protect Your Financial Future with Transparent Legal Fees';
	$heroSubtitle   = 'Our experienced lawyers provide clear and predictable pricing, helping you manage your legal matters with confidence.';
	$heroFeatures   = array( 'Fixed Fees for common legal services', 'Hourly Rates where appropriate', 'Manage Legal Costs Effectively', 'Transparent and upfront pricing' );
	$heroPrimaryBtn = array( 'text' => 'Book free consultation', 'href' => 'book-your-lawyer.php' );
	$heroSecondaryBtn = array( 'text' => 'Explore more', 'href' => 'index.php' );
	$heroRightSide  = 'image';
	$heroImage      = '/assets/images/blog-inner.png';
	$heroBreadcrumb = array(
		array( 'label' => 'Blogs', 'href' => 'blogs.php' ),
		array( 'label' => get_the_title() ),
	);

	include DM_LEGAL_DIR . '/inc/parts/hero.php';

	$dm_avatar    = get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 96 ) );
	$dm_role      = get_the_author_meta( 'description' );
	$dm_read_time = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
	?>

	<div class="content-width page-section blog-detail-grid">
	  <article>
	    <header class="blog-article__author">
	      <div class="blog-article__author-row">
	        <img src="<?= e( $dm_avatar ) ?>" alt="<?= e( get_the_author() ) ?>">
	        <div>
	          <h4 class="fw-600"><?= e( get_the_author() ) ?></h4>
	          <?php if ( $dm_role ) : ?>
	            <p class="muted-role"><?= e( $dm_role ) ?></p>
	          <?php endif; ?>
	        </div>
	      </div>
	      <div class="blog-article__meta">
	        <span>Posted on <?= e( get_the_date( 'F j, Y' ) ) ?></span>
	        <span aria-hidden="true">|</span>
	        <span><?= e( $dm_read_time ) ?> Min Read</span>
	      </div>
	    </header>

	    <?php if ( has_post_thumbnail() ) : ?>
	      <div class="card-blog__media mb-4">
	        <?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
	      </div>
	    <?php endif; ?>

	    <section class="blog-article__section entry__content">
	      <?php the_content(); ?>
	      <?php
	      wp_link_pages(
	        array(
	          'before' => '<div class="page-links">',
	          'after'  => '</div>',
	        )
	      );
	      ?>
	    </section>

	    <?php
	    $dm_tags = get_the_tags();
	    if ( $dm_tags ) :
	      ?>
	      <div class="card-blog__tags">
	        <?php foreach ( $dm_tags as $dm_tag ) : ?><span><?= e( $dm_tag->name ) ?></span><?php endforeach; ?>
	      </div>
	    <?php endif; ?>
	  </article>

	  <aside>
	    <div class="sidebar-card">
	      <h2 class="secondary-header">Talk to an Expert</h2>
	      <div class="sidebar-card__experts">
	        <?php foreach ( array( 'expert1', 'expert2', 'expert3', 'expert4', 'expert5', 'expert6' ) as $expert ) : ?>
	          <img src="<?= url( 'assets/images/' . $expert . '.png' ) ?>" alt="" loading="lazy" decoding="async">
	        <?php endforeach; ?>
	      </div>
	      <div class="sidebar-card__buttons">
	        <a class="btn btn-primary btn-full" href="<?= url( 'book-your-lawyer.php' ) ?>">Book Now</a>
	        <a class="btn btn-secondary btn-full" href="tel:<?= e( SITE_PHONE_TEL ) ?>"><?= e( SITE_PHONE_DISPLAY ) ?></a>
	      </div>
	      <div class="sidebar-card__rating">
	        <img src="<?= url( 'assets/icons/google.svg' ) ?>" alt="Google">
	        <p class="rating-score">5.0</p>
	        <p class="muted-xs">(Based on 125 Reviews)</p>
	        <div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
	      </div>
	    </div>
	  </aside>
	</div>

	<?php
endwhile;

get_footer();
