<?php
/**
 * Contact page template for the contact slug.
 *
 * @package FFCAcademy
 */

get_header();

$page_id = get_queried_object_id();
if ( ffc_is_builder_page( $page_id ) ) {
	ffc_render_builder_page( $page_id );
	get_footer();
	return;
}

$tryouts = ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) );
$methods = array(
	array(
		'title' => __( 'Tryouts', 'ffc-academy' ),
		'copy'  => __( 'Player evaluations and age-group placement.', 'ffc-academy' ),
	),
	array(
		'title' => __( 'TeamSnap', 'ffc-academy' ),
		'copy'  => __( 'Schedules, rosters, and family logistics.', 'ffc-academy' ),
	),
	array(
		'title' => __( 'Sponsors', 'ffc-academy' ),
		'copy'  => __( 'Partnerships supporting youth development.', 'ffc-academy' ),
	),
);
?>
<main id="primary" class="site-main">
	<section class="page-hero contact-hero">
		<div class="container contact-hero__grid">
			<div>
				<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'contact_hero_kicker', $page_id, __( 'Contact F.F.C.', 'ffc-academy' ) ) ); ?></p>
				<h1><?php echo esc_html( ffc_get_field( 'contact_hero_title', $page_id, __( 'Let\'s Talk Soccer.', 'ffc-academy' ) ) ); ?></h1>
				<p><?php echo esc_html( ffc_get_field( 'contact_hero_copy', $page_id, __( 'Reach out about tryouts, schedules, sponsorship, coaching questions, or community partnerships.', 'ffc-academy' ) ) ); ?></p>
			</div>
			<div class="contact-card">
				<span><?php echo esc_html( ffc_get_field( 'contact_card_label', $page_id, __( 'Fastest Path', 'ffc-academy' ) ) ); ?></span>
				<strong><?php echo esc_html( ffc_get_field( 'contact_card_title', $page_id, __( 'Register for tryouts online.', 'ffc-academy' ) ) ); ?></strong>
				<?php echo ffc_button( ffc_get_field( 'contact_card_button_label', $page_id, __( 'Tryout Form', 'ffc-academy' ) ), ffc_get_field( 'contact_card_button_url', $page_id, $tryouts ), 'accent' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</section>
	<section class="section section--light contact-section">
		<div class="container contact-grid">
			<div class="contact-panel">
				<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'contact_panel_kicker', $page_id, __( 'Club Office', 'ffc-academy' ) ) ); ?></p>
				<h2><?php echo esc_html( ffc_get_field( 'contact_panel_title', $page_id, __( 'How Can We Help?', 'ffc-academy' ) ) ); ?></h2>
				<div class="contact-methods">
					<?php foreach ( $methods as $index => $method ) : ?>
						<?php $number = $index + 1; ?>
						<div><strong><?php echo esc_html( ffc_get_field( "contact_method_{$number}_title", $page_id, $method['title'] ) ); ?></strong><span><?php echo esc_html( ffc_get_field( "contact_method_{$number}_copy", $page_id, $method['copy'] ) ); ?></span></div>
					<?php endforeach; ?>
				</div>
				<?php echo ffc_social_links_markup( 'social-icons', true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="contact-form-panel">
				<?php
				$contact_status = isset( $_GET['ffc_contact_status'] ) ? sanitize_key( wp_unslash( $_GET['ffc_contact_status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( 'success' === $contact_status ) :
					?>
					<div class="notice notice--success" role="status"><?php echo esc_html( ffc_get_field( 'contact_success_message', $page_id, __( 'Message received. Our staff will follow up soon.', 'ffc-academy' ) ) ); ?></div>
					<?php
				elseif ( 'error' === $contact_status ) :
					?>
					<div class="notice notice--error" role="alert"><?php echo esc_html( ffc_get_field( 'contact_error_message', $page_id, __( 'Please check the required fields and try again.', 'ffc-academy' ) ) ); ?></div>
					<?php
				endif;

				$form_shortcode = ffc_get_field( 'contact_form_shortcode', $page_id, '' );
				if ( $form_shortcode ) {
					echo do_shortcode( $form_shortcode );
				} else {
					while ( have_posts() ) :
						the_post();
						$content = get_the_content();
						if ( has_shortcode( $content, 'contact-form-7' ) ) {
							echo do_shortcode( preg_replace( '/.*(\[contact-form-7[^\]]+\]).*/s', '$1', $content ) );
						} else {
							?>
						<form class="tryout-form contact-fallback-form" method="post">
							<input type="hidden" name="ffc_contact_form" value="1">
							<?php wp_nonce_field( 'ffc_contact_form', 'ffc_contact_nonce' ); ?>
							<label class="screen-reader-text" for="ffc_contact_company"><?php esc_html_e( 'Company', 'ffc-academy' ); ?></label>
							<input class="ffc-honeypot" id="ffc_contact_company" name="ffc_contact_company" type="text" tabindex="-1" autocomplete="off">
							<label><?php echo esc_html( ffc_get_field( 'contact_fallback_name_label', $page_id, __( 'Name', 'ffc-academy' ) ) ); ?><input name="ffc_contact_name" type="text" required></label>
							<label><?php echo esc_html( ffc_get_field( 'contact_fallback_email_label', $page_id, __( 'Email', 'ffc-academy' ) ) ); ?><input name="ffc_contact_email" type="email" required></label>
							<label><?php echo esc_html( ffc_get_field( 'contact_fallback_message_label', $page_id, __( 'Message', 'ffc-academy' ) ) ); ?><textarea name="ffc_contact_message" rows="5" required></textarea></label>
							<button class="button button--accent" type="submit"><?php echo esc_html( ffc_get_field( 'contact_fallback_button_label', $page_id, __( 'Send Message', 'ffc-academy' ) ) ); ?></button>
						</form>
							<?php
						}
				endwhile;
				}
				?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
