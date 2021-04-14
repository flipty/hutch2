<?php

                     /**
                      * Methods that will be made available to all Controllers
                      * @since 2.2
                      * @author Mat Lipe
                      */



class CareerContactController extends MvcFramework{
        
        /**
         * Will run only once on page load
         * @uses Must have this method
         */
        public function init(){
            
			
		$this->registerPostType( 'career_contact', 
								array( 'supports' => array( 'title' ),
										'exclude_from_search'  => true 
										) 
								);
		

		new MvcMetaBox( 'Contact Information', 'career_contact', array(
																'fields' => array(
																				'email',
																				'textarea_mailing_address' => array( 'name' => 'Mailing_Address')
																			)
																		)
																	);																						
		}
		

        
        
        /**
         * Will run right before the page is rendered
         * @uses Optional Method for using conditional/hooks etc that must be run later in the load
         */
        public function before(){
        	
        }
		
		
		
        
}
    