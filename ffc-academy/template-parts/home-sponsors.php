<?php
$sponsors = new WP_Query(
	array(
		'post_type'      => 'ffc_sponsor',
		'posts_per_page' => 6,
	)
);
?>
<section class="section sponsor-section">
	<div class="container section-heading">
		<p class="eyebrow"><?php esc_html_e( 'Community Partners', 'ffc-academy' ); ?></p>
		<h2><?php esc_html_e( 'Sponsors Fuel Player Growth', 'ffc-academy' ); ?></h2>
		<a href="<?php echo esc_url( get_post_type_archive_link( 'ffc_sponsor' ) ); ?>"><?php esc_html_e( 'Partner With F.F.C.', 'ffc-academy' ); ?></a>
	</div>
	<div class="container sponsor-grid">
		<?php if ( $sponsors->have_posts() ) : ?>
			<?php
			while ( $sponsors->have_posts() ) :
				$sponsors->the_post();
				?>
				<?php get_template_part( 'template-parts/card', 'sponsor' ); ?>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		<?php else : ?>
			<?php foreach ( array( 'Platinum Partner', 'Community Sponsor', 'Training Partner' ) as $tier ) : ?>
				<article class="sponsor-card sponsor-card--placeholder reveal">
					<span><?php echo esc_html( $tier ); ?></span>
					<h3><?php esc_html_e( 'Partner With F.F.C.', 'ffc-academy' ); ?></h3>
					<p><?php esc_html_e( 'Support youth development, tournament access, and a professional academy environment.', 'ffc-academy' ); ?></p>
					<a href="<?php echo esc_url( ffc_archive_link_by_slug( 'contact', home_url( '/contact/' ) ) ); ?>"><?php esc_html_e( 'Start a Conversation', 'ffc-academy' ); ?></a>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
