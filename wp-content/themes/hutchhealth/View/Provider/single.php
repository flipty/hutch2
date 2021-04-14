<?php
	global $post;

	//Baby Information
	$gender = get_post_meta($post->ID, 'gender', true);
	$quote = get_post_meta($post->ID, 'quote', true);
	$videoLink = get_post_meta($post->ID, 'video', true);
	$videoLink_2 = get_post_meta($post->ID, 'video_#2', true);
	$firstname = get_post_meta($post->ID, 'first_name', true);
	$lastname = get_post_meta($post->ID, 'last_name', true);
	$initials = get_post_meta($post->ID, 'initials', true);

	$name = $firstname . " " . $lastname;

	if ( !empty( $videoLink ) && !empty( $videoLink_2 ) ) {
		$videos = 2;
	} else {
		$videos = 1;
	}

	if (!empty($initials)){
		$name = $name . ', ' . $initials;
	}

	$primaryLocation = get_field('primary_location');
	$primayLocationPhoto = get_the_post_thumbnail( $primaryLocation[0]->ID, 'full' );
	$allLocations = get_field('all_locations');
	$providerPhoto = get_the_post_thumbnail( $post->ID, 'video' );
	$board_certified = get_field('board_certified');
?>

<div class="provider entry-content">
	<h1><?php echo $name; ?></h1>

       	<?php
			if(!empty($primayLocationPhoto)){
				echo '<div class="provider-location-photo">';
				      echo $primayLocationPhoto;
				echo '</div>';
			}
			
			//Name of Primary Location
			echo '<div class="provider-location-title">';
				echo $primaryLocation[0]->post_title;
			echo '</div>';

			echo '<div class="provider-details">';
			//Name of Primary Location
			if(!empty($providerPhoto)){
				echo '<div class="provider-photo">';
				      echo $providerPhoto;
				echo '</div>';
			}

			//post content
			if(!empty($post->post_content)){
				echo '<div class="provider-description">';
					echo  wpautop($post->post_content);
				echo '</div>'; 
		     }

		     echo '</div>'; 
		?>

		<!--Proivder Quote-->
		<?php if( !empty( $quote )){ ?>
			<?php echo '<blockquote><p>' . $quote . '</p></blockquote>' ;?>
		<?php } ?>

		<!--Video-->
		<?php if( !empty( $videoLink ) && $videos == 2 ){ 
			$attr = array(
				'src'      => esc_url( $videoLink ),
				'width'    => 357,
				'height'   => 201,
			);

			echo '<div class="video-content left">';

					echo '<div class="videoWrapper">';
					    $embed_code = wp_oembed_get($videoLink, array('width'=>357));
					    echo $embed_code;
					echo '</div>';
			echo '</div>';
		}
		?>

		<?php if( !empty( $videoLink_2 ) && $videos == 2 ){ 
			$attr = array(
				'src'      => esc_url( $videoLink_2 ),
				'width'    => 357,
				'height'   => 201,
			);

			echo '<div class="video-content right">';

					echo '<div class="videoWrapper">';
					    $embed_code = wp_oembed_get($videoLink_2, array('width'=>357));
					    echo $embed_code;
					echo '</div>';

			echo '</div>';
		}
		?>

		<?php if( !empty( $videoLink ) && $videos == 1 ){ 
			$attr = array(
				'src'      => esc_url( $videoLink ),
				'width'    => 750,
				'height'   => 412,
			);

			echo '<div class="video-content left single">';

					echo '<div class="videoWrapper">';
					    $embed_code = wp_oembed_get($videoLink, array('width'=>750));
					    echo $embed_code;
					echo '</div>';
			echo '</div>';
		}
		?>

		<?php if( !empty( $videoLink_2 ) && $videos == 1 ){ 
			$attr = array(
				'src'      => esc_url( $videoLink_2 ),
				'width'    => 750,
				'height'   => 412,
			);

			echo '<div class="video-content right single">';

					echo '<div class="videoWrapper">';
					    $embed_code = wp_oembed_get($videoLink_2, array('width'=>750));
					    echo $embed_code;
					echo '</div>';

			echo '</div>';
		}
		?>

		<div class="provider-box">
			<div class="left">

				<?php

					if(empty($board_certified) || $board_certified =='Yes'){

						echo '<h3 class="subtitle">Board-Certified Specialties</h3>';
					}
					else{

						echo '<h3 class="subtitle">Specialties</h3>';
					}
				?>
				
				<?php

					$terms = wp_get_post_terms($post->ID, 'specialty', array("fields" => "names"));
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					    echo '<ul>';
					    foreach ( $terms as $term ) {
					        echo '<li>' . $term . '</li>';
					    }
					    echo '</ul>';
					 }
				?>

				<?php if( have_rows('professional_interests') ): ?>

					<h3 class="subtitle">Professional Interests</h3>
					<ul>

					<?php while( have_rows('professional_interests') ): the_row(); 

						// vars
						$details = get_sub_field('professional_interests_details');

						?>

						<li>

						    <?php echo $details; ?>

						</li>

					<?php endwhile; ?>

					</ul>
				<?php endif; ?>


				<?php if( have_rows('other_skills') ): ?>

					<h3 class="subtitle">Other Skills</h3>
					<ul>

					<?php while( have_rows('other_skills') ): the_row(); 

						// vars
						$details = get_sub_field('other_skill_details');

						?>

						<li>

						    <?php echo $details; ?>

						</li>

					<?php endwhile; ?>

					</ul>

				<?php endif; ?>
			</div>

			<div class="right">

				<?php if( !empty( $gender )){ ?>
					<h3 class="subtitle">Gender</h3>
					<ul>
					  <li>
						<?php echo $gender ;?>
					  </li>
					 </ul>
				<?php } ?>
				<?php 
					if( have_rows('educational_institutions') || have_rows('residencies') || have_rows('fellowships') || have_rows('memberships') ||  have_rows('internships') ) {
				?>
					<h3 class="subtitle">Education &amp; Experience</h3>
				<?php
					} 
				?>

				<?php if( have_rows('educational_institutions') ): ?>
					<h3 class="subtitle blue">Educational Institutions</h3>
					<ul>
					<?php while( have_rows('educational_institutions') ): the_row(); 
						// vars
						$details = get_sub_field('educational_institutions_details');
						?>
						<li>
						    <?php echo $details; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

				<?php if( have_rows('internships') ): ?>
					<h3 class="subtitle blue">Internships</h3>
					<ul>
					<?php while( have_rows('internships') ): the_row(); 
						// vars
						$details = get_sub_field('internship_details');
						?>
						<li>
						    <?php echo $details; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

				<?php if( have_rows('residencies') ): ?>
					<h3 class="subtitle blue">Residencies</h3>
					<ul>
					<?php while( have_rows('residencies') ): the_row(); 
						// vars
						$details = get_sub_field('residency_details');
						?>
						<li>
						    <?php echo $details; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

				<?php if( have_rows('fellowships') ): ?>
					<h3 class="subtitle blue">Fellowships</h3>
					<ul>
					<?php while( have_rows('fellowships') ): the_row(); 
						// vars
						$details = get_sub_field('fellowship_details');
						?>
						<li>
						    <?php echo $details; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

				<?php if( have_rows('memberships') ): ?>
					<h3 class="subtitle blue">Memberships</h3>
					<ul>
					<?php while( have_rows('memberships') ): the_row(); 
						// vars
						$details = get_sub_field('membership_details');
						?>
						<li>
						    <?php echo $details; ?>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

			  </div>
		</div>
		<div class="location-box">
			<h3 class="subtitle bottom">Locations &amp; Contacts</h3>
			<!--Output the primary location-->
			<?php if( $allLocations ): ?>

			    <?php foreach( $allLocations as $post): // variable must be called $post (IMPORTANT) ?>

			        <?php setup_postdata($post); 
			        $locationLink = get_post_meta($post->ID, 'link', true);
			        ?>
			        <a href="<?php echo $locationLink; ?>" class="button"><?php echo get_the_title( $p->ID ); ?></a>
			    <?php endforeach; ?>

			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
		</div>
		<?php echo do_shortcode('[addtoany]'); ?>
</div>