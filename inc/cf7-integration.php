<?php
/**
 * Contact Form 7 integration. CF7 is a required plugin, installed and
 * activated normally through wp-admin (not bundled as must-use, so the
 * client can update it like any other plugin) — this file shows an admin
 * notice if it's missing, creates the three forms the theme needs on
 * first activation, applies the native honeypot check, and exposes
 * dmlegal_render_contact_form() for templates to call.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dmlegal_is_cf7_active(): bool {
	return function_exists( 'wpcf7_contact_form' );
}

function dmlegal_cf7_missing_notice(): void {
	if ( dmlegal_is_cf7_active() ) {
		return;
	}
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'The DM Legal theme requires the Contact Form 7 plugin to be installed and activated for the contact, booking, and FAQ forms to work.', 'dmlegal' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'dmlegal_cf7_missing_notice' );

/**
 * The three forms this theme needs, keyed by the $context templates pass
 * to dmlegal_render_contact_form(). Created once on theme activation if
 * they don't already exist (matched by title, so re-running is a no-op).
 */
function dmlegal_cf7_form_definitions(): array {
	$honeypot = '<p class="honeypot-wrap" aria-hidden="true">
		<label>' . esc_html__( 'Leave this field blank', 'dmlegal' ) . '</label>
		[text your-website class:honeypot tabindex:-1 autocomplete:off]
	</p>';

	return [
		'hero' => [
			'title' => 'DM Legal — Hero Contact Form',
			'form'  => $honeypot . '
				<p><label for="hero-name">' . esc_html__( 'Full Name', 'dmlegal' ) . '</label>
				[text* your-name id:hero-name class:form-control placeholder "Full Name"]</p>
				<p><label for="hero-email">' . esc_html__( 'Email', 'dmlegal' ) . '</label>
				[email* your-email id:hero-email class:form-control placeholder "Enter Your Email"]</p>
				<p><label for="hero-phone">' . esc_html__( 'Mobile Number', 'dmlegal' ) . '</label>
				[tel* your-phone id:hero-phone class:form-control placeholder "Mobile Number"]</p>
				<p><label for="hero-matter">' . esc_html__( 'Matter Type', 'dmlegal' ) . '</label>
				[select* matter-type id:hero-matter class:form-control first_as_label "Select Matter Type" "Family Law & Property Settlement" "Commercial & Business Law" "Retail Lease Matter" "Professional Registration (AHPRA)" "Debt Recovery" "Immigration & Visa Matter" "Criminal Law Matter" "Other Legal Matter"]</p>
				<p><label for="hero-message">' . esc_html__( 'Message (optional)', 'dmlegal' ) . '</label>
				[textarea your-message id:hero-message class:form-control placeholder "Any Extra Message (optional)"]</p>
				<p>[submit class:btn class:btn-primary class:btn-full "Book Free Consultation"]</p>
			',
			'subject' => __( 'New enquiry from DM Legal website', 'dmlegal' ),
		],
		'faq' => [
			'title' => 'DM Legal — FAQ Contact Form',
			'form'  => $honeypot . '
				<p><label for="faq-name">' . esc_html__( 'Full Name', 'dmlegal' ) . '</label>
				[text* your-name id:faq-name class:form-control placeholder "Full Name"]</p>
				<p><label for="faq-email">' . esc_html__( 'Email', 'dmlegal' ) . '</label>
				[email* your-email id:faq-email class:form-control placeholder "Enter Your Email"]</p>
				<p><label for="faq-phone">' . esc_html__( 'Mobile Number', 'dmlegal' ) . '</label>
				[tel* your-phone id:faq-phone class:form-control placeholder "Mobile Number"]</p>
				<p><label for="faq-subject">' . esc_html__( 'Subject', 'dmlegal' ) . '</label>
				[text* your-subject id:faq-subject class:form-control placeholder "Enter Your Subject"]</p>
				<p><label for="faq-message">' . esc_html__( 'Message (optional)', 'dmlegal' ) . '</label>
				[textarea your-message id:faq-message class:form-control placeholder "Any Extra Message (optional)"]</p>
				<p>[submit class:btn class:btn-primary class:btn-full "Send Your Message"]</p>
			',
			'subject' => __( 'New FAQ enquiry from DM Legal website', 'dmlegal' ),
		],
		'booking' => [
			'title' => 'DM Legal — Booking Form',
			'form'  => $honeypot . '
				[hidden booking-date]
				<div data-step-panel="1" class="step-panel is-active">
					<div class="calendar__panel calendar" data-calendar>
						<p class="label">' . esc_html__( 'Find a time to meet with DM Legal', 'dmlegal' ) . '</p>
						<div class="calendar__head">
							<button type="button" data-calendar-prev aria-label="' . esc_attr__( 'Previous month', 'dmlegal' ) . '">&lsaquo;</button>
							<span data-calendar-month></span>
							<button type="button" data-calendar-next aria-label="' . esc_attr__( 'Next month', 'dmlegal' ) . '">&rsaquo;</button>
						</div>
						<div class="calendar__grid" data-calendar-grid></div>
					</div>
					<button type="button" class="btn btn-primary btn-full" data-step-next>' . esc_html__( 'Next', 'dmlegal' ) . '</button>
				</div>
				<div data-step-panel="2" class="step-panel">
					<p><label for="bk-name">' . esc_html__( 'Full Name', 'dmlegal' ) . '</label>
					[text* your-name id:bk-name class:form-control placeholder "Enter Full Name"]</p>
					<p><label for="bk-email">' . esc_html__( 'Email', 'dmlegal' ) . '</label>
					[email* your-email id:bk-email class:form-control placeholder "Example@gmail.com"]</p>
					<p><label for="bk-phone">' . esc_html__( 'Phone Number', 'dmlegal' ) . '</label>
					[tel* your-phone id:bk-phone class:form-control placeholder "Enter Phone Number"]</p>
					<p><label for="bk-matter">' . esc_html__( 'Type of Matter', 'dmlegal' ) . '</label>
					[select* matter-type id:bk-matter class:form-control first_as_label "Select Matter" "Immigration Law" "Family Law" "Business Law" "Property Law"]</p>
					<button type="button" class="btn btn-primary btn-full" data-step-next>' . esc_html__( 'Next', 'dmlegal' ) . '</button>
					<button type="button" class="btn btn-secondary btn-full" data-step-prev>' . esc_html__( 'Previous', 'dmlegal' ) . '</button>
				</div>
				<div data-step-panel="3" class="step-panel">
					<div class="booking-summary"><p><strong>' . esc_html__( 'Date:', 'dmlegal' ) . '</strong> <span data-summary-date>' . esc_html__( 'Not selected', 'dmlegal' ) . '</span></p></div>
					<p><label for="bk-desc">' . esc_html__( 'Brief Description of Your Situation', 'dmlegal' ) . '</label>
					[textarea* your-description id:bk-desc class:form-control placeholder "Write brief description"]</p>
					<p><label for="bk-contact-method">' . esc_html__( 'Preferred Contact Method', 'dmlegal' ) . '</label>
					[select* contact-method id:bk-contact-method class:form-control first_as_label "Select Preferred Contact" "Phone" "Email" "WhatsApp"]</p>
					<p><label for="bk-contact-time">' . esc_html__( 'Preferred Time for Contact', 'dmlegal' ) . '</label>
					[text* contact-time id:bk-contact-time class:form-control placeholder "e.g. 2:00 PM"]</p>
					<p>[submit class:btn class:btn-primary class:btn-full "Submit"]</p>
					<button type="button" class="btn btn-secondary btn-full" data-step-prev>' . esc_html__( 'Previous', 'dmlegal' ) . '</button>
				</div>
			',
			'subject' => __( 'New booking request from DM Legal website', 'dmlegal' ),
		],
	];
}

