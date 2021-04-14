<?php
                    /**
                     * The Page Model
                     * @since 1.13.13
                     * @author Mat Lipe
                     */


class Provider extends Model{
	
	function provider_breadcrumbs( $args ) {

		echo '<div class="breadcrumb"><a href="/">Hutch Health</a> &gt; Providers</div>';
    }

    function register_provider_publish_page() {
		add_submenu_page( 'edit.php?post_type=provider', 'Publish Physician List', 'Publish Physician List', 'edit_posts', 'my-custom-submenu-page', array($this,'my_custom_provider_list_callback') ); 
	}

	function my_custom_provider_list_callback() {
		echo '<div class="wrap">'; 

		echo '<h1>Publish Physician Listing to Search by Specialty or Name</h1>';


		if( isset( $_POST['submit'] ) ){


			if( !wp_verify_nonce($_POST['provider-list'], plugin_dir_path(__FILE__) ) ) return;


				ob_start();

				$this->view( 'archive' );

			    $provider_list = ob_get_contents();

			    ob_get_clean();



			    //Publish the provider listing so this can be loaded quickly without having to 
				$thisPost = array(
					'ID'		=> 4343,
		            'post_content'  => $provider_list
		             );

				wp_update_post( $thisPost );


				echo '<p><strong>Physician listings have been updated. Thank you!</strong></p>';

		}
		echo '<form method="post">';

			wp_nonce_field(plugin_dir_path(__FILE__),'provider-list');

			echo '<p>Please publish physician listings to see changes on the live site.  This helps load the provider listing as fast as possible.   Thank you!</p>';
			
			submit_button();

		echo '</form>';

		echo '</div>';
	}

	function display_provider_list() {


			$displayBy = filter_input(INPUT_GET, 'displayBy');
			if($displayBy == 'name'){

				?>

				<!--echo '<style>.providers .specialties{display:none;}.providers .name{display:block;}</style>';-->

				<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('.providers #view-by-name ').addClass( "selected" );
					$('.providers #view-by-specialty').removeClass('selected');
					$( '.providers .specialties' ).css( 'display', 'none' );
				    $( '.providers .name' ).css( 'display', 'block' );
				});
			</script>
	   <?php			
			}



			$page = get_page_by_title( 'Provider List - DO NOT DELETE' );
		if ( $page ) {

		    $content .= $page->post_content;

		}

		echo wpautop(do_shortcode($content));
	}

	function provider_sidebar() {
		return vimm_dynamic_sidebar('provider-sidebar');
	}

	function unhook_ss_sidebars() {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
		remove_action( 'genesis_sidebar_alt', 'ss_do_sidebar_alt' );
	}
}   