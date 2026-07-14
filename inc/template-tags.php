<?php
/**
 * Template tags — reusable, fully-escaped output helpers.
 *
 * Every function here escapes at the point of output. Templates call these
 * instead of hand-rolling markup, so escaping is centralised and auditable.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'dm_legal_posted_on' ) ) :
	/**
	 * Print an accessible, machine-readable published date.
	 *
	 * @return void
	 */
	function dm_legal_posted_on() {
		$time_string = sprintf(
			'<time class="entry__date" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		printf(
			/* translators: %s: post date. */
			'<span class="entry__meta-item">%s</span>',
			wp_kses_post( sprintf( __( 'Published %s', 'dm-legal' ), $time_string ) )
		);
	}
endif;

if ( ! function_exists( 'dm_legal_posted_by' ) ) :
	/**
	 * Print the post author with a link to their archive.
	 *
	 * @return void
	 */
	function dm_legal_posted_by() {
		$author_url  = get_author_posts_url( (int) get_the_author_meta( 'ID' ) );
		$author_name = get_the_author();

		printf(
			'<span class="entry__meta-item">%1$s <a class="entry__author" href="%2$s">%3$s</a></span>',
			esc_html__( 'By', 'dm-legal' ),
			esc_url( $author_url ),
			esc_html( $author_name )
		);
	}
endif;

if ( ! function_exists( 'dm_legal_entry_footer' ) ) :
	/**
	 * Print categories and tags for the current post.
	 *
	 * @return void
	 */
	function dm_legal_entry_footer() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$categories = get_the_category_list( esc_html__( ', ', 'dm-legal' ) );
		if ( $categories ) {
			printf(
				'<span class="entry__terms entry__terms--cat">%1$s %2$s</span>',
				esc_html__( 'Filed under:', 'dm-legal' ),
				wp_kses_post( $categories )
			);
		}

		$tags = get_the_tag_list( '', esc_html__( ', ', 'dm-legal' ) );
		if ( $tags ) {
			printf(
				'<span class="entry__terms entry__terms--tag">%1$s %2$s</span>',
				esc_html__( 'Tagged:', 'dm-legal' ),
				wp_kses_post( $tags )
			);
		}
	}
endif;

if ( ! function_exists( 'dm_legal_post_thumbnail' ) ) :
	/**
	 * Print a responsive, lazily-loaded featured image.
	 *
	 * Skips output on singular views' first paint concerns by loading eagerly
	 * only when the image is likely the LCP element (singular header).
	 *
	 * @param string $size          Registered image size.
	 * @param bool   $is_lcp_candidate Load eagerly + high priority when true.
	 * @return void
	 */
	function dm_legal_post_thumbnail( $size = 'dm-legal-card', $is_lcp_candidate = false ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$attr = array(
			'loading'  => $is_lcp_candidate ? 'eager' : 'lazy',
			'decoding' => 'async',
		);

		if ( $is_lcp_candidate ) {
			$attr['fetchpriority'] = 'high';
		}

		if ( is_singular() ) {
			printf(
				'<figure class="entry__thumbnail">%s</figure>',
				wp_kses_post( get_the_post_thumbnail( null, $size, $attr ) )
			);
		} else {
			printf(
				'<a class="entry__thumbnail-link" href="%1$s" aria-hidden="true" tabindex="-1">%2$s</a>',
				esc_url( get_permalink() ),
				wp_kses_post( get_the_post_thumbnail( null, $size, $attr ) )
			);
		}
	}
endif;

if ( ! function_exists( 'dm_legal_read_more' ) ) :
	/**
	 * Print an accessible "read more" link with screen-reader context.
	 *
	 * @return void
	 */
	function dm_legal_read_more() {
		printf(
			'<a class="entry__more" href="%1$s">%2$s<span class="screen-reader-text"> %3$s</span></a>',
			esc_url( get_permalink() ),
			esc_html__( 'Read more', 'dm-legal' ),
			esc_html( get_the_title() )
		);
	}
endif;
