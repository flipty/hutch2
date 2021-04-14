
<div class="providers entry-content">

	<h1>Find a Physician</h1>


	<div class="top-buttons">

		<div class="left">
	         <a href="/physicians/" class="provider-button selected" id="view-by-specialty">View by Specialty</a>  
	    </div>

	    <div class="middle">
	        <span class="divider"> or </span> 
        </div>

        <div class="right">
	         <a href="/physicians/" class="provider-button" id="view-by-name">View by Name</a>
	    </div>

	</div>


	<!--Display by specialty-->
	<div class="specialties">

	<?php

		    // Gets every "category" (term) in this taxonomy to get the respective posts
		    //$terms = get_terms( 'specialty' );

		    $terms = get_terms( array(
					    'taxonomy' => 'specialty',
					    'hide_empty' => false,
					) );
		    
		    //Get Specialties that have providers assigned
		    //$termCount = wp_count_terms('specialty', 'hide_empty=true');

		    //$termCount = wp_count_terms('specialty', 'hide_empty=false');



		    //Get the total number of terms with providers or have been turned on to display without providers
		    $termTotal = 0;
		    foreach( $terms as $term ){

		    	if($term->count > 0){
		    		$termTotal = $termTotal + 1;
		    	}
		    	else{
		    		$termLookup = "term_" . $term->term_id;
					$termDisplay = get_field('display_if_no_providers_listed', $termLookup);

					if($termDisplay == 'Yes'){
						$termTotal = $termTotal + 1;
					}
		    	}
		    } 

		    //echo 'Term Total: ' . $termTotal;

		    //$terms_half = round($termCount / 2);
		    $terms_half = round($termTotal / 2);

		    $i = 1;

		    echo '<div class="left">';

		    foreach( $terms as $term ) : 



				$termLookup = "term_" . $term->term_id;
				$termDisplay = get_field('display_if_no_providers_listed', $termLookup);

				if( ($term->count > 0 ) || ($termDisplay == 'Yes')){
		    	


			    	//Accordion
			    	echo '<div class="accordion-wrap"><div class="accordion">';

						//Accordion Title
					echo '<div class="accordion-title">' . $term->name .'</div>';



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

						

			        	if( $loop->have_posts() ){

			        		echo '<div class="accordion-content" style="display: none;">';
					
							while( $loop->have_posts() ): $loop->the_post(); global $post;

							    $firstname = get_field( "first_name");
							    $lastname = get_field( "last_name");
							    $initials = get_field( "initials");

							    $name = $lastname . ", " . $firstname;

							    if (!empty($initials)){
							    	$name = $name . ', ' . $initials;
							    }

								echo '<a href="'. get_permalink() . '" class="provider-link">' . $name . '</a>';

							endwhile;
							
							echo '</div>';
						}
						else{
							if($termDisplay == 'Yes'){
								echo '<div class="accordion-content" style="display: none;">';

									     echo wpautop($term->description);

								echo '</div>';

		                    }
						}

			        echo '</div>';
			        echo '</div>';


			        if($i == $terms_half){

			        	echo '</div>';
			        	echo '<div class="middle"></div>';
			        	echo '<div class="right">';
			        }

			        $i =  $i + 1;

		       }

		    endforeach;

		    echo '</div>';
      ?>

	</div>


	<!--Display by name-->
	<div class="name">


		<?php



		    $i = 1;
		    $startRightColumn = 1;

		    echo '<div class="left">';


		    	//Letter
		    	echo '<div class="letter-wrap">';





		        	$args = array(
							    'showposts' => -1,
							    'post_type' => 'provider',
							    'post_status' => 'publish', 
					        	'meta_query'      => array(
									'relation'    => 'AND',
									'first_name' => array(
										'key'     => 'first_name',
										'compare' => 'EXISTS',
									),
									'last_name'   => array(
										'key'     => 'last_name',
										'compare' => 'EXISTS',
									)

								),
								'ignore_custom_sort' => TRUE,
								'orderby'  => array( 
									'last_name' => 'ASC',
									'first_name'   => 'ASC',
								));



					$loop = new WP_Query( $args );



		        	if( $loop->have_posts() ):

				
						while( $loop->have_posts() ): $loop->the_post(); global $post;

						    $firstname = get_field( "first_name");
						    $lastname = get_field( "last_name");
						    $initials = get_field( "initials");



						    if($i == 1){



		        				$firstLetter = substr($lastname, 0, 1);
		        				$currentLetter = $firstLetter;
		        				echo '<div class="names-by-letter"><h4>' . $firstLetter . '</h4>';
			        		}

			        		else{



			        			$firstLetter = substr($lastname, 0, 1);
			        			
			        			if($firstLetter != $currentLetter){

			        				$currentLetter = $firstLetter;
			        				
			        				//If halfway through the alphabet, start the second column
			        				if($currentLetter == 'M' && $startRightColumn == 1){
			        					

								        	echo '</div></div></div>';
								        	echo '<div class="middle"></div>';
								        	echo '<div class="right">';
								        	echo '<div class="names-by-letter"><h4>' . $firstLetter . '</h4>';

								        	$startRightColumn = 0;

			        				}

			        				else{

			        					echo '</div><div class="names-by-letter"><h4>' . $firstLetter . '</h4>';
			        				}

			        			}

			        		}


						    $name = $lastname . ", " . $firstname;

						    if (!empty($initials)){
						    	$name = $name . ', ' . $initials;
						    }

							echo '<p><a href="'. get_permalink() . '" class="provider-link">' . $name . '</a></p>';


							$i =  $i + 1;

							

						endwhile;
						

						
					endif;

		        echo '</div>';


		        

		        



		    echo '</div>';
      ?>





    </div>


</div>