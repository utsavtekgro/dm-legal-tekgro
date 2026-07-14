<?php
/**
 * Comments template.
 *
 * @package DM_Legal
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Bail on password-protected posts whose password hasn't been entered.
if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-area__title">
			<?php
			$dm_legal_count = get_comments_number();
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s comment', '%s comments', $dm_legal_count, 'dm-legal' ) ),
				esc_html( number_format_i18n( $dm_legal_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'dm-legal' ),
				'next_text' => esc_html__( 'Newer comments', 'dm-legal' ),
			)
		);
	endif;

	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="comments-area__closed"><?php esc_html_e( 'Comments are closed.', 'dm-legal' ); ?></p>
		<?php
	endif;

	comment_form(
		array(
			'class_submit'       => 'button',
			'title_reply_before' => '<h2 class="comment-respond__title">',
			'title_reply_after'  => '</h2>',
		)
	);
	?>
</section>
