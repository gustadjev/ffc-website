<?php $home_id = ffc_home_page_id(); ?>
<section class="section section--light academy-summary">
	<div class="container academy-summary__grid">
		<div class="academy-summary__copy">
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_intro_kicker', $home_id, __( 'Academy Pathway', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_intro_title', $home_id, __( 'Built for Families. Serious About Player Growth.', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo esc_html( ffc_get_field( 'home_intro_copy', $home_id, __( 'F.F.C. keeps the experience organized for parents and ambitious for players: clear communication, thoughtful coaching, match preparation, and a culture that rewards effort.', 'ffc-academy' ) ) ); ?></p>
		</div>
		<div class="academy-pillars">
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_one_title', $home_id, __( 'Develop', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_one_copy', $home_id, __( 'Technical habits and game intelligence.', 'ffc-academy' ) ) ); ?></span></div>
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_two_title', $home_id, __( 'Compete', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_two_copy', $home_id, __( 'Purposeful matches and tournament readiness.', 'ffc-academy' ) ) ); ?></span></div>
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_three_title', $home_id, __( 'Belong', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_three_copy', $home_id, __( 'A family-friendly club culture.', 'ffc-academy' ) ) ); ?></span></div>
		</div>
	</div>
</section>
