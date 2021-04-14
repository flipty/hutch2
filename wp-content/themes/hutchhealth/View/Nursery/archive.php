<?php
global $post;



?>
<?php
	global $post;
	if ( have_posts() ) :
		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();

			//Baby Information
			$month = get_post_meta($post->ID, 'month', true);
			$day = get_post_meta($post->ID, 'day', true);
			$year = get_post_meta($post->ID, 'year', true);
			$parents = get_post_meta($post->ID, 'parents', true);
			$lbs= get_post_meta($post->ID, 'lbs', true);
			$oz= get_post_meta($post->ID, 'oz', true);
			$hour = get_post_meta($post->ID, 'hour', true);
			$minute = get_post_meta($post->ID, 'minute', true);
			$period = get_post_meta($post->ID, 'period', true);


			$genderCheck = wp_get_post_terms($post->ID, 'Gender');

			if  ($genderCheck[0]->name == 'Girl'){
				$gender = "girl";
			}
			else{
				$gender = "boy";
			}

			if ($period == 2) {
				$periodDisplay = 'pm';
			} else {
				$periodDisplay = 'am';
			}
		
			do_action( 'genesis_before_entry' );
			printf( '<article %s>', genesis_attr( 'entry' ) );

				do_action( 'genesis_before_entry_content' );
				printf( '<div %s>', genesis_attr( 'entry-content' ) );
				?>
					<div class="baby-box">
						<div class="left">
							<?php
								
								if(has_post_thumbnail( $post->ID )){
									$smallImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'baby-small');
								}
								else{
									$smallImage = "";
								}
								
								if(!empty($smallImage)){ 
									echo '<img src="'.$smallImage[0]. '" alt="" />';
								}
							?>
						</div>

						<div class="right">
							<a href="<?php echo get_permalink(); ?>" class="view-<?php echo $gender; ?> read-more">Read More</a>
							<h2 class="baby-name">
								<?php echo $post->post_title; ?>
							</h2>
							<div class="baby-content">
								
								<div class="baby-birthday">
									<h5>Born On</h5>

									<?php
										$monthName = date('M', mktime(0, 0, 0, $month));
										echo $monthName.' '. $day.', ' .$year;
									?>
									
									<?php if( !empty( $parents ) ){ ?>
										<h5>Parents</h5>
										<?php echo $parents; ?>
									<?php } ?>
									
								</div>
								<div class="baby-weight">
									
									<?php if( !empty( $hour )){ ?>
										<h5>Time of Birth</h5>	
										<?php echo $hour. ':' .str_pad($minute, 2, 0, STR_PAD_LEFT). ' ' .$periodDisplay; ?>
									<?php } ?>
									
									
									<?php if( !empty( $lbs )){ ?>
										<h5>Birth Weight</h5>
										<?php echo $lbs; ?> lbs 
										
											<?php if( !empty( $lbs )){ ?>
												<?php echo $oz; ?> oz
											<?php } ?>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>
				<?php
				echo '</div>';
				do_action( 'genesis_after_entry_content' );

			echo '</article>';
			do_action( 'genesis_after_entry' );
		endwhile; //* end of one post
		do_action( 'genesis_after_endwhile' );
	else : //* if no posts exist
		do_action( 'genesis_loop_else' );
	endif; //* end loop
?>
