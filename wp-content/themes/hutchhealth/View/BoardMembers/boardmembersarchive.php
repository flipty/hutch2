<?php
	global $post;
	$zindex = 99;
	if ( have_posts() ) :
		echo '<h1>Board of Directors</h1>';
		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();
			do_action( 'genesis_before_entry' );
			printf( '<article %s>', genesis_attr( 'entry' ) );
				do_action( 'genesis_before_entry_content' );
					printf( '<div %s>', genesis_attr( 'entry-content' ) );
					$board_position = get_field('board_position');
					$current_employer = get_field('current_employer');
					$experience_education = get_field('experience_and_education');
					
					?>

					<div class="content-left">
					<?php
					    if ( has_post_thumbnail( $_post->ID ) ) {
					        echo get_the_post_thumbnail( $_post->ID, 'boardmember' );
					    }
				    ?>
					</div>

					<div class ="content-right">
						<h2><?php the_title(); ?></h2>

						<?php if ( $board_position ) { ?>
							<h3 class="heading">Board Position</h3>
							<p class="data"><?php echo $board_position ?></p>
						<?php } ?>

						<?php if ( $current_employer ) { ?>
							<h3 class="heading">Current Employer</h3>						
							<p class="data"><?php echo $current_employer ?></p>
						<?php } ?>
					</div>
					<div class="clear clearfix"></div>
					<?php if ($experience_education != '') { ?>
						<div class="accordion-wrap" style ="z-index:<?php echo $zindex; ?>">
							<div class="accordion">
								<div class="accordion-title">Experience and Education</div>
								<div class="accordion-content" style="display: none;"><?php echo $experience_education; ?></div>
							</div>
						</div>
					<?php } ?>
					
					<?php
					$zindex--;
					echo '</div>';
				do_action( 'genesis_after_entry_content' );
				do_action( 'genesis_entry_footer' );
			echo '</article>';
			do_action( 'genesis_after_entry' );
		endwhile; //* end of one post
		do_action( 'genesis_after_endwhile' );
	else : //* if no posts exist
		do_action( 'genesis_loop_else' );
	endif; //* end loop
	echo '<div class="clear clearfix"></div>';

?>