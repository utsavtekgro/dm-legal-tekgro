<?php
/**
 * FAQs page — auto-selected for the Page with slug "faqs". Groups the
 * flat _faq_items repeater into category tabs.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $post;

get_template_part( 'template-parts/hero', null, [
	'title'       => __( 'Trusted Legal Solutions – Protecting Your Rights, Securing Your Future', 'dmlegal' ),
	'subtitle'    => __( 'Expert legal guidance in family law, business disputes, immigration, and more – tailored to your needs.', 'dmlegal' ),
	'features'    => [ __( 'Expert Legal Guidance', 'dmlegal' ), __( 'Tailored Legal Solutions', 'dmlegal' ), __( 'Free Initial Consultation', 'dmlegal' ), __( 'Fast & Efficient Process', 'dmlegal' ) ],
	'primary_btn' => [ 'text' => __( 'How to contact us?', 'dmlegal' ), 'url' => dmlegal_get_page_url( 'contact' ) ],
	'secondary_btn' => [ 'text' => __( 'Leave Enquiry', 'dmlegal' ), 'url' => home_url( '/' ) ],
	'right_side'  => 'image',
	'image'       => DMLEGAL_URI . '/assets/images/faqHeroImg.png',
	'breadcrumb'  => [ [ 'label' => __( 'FAQs', 'dmlegal' ) ] ],
] );

$items = get_post_meta( $post->ID, '_faq_items', true );
$items = is_array( $items ) ? $items : [];

$categories = [];
foreach ( $items as $item ) {
	$cat = $item['category'] !== '' ? $item['category'] : __( 'General', 'dmlegal' );
	$categories[ $cat ][] = $item;
}
?>

<section class="content-width content-gapping">
	<div class="section-heading">
		<h2 class="secondary-header"><?php esc_html_e( 'Frequently Asked Questions', 'dmlegal' ); ?></h2>
	</div>

	<?php if ( $categories ) : ?>
		<div class="tabs" data-tabs="faq-categories">
			<?php foreach ( array_keys( $categories ) as $i => $cat ) : ?>
				<button type="button" data-tab-btn="cat-<?php echo esc_attr( sanitize_title( $cat ) ); ?>" class="<?php echo $i === 0 ? 'is-active' : ''; ?>"><?php echo esc_html( $cat ); ?></button>
			<?php endforeach; ?>
		</div>

		<?php $i = 0; foreach ( $categories as $cat => $cat_items ) : ?>
			<div data-tab-panel="cat-<?php echo esc_attr( sanitize_title( $cat ) ); ?>" data-tabs-target="faq-categories" class="<?php echo $i === 0 ? '' : 'hidden'; ?>">
				<div class="faq-list" data-faq-list>
					<?php foreach ( $cat_items as $faq ) : ?>
						<div class="faq-item">
							<div class="faq-item__head">
								<h3><?php echo esc_html( $faq['question'] ); ?></h3>
								<span class="faq-item__icon" aria-hidden="true">
									<svg viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
								</span>
							</div>
							<div class="faq-item__panel"><p class="body-text"><?php echo esc_html( $faq['answer'] ); ?></p></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php $i++; endforeach; ?>
	<?php else : ?>
		<p class="no-results"><?php esc_html_e( 'No FAQs have been added yet.', 'dmlegal' ); ?></p>
	<?php endif; ?>

	<div class="form-card form-card--narrow">
		<h3 class="sub-heading text-center mb-4"><?php esc_html_e( 'Still Have Any Question?', 'dmlegal' ); ?></h3>
		<?php if ( function_exists( 'dmlegal_render_contact_form' ) ) {
			dmlegal_render_contact_form( 'faq' );
		} ?>
	</div>

	<div class="faq-cta">
		<h3><?php esc_html_e( 'Direct Connect With Us', 'dmlegal' ); ?></h3>
		<p><?php esc_html_e( "Can't find the answer you're looking for? Please chat to our friendly team.", 'dmlegal' ); ?></p>
		<a class="btn btn-primary" href="<?php echo esc_url( dmlegal_get_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'dmlegal' ); ?></a>
	</div>
</section>

<?php get_footer(); ?>
