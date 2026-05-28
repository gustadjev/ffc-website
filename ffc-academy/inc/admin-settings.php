<?php
/**
 * Native settings fallback for global editable theme content.
 *
 * @package FFCAcademy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ffc_native_settings_fields(): array {
	return array(
		'tryout_page_url'             => array( 'label' => __( 'Tryout Page URL', 'ffc-academy' ), 'type' => 'url' ),
		'utility_bar_text'            => array( 'label' => __( 'Top Bar Text', 'ffc-academy' ), 'type' => 'text' ),
		'utility_tryouts_label'       => array( 'label' => __( 'Top Bar Tryouts Label', 'ffc-academy' ), 'type' => 'text' ),
		'utility_schedule_label'      => array( 'label' => __( 'Top Bar Schedule Label', 'ffc-academy' ), 'type' => 'text' ),
		'utility_teamsnap_label'      => array( 'label' => __( 'Top Bar TeamSnap Label', 'ffc-academy' ), 'type' => 'text' ),
		'header_cta_label'            => array( 'label' => __( 'Header CTA Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_cta_one_label'        => array( 'label' => __( 'Footer CTA 1 Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_cta_one_url'          => array( 'label' => __( 'Footer CTA 1 URL', 'ffc-academy' ), 'type' => 'url' ),
		'footer_cta_two_label'        => array( 'label' => __( 'Footer CTA 2 Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_cta_two_url'          => array( 'label' => __( 'Footer CTA 2 URL', 'ffc-academy' ), 'type' => 'url' ),
		'footer_brand_copy'           => array( 'label' => __( 'Footer Brand Copy', 'ffc-academy' ), 'type' => 'textarea' ),
		'footer_teamsnap_label'       => array( 'label' => __( 'Footer TeamSnap Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_contact_heading'      => array( 'label' => __( 'Footer Contact Heading', 'ffc-academy' ), 'type' => 'text' ),
		'footer_mailing_label'        => array( 'label' => __( 'Footer Mailing Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_mailing_address'      => array( 'label' => __( 'Footer Mailing Address', 'ffc-academy' ), 'type' => 'textarea' ),
		'footer_training_label'       => array( 'label' => __( 'Footer Training Label', 'ffc-academy' ), 'type' => 'text' ),
		'footer_training_text'        => array( 'label' => __( 'Footer Training Text', 'ffc-academy' ), 'type' => 'textarea' ),
		'footer_copyright_note'       => array( 'label' => __( 'Footer Copyright Note', 'ffc-academy' ), 'type' => 'text' ),
		'teamsnap_public_url'         => array( 'label' => __( 'TeamSnap Main Team URL', 'ffc-academy' ), 'type' => 'url' ),
		'teamsnap_schedule_url'       => array( 'label' => __( 'TeamSnap Schedule URL', 'ffc-academy' ), 'type' => 'url' ),
		'teamsnap_roster_url'         => array( 'label' => __( 'TeamSnap Roster URL', 'ffc-academy' ), 'type' => 'url' ),
		'teamsnap_registration_url'   => array( 'label' => __( 'TeamSnap Registration URL', 'ffc-academy' ), 'type' => 'url' ),
		'teamsnap_app_url'            => array( 'label' => __( 'TeamSnap App / Login URL', 'ffc-academy' ), 'type' => 'url' ),
		'teamsnap_embed_code'         => array( 'label' => __( 'TeamSnap Embed Code', 'ffc-academy' ), 'type' => 'textarea' ),
		'instagram_url'               => array( 'label' => __( 'Instagram URL', 'ffc-academy' ), 'type' => 'url' ),
		'facebook_url'                => array( 'label' => __( 'Facebook URL', 'ffc-academy' ), 'type' => 'url' ),
		'youtube_url'                 => array( 'label' => __( 'YouTube URL', 'ffc-academy' ), 'type' => 'url' ),
		'tiktok_url'                  => array( 'label' => __( 'TikTok URL', 'ffc-academy' ), 'type' => 'url' ),
	);
}

add_action( 'admin_menu', 'ffc_register_native_settings_page' );
function ffc_register_native_settings_page(): void {
	if ( function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	add_options_page(
		__( 'F.F.C. Settings', 'ffc-academy' ),
		__( 'F.F.C. Settings', 'ffc-academy' ),
		'manage_options',
		'ffc-theme-settings',
		'ffc_render_native_settings_page'
	);
}

add_action( 'admin_init', 'ffc_register_native_settings' );
function ffc_register_native_settings(): void {
	foreach ( ffc_native_settings_fields() as $key => $field ) {
		register_setting(
			'ffc_native_settings',
			'ffc_' . $key,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'url' === $field['type'] ? 'esc_url_raw' : 'sanitize_textarea_field',
				'default'           => '',
			)
		);
	}
}

function ffc_render_native_settings_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'F.F.C. Settings', 'ffc-academy' ); ?></h1>
		<p><?php esc_html_e( 'Manage global club links, TeamSnap embeds, social links, header labels, and footer content.', 'ffc-academy' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'ffc_native_settings' ); ?>
			<table class="form-table" role="presentation">
				<tbody>
					<?php foreach ( ffc_native_settings_fields() as $key => $field ) : ?>
						<?php $value = get_option( 'ffc_' . $key, '' ); ?>
						<tr>
							<th scope="row"><label for="ffc_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( 'textarea' === $field['type'] ) : ?>
									<textarea class="large-text" rows="4" id="ffc_<?php echo esc_attr( $key ); ?>" name="ffc_<?php echo esc_attr( $key ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
								<?php else : ?>
									<input class="regular-text" type="<?php echo esc_attr( $field['type'] ); ?>" id="ffc_<?php echo esc_attr( $key ); ?>" name="ffc_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