/**
 * Create the three forms if they don't already exist. Idempotent — safe
 * to call on every theme activation.
 */
function dmlegal_ensure_cf7_forms(): void {
	if ( ! dmlegal_is_cf7_active() ) {
		return;
	}

	foreach ( dmlegal_cf7_form_definitions() as $definition ) {
		$existing = get_page_by_title( $definition['title'], OBJECT, 'wpcf7_contact_form' );
		if ( $existing ) {
			continue;
		}

		$contact_form = WPCF7_ContactForm::get_template( [ 'title' => $definition['title'] ] );
		$contact_form->set_properties( [
			'form' => $definition['form'],
			'mail' => [
				'active'      => true,
				'subject'     => $definition['subject'],
				'sender'      => '[your-name] <wordpress@' . wp_parse_url( home_url(), PHP_URL_HOST ) . '>',
				'recipient'   => get_option( 'admin_email' ),
				'additional_headers' => 'Reply-To: [your-email]',
				'body'        => __( 'A new submission was received from the DM Legal website:', 'dmlegal' ) . "\n\n[your-name]\n[your-email]\n[your-phone]\n\n[your-message]",
				'attachments' => '',
				'use_html'    => false,
				'exclude_blank' => true,
			],
			'messages' => wpcf7_messages(),
		] );
		$contact_form->save();
	}
}
add_action( 'after_switch_theme', 'dmlegal_ensure_cf7_forms' );

/**
 * Reject submissions with a filled honeypot field as spam. CF7 still
 * shows its normal success message to the submitter (matches the
 * original static site's "silently accept, do nothing" behavior) but
 * skips sending the mail.
 */
function dmlegal_cf7_honeypot_check( bool $spam, WPCF7_Submission $submission ): bool {
	$posted = $submission->get_posted_data();
	if ( ! empty( $posted['your-website'] ) ) {
		return true;
	}
	return $spam;
}
add_filter( 'wpcf7_spam', 'dmlegal_cf7_honeypot_check', 10, 2 );

/**
 * Output the CF7 form for a given context. Templates call this instead
 * of hardcoding shortcodes, so the form-ID-to-context mapping lives in
 * one place.
 */
function dmlegal_render_contact_form( string $context ): void {
	$definitions = dmlegal_cf7_form_definitions();
	if ( ! isset( $definitions[ $context ] ) ) {
		return;
	}

	if ( ! dmlegal_is_cf7_active() ) {
		return;
	}

	$form = get_page_by_title( $definitions[ $context ]['title'], OBJECT, 'wpcf7_contact_form' );
	if ( ! $form ) {
		return;
	}

	echo do_shortcode( '[contact-form-7 id="' . (int) $form->ID . '" title="' . esc_attr( $definitions[ $context ]['title'] ) . '"]' );
}
