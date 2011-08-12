<?php
/**
 * Slider
 *
 * Displays a for the home page
 *
 * @package Prototype
 * @subpackage Template
 */
	
if ( is_home() ) { ?>

<div id="slider-container">

	<div id="slider">

	<?php
		$feature_query = new WP_Query( array( 'post_type' => 'promo', 'posts_per_page' => 10, 'orderby' => 'meta_value_num', 'order' => 'ASC' ) );

		while ( $feature_query->have_posts() ) : $feature_query->the_post(); ?>

			<div class="content">

				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			
			</div>

		<?php endwhile;  ?>
		
		

	</div>
	
	
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
	
	    $('#slider').orbit({
			'animation' : 'horizontal-push',
			'timer' : true,
			'advanceSpeed' : 7000,
			'bullets' : true,
			'startClockOnMouseOut': true,
			'startClockOnMouseOutAfter': 0
	    });
			
	});
</script>

<?php } ?>