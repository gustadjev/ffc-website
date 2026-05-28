<?php
$opponent       = ffc_get_field( 'opponent', get_the_ID(), get_the_title() );
$date           = ffc_get_field( 'game_datetime', get_the_ID() );
$ffc_score      = ffc_get_field( 'ffc_score', get_the_ID(), '-' );
$opponent_score = ffc_get_field( 'opponent_score', get_the_ID(), '-' );
$result         = ffc_get_field( 'result', get_the_ID(), 'pending' );
$highlights     = ffc_get_field( 'highlights_url', get_the_ID() );
?>
<article class="score-card <?php echo esc_attr( ffc_result_class( $result ) ); ?> reveal">
	<div class="score-card__result"><?php echo esc_html( strtoupper( substr( $result, 0, 1 ) ) ); ?></div>
	<h3><?php esc_html_e( 'F.F.C.', 'ffc-academy' ); ?> <span><?php echo esc_html( $ffc_score ); ?></span></h3>
	<h3><?php echo esc_html( $opponent ); ?> <span><?php echo esc_html( $opponent_score ); ?></span></h3>
	<?php if ( $date ) : ?><time datetime="<?php echo esc_attr( mysql2date( 'c', $date ) ); ?>"><?php echo esc_html( mysql2date( 'M j, Y', $date ) ); ?></time><?php endif; ?>
	<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
	<?php if ( $highlights ) : ?><a href="<?php echo esc_url( $highlights ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Highlights', 'ffc-academy' ); ?></a><?php endif; ?>
</article>
