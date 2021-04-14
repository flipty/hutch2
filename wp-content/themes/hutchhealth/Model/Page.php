<?php
                    /**
                     * The Page Model
                     * @since 1.13.13
                     * @author Mat Lipe
                     */


class Page extends Model{
    
	//MyChart scripts
	function mychart_scripts(){
		
		wp_enqueue_script( 'mychart', 'https://www.mychartweb.com/MyChart/scripts/signup_login.js', array(), '1.0.0', true );
	}
}
    