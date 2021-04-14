<?php
                    /**
                     * The Basic Posts Model
                     * @since 12.27.12
                     * @author Mat Lipe
                     */


class Post extends Model{
	
	
	
	
	
	function default_featured_image(){
		
			global $post;
		
			if ( has_post_thumbnail() ) {
					
				$post_image = get_the_post_thumbnail($thumbnail->ID, 'post-feed',  array('class' => 'alignleft post-image') );
				
				echo $post_image;

			} else {
				return;
            
				$category = get_the_category(); 
				$categoryName = $category[0]->slug;

				if($categoryName == 'featured'){
					
					$categoryName = $category[1]->slug;
				}

				switch( $categoryName){
					
					case 'events':

						echo '<img src="'. THEME_DIR .'/images/events-default.png" class="alignleft post-image" alt="Event">';
					
					break;	
				   	
				   	case 'in-our-community':

						echo '<img src="'. THEME_DIR .'/images/community-default.png" class="alignleft post-image" alt="In Our Community">';
					
					break;
					
					case 'newsletters':

						echo '<img src="'. THEME_DIR .'/images/newsletters-default.png" class="alignleft post-image" alt="Newsletter">';
					
					break;
					
					
					case 'recognition-awards':

						echo '<img src="'. THEME_DIR .'/images/awards-default.png" class="alignleft post-image" alt="Recognition & Awards">';
					
					break;
					
					
					case 'safety-quality':

						echo '<img src="'. THEME_DIR .'/images/safety-default.png" class="alignleft post-image" alt="Safety & Quality">';
					
					break;
					
					
					case 'services':

						echo '<img src="'. THEME_DIR .'/images/services-default.png" class="alignleft post-image" alt="Services">';
					
					break;
					
					case 'videos':

						echo '<img src="'. THEME_DIR .'/images/videos-default.png" class="alignleft post-image" alt="Videos">';
					
					break;
					
					default:
						
						echo '<img src="'. THEME_DIR .'/images/services-default.png" class="alignleft post-image" alt="Services">';
				}

			}

	}
    
}
    