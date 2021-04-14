<?php
global $post;

//Baby Information
$month = get_post_meta($post->ID, 'month', true);
$day = get_post_meta($post->ID, 'day', true);
$year = get_post_meta($post->ID, 'year', true);
$birthday = get_post_meta($post->ID, 'birthday', true);
$parents = get_post_meta($post->ID, 'parents', true);
$delivered_by = get_post_meta($post->ID, 'delivered_by', true);
$hour = get_post_meta($post->ID, 'hour', true);
$minute = get_post_meta($post->ID, 'minute', true);
$period = get_post_meta($post->ID, 'period', true);
$lbs= get_post_meta($post->ID, 'lbs', true);
$oz= get_post_meta($post->ID, 'oz', true);
$message_from_the_family = get_post_meta($post->ID, 'message', true);
$share = get_post_meta($post->ID, 'share', true);


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


	global $post;
	if ( have_posts() ) :
		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();
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
								
					                 $largeImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'baby-large');
									
								}
								else{
									$smallImage = "";
									$largeImage ="";
								}

							?>
							
							
							<?php if(!empty($smallImage)){ ?>
								<img src="<?php echo $smallImage[0] ?>" alt="<?php echo $post->post_title; ?>" />
								<a href="<?php echo $largeImage[0] ?>" class="lightbox-link view-<?php echo $gender; ?>">View Larger</a>
							<?php } ?>
							
							
							<a href="/babies/?month=<?php echo $month; ?>" class="back">Back to Nursery</a>

						</div>

						<div class="right">

								<h2 class="baby-name">
									<?php echo $post->post_title; ?>
								</h2>
								<div class="baby-content">
									
									<div class="baby-birthday">
										<h5>Born On</h5>

										<?php
											$monthName = date('F', mktime(0, 0, 0, $month));
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
									<div class="baby-extra">
										<?php if( !empty( $delivered_by ) ){ ?>
										<div class="baby-delivered">
											<h5>Delivered By</h5>
											<?php echo $delivered_by; ?>
											</div>
										<?php } ?>
											
										<?php if( !empty( $message_from_the_family ) ){ ?>	
										<div class="baby-message">
											<h5>From the Family</h5>
											<?php echo $message_from_the_family; ?>
										</div>
									
									<?php } ?>
									</div>
								</div>

						</div>
						
						<div class="baby-share">
							<?php 
							
							if($share == 'checked'){

								//All Shareaholic Buttons
								//echo do_shortcode ('[shareaholic app="share_buttons" id="6476252"]');
								if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); } 
								
					        }
							else{
								//printer friendly button
								//echo do_shortcode ('[shareaholic app="share_buttons" id="6476254"]');
							}
							
							?> 
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