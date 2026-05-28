<?php
$opponent = ffc_get_field( 'opponent', get_the_ID(), get_the_title() );
$date     = ffc_get_field( 'game_datetime', get_the_ID() );
$location = ffc_get_field( 'location', get_the_ID() );
$field    = ffc_get_field( 'field', get_the_ID() );
$homeaway = ffc_get_field( 'home_away', get_the_ID(), 'home' );
$maps     = ffc_get_field( 'maps_url', get_the_ID() );
$teamsnap = ffc_get_field( 'teamsnap_event_url', get_the_ID() );
?>
<article class="match-card reveal" itemscope itemtype="https://schema.org/SportsEvent">
	<meta itemprop="name" content="<?php echo esc_attr( 'F.F.C. vs ' . $opponent ); ?>">
	<?php
	if ( $date ) :
		?>
		<meta itemprop="startDate" content="<?php echo esc_attr( mysql2date( 'c', $date ) ); ?>"><?php endif; ?>
	<div class="match-card__flag"><?php echo esc_html( ucfirst( $homeaway ) ); ?></div>
	<h3><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?> <span><?php esc_html_e( 'vs', 'ffc-academy' ); ?></span> <?php echo esc_html( $opponent ); ?></h3>
	<?php if ( $date ) : ?>
		<time datetime="<?php echo esc_attr( mysql2date( 'c', $date ) ); ?>"><?php echo esc_html( mysql2date( 'D, M j - g:i A', $date ) ); ?></time>
	<?php endif; ?>
	<p itemprop="location"><?php echo esc_html( trim( $location . ( $field ? ' - ' . $field : '' ) ) ); ?></p>
	<div class="card-actions">
		<?php
		if ( $teamsnap ) :
			?>
			<a href="<?php echo esc_url( $teamsnap ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'TeamSnap', 'ffc-academy' ); ?></a><?php endif; ?>
		<?php
		if ( $maps ) :
			?>
			<a href="<?php echo esc_url( $maps ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Map', 'ffc-academy' ); ?></a><?php endif; ?>
	</div>
</article>
