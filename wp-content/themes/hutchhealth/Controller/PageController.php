<?php
          /**
           * Controller For the Pages
           * @since 1.14.13
           * @author Mat Lipe
           * @uses should extend Controller
           */
    

class PageController extends Controller{
     /**
      * Init will always run on each page load
      */
     function init(){
     	
		
		
     }  
	 
	 
	 function before(){
	 	
		global $post;
		
		if($post->ID == 1448 || $post->ID == 160){

			//Add MyChart Login script
			add_action( 'wp_enqueue_scripts', array($this->Page,'mychart_scripts') );
		}
		
	 }       
}
    