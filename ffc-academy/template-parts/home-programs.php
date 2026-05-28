<section class="section section--light academy-summary">
	<div class="container academy-summary__grid">
		<div class="academy-summary__copy">
			<p class="eyebrow"><?php echo esc_html( ffc_get_field( 'home_intro_kicker', get_option( 'page_on_front' ), __( 'Academy Pathway', 'ffc-academy' ) ) ); ?></p>
			<h2><?php echo esc_html( ffc_get_field( 'home_intro_title', get_option( 'page_on_front' ), __( 'Built for Families. Serious About Player Growth.', 'ffc-academy' ) ) ); ?></h2>
			<p><?php echo esc_html( ffc_get_field( 'home_intro_copy', get_option( 'page_on_front' ), __( 'F.F.C. keeps the experience organized for parents and ambitious for players: clear communication, thoughtful coaching, match preparation, and a culture that rewards effort.', 'ffc-academy' ) ) ); ?></p>
		</div>
		<div class="academy-pillars">
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_one_title', get_option( 'page_on_front' ), __( 'Develop', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_one_copy', get_option( 'page_on_front' ), __( 'Technical habits and game intelligence.', 'ffc-academy' ) ) ); ?></span></div>
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_two_title', get_option( 'page_on_front' ), __( 'Compete', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_two_copy', get_option( 'page_on_front' ), __( 'Purposeful matches and tournament readiness.', 'ffc-academy' ) ) ); ?></span></div>
			<div><strong><?php echo esc_html( ffc_get_field( 'home_pillar_three_title', get_option( 'page_on_front' ), __( 'Belong', 'ffc-academy' ) ) ); ?></strong><span><?php echo esc_html( ffc_get_field( 'home_pillar_three_copy', get_option( 'page_on_front' ), __( 'A family-friendly club culture.', 'ffc-academy' ) ) ); ?></span></div>
		</div>
	</div>
</section>
