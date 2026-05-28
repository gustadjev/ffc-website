<?php
/**
 * Site header.
 *
 * @package FFCAcademy
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'ffc-academy' ); ?></a>
<div class="utility-bar">
	<div class="utility-bar__inner">
		<span><?php echo esc_html( ffc_option( 'utility_bar_text', __( 'Freedom Futbol Club', 'ffc-academy' ) ) ); ?></span>
		<nav aria-label="<?php esc_attr_e( 'Utility navigation', 'ffc-academy' ); ?>">
			<a href="<?php echo esc_url( ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) ) ); ?>"><?php echo esc_html( ffc_option( 'utility_tryouts_label', __( 'Tryouts', 'ffc-academy' ) ) ); ?></a>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_game' ) ); ?>"><?php echo esc_html( ffc_option( 'utility_schedule_label', __( 'Schedule', 'ffc-academy' ) ) ); ?></a>
			<?php echo ffc_teamsnap_button( ffc_option( 'utility_teamsnap_label', __( 'TeamSnap', 'ffc-academy' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</nav>
	</div>
</div>
<header class="site-header" data-site-header>
	<div class="site-header__inner">
		<div class="brand-lockup">
			<?php echo ffc_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a class="brand-lockup__text" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<strong><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?></strong>
				<span><?php esc_html_e( 'Freedom Futbol Club', 'ffc-academy' ); ?></span>
			</a>
		</div>
		<button class="nav-toggle" type="button" aria-controls="primary-menu" aria-expanded="false" data-nav-toggle>
			<span></span><span></span><span></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'ffc-academy' ); ?></span>
		</button>
		<nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'ffc-academy' ); ?>" data-primary-nav>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'ffc_default_menu',
				)
			);
			?>
		</nav>
		<a class="header-cta" href="<?php echo esc_url( ffc_archive_link_by_slug( 'tryouts', home_url( '/tryouts/' ) ) ); ?>"><?php echo esc_html( ffc_option( 'header_cta_label', __( 'Tryouts', 'ffc-academy' ) ) ); ?></a>
	</div>
</header>
