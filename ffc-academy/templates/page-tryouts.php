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
$age_group_placeholder = ffc_get_field( 'tryout_age_group_placeholder', $page_id, __( 'U10, U12, U14', 'ffc-academy' ) );
$available_sessions    = ffc_get_open_tryout_sessions();
$labels  = array(
	'player_first_name'     => ffc_get_field( 'tryout_label_player_first_name', $page_id, __( 'Player First Name', 'ffc-academy' ) ),
	'player_last_name'      => ffc_get_field( 'tryout_label_player_last_name', $page_id, __( 'Player Last Name', 'ffc-academy' ) ),
	'date_of_birth'         => ffc_get_field( 'tryout_label_date_of_birth', $page_id, __( 'Date of Birth', 'ffc-academy' ) ),
	'age_group'             => ffc_get_field( 'tryout_label_age_group', $page_id, __( 'Age Group', 'ffc-academy' ) ),
	'preferred_position'    => ffc_get_field( 'tryout_label_preferred_position', $page_id, __( 'Preferred Position', 'ffc-academy' ) ),
	'preferred_tryout_date' => ffc_get_field( 'tryout_label_preferred_tryout_date', $page_id, __( 'Preferred Tryout Session', 'ffc-academy' ) ),
	'previous_experience'   => ffc_get_field( 'tryout_label_previous_experience', $page_id, __( 'Previous Experience', 'ffc-academy' ) ),
	'parent_name'           => ffc_get_field( 'tryout_label_parent_name', $page_id, __( 'Parent/Guardian Name', 'ffc-academy' ) ),
	'parent_email'          => ffc_get_field( 'tryout_label_parent_email', $page_id, __( 'Parent/Guardian Email', 'ffc-academy' ) ),
	'parent_phone'          => ffc_get_field( 'tryout_label_parent_phone', $page_id, __( 'Parent/Guardian Phone', 'ffc-academy' ) ),
	'emergency_contact'     => ffc_get_field( 'tryout_label_emergency_contact', $page_id, __( 'Emergency Contact', 'ffc-academy' ) ),
	'medical_notes'         => ffc_get_field( 'tryout_label_medical_notes', $page_id, __( 'Medical Notes', 'ffc-academy' ) ),
	'additional_comments'   => ffc_get_field( 'tryout_label_additional_comments', $page_id, __( 'Additional Comments', 'ffc-academy' ) ),
);
?>
<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'tryout_hero_kicker', $page_id, __( 'Join F.F.C.', 'ffc-academy' ) ) ); ?></p>
			<h1><?php echo esc_html( ffc_get_field( 'tryout_hero_title', $page_id, __( 'Tryout Registration', 'ffc-academy' ) ) ); ?></h1>
		</div>
	</section>
	<section class="section section--light">
		<div class="container form-layout">
			<div class="form-intro">
				<h2><?php echo esc_html( ffc_get_field( 'tryout_intro_title', $page_id, __( 'Start the Player Evaluation Process', 'ffc-academy' ) ) ); ?></h2>
				<p><?php echo esc_html( ffc_get_field( 'tryout_intro_copy', $page_id, __( 'Submit player and guardian details so academy staff can place athletes in the correct evaluation group and follow up with next steps.', 'ffc-academy' ) ) ); ?></p>
				<?php if ( 'success' === $status ) : ?>
					<div class="notice notice--success" role="status"><?php echo esc_html( ffc_get_field( 'tryout_success_message', $page_id, __( 'Registration received. Our staff will follow up soon.', 'ffc-academy' ) ) ); ?></div>
				<?php elseif ( 'error' === $status ) : ?>
					<div class="notice notice--error" role="alert"><?php echo esc_html( ffc_get_field( 'tryout_error_message', $page_id, __( 'Please check the required fields and try again.', 'ffc-academy' ) ) ); ?></div>
				<?php elseif ( 'unavailable' === $status ) : ?>
					<div class="notice notice--error" role="alert"><?php echo esc_html( ffc_get_field( 'tryout_unavailable_message', $page_id, __( 'The selected tryout session is no longer available. Please choose another open session.', 'ffc-academy' ) ) ); ?></div>
				<?php endif; ?>
			</div>
			<?php if ( empty( $available_sessions ) ) : ?>
					<div class="tryout-form tryout-form--closed" role="status">
						<p class="notice notice--info"><?php echo esc_html( ffc_get_field( 'tryout_no_sessions_message', $page_id, __( 'No tryout sessions are currently open. Please check back soon or contact us for the next evaluation window.', 'ffc-academy' ) ) ); ?></p>
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo ffc_button(
							ffc_get_field( 'tryout_no_sessions_button_label', $page_id, __( 'Contact Us', 'ffc-academy' ) ),
							ffc_get_field( 'tryout_no_sessions_button_url', $page_id, home_url( '/contact/' ) ),
							'accent'
						);
						?>
				</div>
			<?php else : ?>
			<form class="tryout-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="ffc_tryout_register">
				<?php wp_nonce_field( 'ffc_tryout_register', 'ffc_tryout_nonce' ); ?>
				<label class="hp-field">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>

				<div class="form-grid">
					<label><?php echo esc_html( $labels['player_first_name'] ); ?><input name="player_first_name" required autocomplete="given-name"></label>
					<label><?php echo esc_html( $labels['player_last_name'] ); ?><input name="player_last_name" required autocomplete="family-name"></label>
					<label><?php echo esc_html( $labels['date_of_birth'] ); ?><input type="date" name="date_of_birth" required></label>
					<label><?php echo esc_html( $labels['age_group'] ); ?><input name="age_group" placeholder="<?php echo esc_attr( $age_group_placeholder ); ?>" required></label>
					<label><?php echo esc_html( $labels['preferred_position'] ); ?><input name="preferred_position"></label>
					<label><?php echo esc_html( $labels['preferred_tryout_date'] ); ?><select name="tryout_session_id" required>
						<option value=""><?php echo esc_html( ffc_get_field( 'tryout_session_placeholder', $page_id, __( 'Select an open tryout session', 'ffc-academy' ) ) ); ?></option>
						<?php foreach ( $available_sessions as $session ) : ?>
							<option value="<?php echo esc_attr( $session->ID ); ?>"><?php echo esc_html( ffc_tryout_session_label( (int) $session->ID ) ); ?></option>
						<?php endforeach; ?>
					</select></label>
				</div>

				<label><?php echo esc_html( $labels['previous_experience'] ); ?><textarea name="previous_experience" rows="4"></textarea></label>

				<div class="form-grid">
					<label><?php echo esc_html( $labels['parent_name'] ); ?><input name="parent_name" required></label>
					<label><?php echo esc_html( $labels['parent_email'] ); ?><input type="email" name="parent_email" required autocomplete="email"></label>
					<label><?php echo esc_html( $labels['parent_phone'] ); ?><input type="tel" name="parent_phone" required autocomplete="tel"></label>
					<label><?php echo esc_html( $labels['emergency_contact'] ); ?><input name="emergency_contact" required></label>
				</div>

				<label><?php echo esc_html( $labels['medical_notes'] ); ?><textarea name="medical_notes" rows="4"></textarea></label>
				<label><?php echo esc_html( $labels['additional_comments'] ); ?><textarea name="additional_comments" rows="4"></textarea></label>
				<?php echo ffc_turnstile_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<button class="button button--accent" type="submit"><?php echo esc_html( ffc_get_field( 'tryout_submit_label', $page_id, __( 'Submit Registration', 'ffc-academy' ) ) ); ?></button>
			</form>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
