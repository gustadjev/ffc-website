<?php
/**
 * Template Name: Tryout Registration
 * Template Post Type: page
 *
 * @package FFCAcademy
 */

get_header();
$page_id = get_queried_object_id();
$status  = isset( $_GET['tryout'] ) ? sanitize_key( wp_unslash( $_GET['tryout'] ) ) : '';
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Join F.F.C.', 'ffc-academy' ); ?></p>
			<h1><?php esc_html_e( 'Tryout Registration', 'ffc-academy' ); ?></h1>
		</div>
	</section>
	<?php ffc_page_content_section( $page_id ); ?>
	<section class="section section--light">
		<div class="container form-layout">
			<div class="form-intro">
				<h2><?php esc_html_e( 'Start the Player Evaluation Process', 'ffc-academy' ); ?></h2>
				<p><?php esc_html_e( 'Submit player and guardian details so academy staff can place athletes in the correct evaluation group and follow up with next steps.', 'ffc-academy' ); ?></p>
				<?php if ( 'success' === $status ) : ?>
					<div class="notice notice--success" role="status"><?php esc_html_e( 'Registration received. Our staff will follow up soon.', 'ffc-academy' ); ?></div>
				<?php elseif ( 'error' === $status ) : ?>
					<div class="notice notice--error" role="alert"><?php esc_html_e( 'Please check the required fields and try again.', 'ffc-academy' ); ?></div>
				<?php endif; ?>
			</div>
			<form class="tryout-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="ffc_tryout_register">
				<?php wp_nonce_field( 'ffc_tryout_register', 'ffc_tryout_nonce' ); ?>
				<label class="hp-field">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>

				<div class="form-grid">
					<label><?php esc_html_e( 'Player First Name', 'ffc-academy' ); ?><input name="player_first_name" required autocomplete="given-name"></label>
					<label><?php esc_html_e( 'Player Last Name', 'ffc-academy' ); ?><input name="player_last_name" required autocomplete="family-name"></label>
					<label><?php esc_html_e( 'Date of Birth', 'ffc-academy' ); ?><input type="date" name="date_of_birth" required></label>
					<label><?php esc_html_e( 'Age Group', 'ffc-academy' ); ?><input name="age_group" placeholder="U10, U12, U14" required></label>
					<label><?php esc_html_e( 'Preferred Position', 'ffc-academy' ); ?><input name="preferred_position"></label>
					<label><?php esc_html_e( 'Preferred Tryout Date', 'ffc-academy' ); ?><input type="date" name="preferred_tryout_date"></label>
				</div>

				<label><?php esc_html_e( 'Previous Experience', 'ffc-academy' ); ?><textarea name="previous_experience" rows="4"></textarea></label>

				<div class="form-grid">
					<label><?php esc_html_e( 'Parent/Guardian Name', 'ffc-academy' ); ?><input name="parent_name" required></label>
					<label><?php esc_html_e( 'Parent/Guardian Email', 'ffc-academy' ); ?><input type="email" name="parent_email" required autocomplete="email"></label>
					<label><?php esc_html_e( 'Parent/Guardian Phone', 'ffc-academy' ); ?><input type="tel" name="parent_phone" required autocomplete="tel"></label>
					<label><?php esc_html_e( 'Emergency Contact', 'ffc-academy' ); ?><input name="emergency_contact" required></label>
				</div>

				<label><?php esc_html_e( 'Medical Notes', 'ffc-academy' ); ?><textarea name="medical_notes" rows="4"></textarea></label>
				<label><?php esc_html_e( 'Additional Comments', 'ffc-academy' ); ?><textarea name="additional_comments" rows="4"></textarea></label>
				<button class="button button--accent" type="submit"><?php esc_html_e( 'Submit Registration', 'ffc-academy' ); ?></button>
			</form>
		</div>
	</section>
</main>
<?php
get_footer();
