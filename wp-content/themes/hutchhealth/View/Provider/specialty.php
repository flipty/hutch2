<?php
	global $post;
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


	$args = array(
		    'showposts' => -1,
		    'post_type' => 'provider',
		    'post_status' => 'publish', 
		    'tax_query' => array(
		        array(
		        'taxonomy' => 'specialty',
		        'field' => 'term_id',
		        'terms' => $term->term_id)
		    ),
		    'ignore_custom_sort' => TRUE,
		    'meta_query'      => array(
				'last_name'   => array(
					'key'     => 'last_name',
					'compare' => 'EXISTS',
				),
				'first_name' => array(
					'key'     => 'first_name',
					'compare' => 'EXISTS',
				)
			),
			'orderby'  => array( 
				'last_name' => 'ASC',
				'first_name'   => 'ASC',
			));


		$loop = new WP_Query( $args );



		echo '<h1>' .$term->name . '</h1>';
		if( $loop->have_posts() ){


	
			while( $loop->have_posts() ): $loop->the_post(); global $post;

			    do_action( 'genesis_before_entry' );
				printf( '<article %s>', genesis_attr( 'entry' ) );
				do_action( 'genesis_before_entry_content' );
					printf( '<div %s>', genesis_attr( 'entry-content' ) );

					?>

					<div class="provider-specialty">
						<?php
						    if ( has_post_thumbnail( $post->ID ) ) {
						    	echo '<a href="'. get_permalink() . '" class="provider-link">';
						        echo get_the_post_thumbnail( $post->ID, 'provider' );
						        echo '</a>';
						    }
					    ?>

				    	<?php echo '<a href="'. get_permalink() . '" class="provider-link">' . get_the_title() . '</a>';?>
					</div>

					<?php

				echo '</div>';
				do_action( 'genesis_after_entry_content' );
				do_action( 'genesis_entry_footer' );
			echo '</article>';
			do_action( 'genesis_after_entry' );


			endwhile;
			

		}


	echo '<div class="clear clearfix"></div>';

?>