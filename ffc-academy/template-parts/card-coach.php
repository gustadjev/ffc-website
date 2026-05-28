<?php
$role           = ffc_get_field( 'role_title', get_the_ID() );
$certifications = ffc_get_field( 'certifications', get_the_ID() );
$email          = ffc_get_field( 'contact_email', get_the_ID() );
?>
<article class="coach-card reveal">
	<?php if ( has_post_thumbnail() ) : ?>
		<figure><?php the_post_thumbnail( 'ffc-card', array( 'loading' => 'lazy' ) ); ?></figure>
	<?php endif; ?>
	<div class="coach-card__body">
		<p class="eyebrow"><?php echo esc_html( $role ); ?></p>
		<h2><?php the_title(); ?></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_content(), 28 ) ); ?></p>
		<?php
		if ( $certifications ) :
			?>
			<p class="muted"><?php echo esc_html( $certifications ); ?></p><?php endif; ?>
		<?php
		if ( $email ) :
			?>
			<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php esc_html_e( 'Contact Coach', 'ffc-academy' ); ?></a><?php endif; ?>
	</div>
</article>
