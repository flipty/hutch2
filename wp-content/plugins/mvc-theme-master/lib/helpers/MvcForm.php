<?php
        /**
         * MvcForm
		 * 
		 * Form Helpers
		 * 
         * @author Mat Lipe <mat@matlipe.com>
		 * 
         * @uses this will be available in all views via the $MvcForm Variable
		 * 
		 * @class MvcForm
		 * @package MVC
		 * 
		 * @example mvc_form()->text( 'help' );
         * 
         * @TODO Come up with a way to assign attributes to fields such as text
         * 
         */
if( class_exists('MvcForm') ) return;         
class MvcForm {
    
	private static $image_js_out = false;
    
    /**
     * Turns an array of attributes into a usable string
     * 
     * @param array $atts
     * @example array( 'id' => 'my-id', 'name' => 'myname' );
     * 
     * @uses sending a false value will display no attribute
     * @since 5.29.13
     */
    function attributeFactory( $atts ){
        $output = '';
        foreach( $atts as $attr => $value ){
            if( $attr == 'label' ) continue;
            if( $value === false ) continue;
            $output .= ' '.$attr.'="'.$value.'"';   
        }
        
        return substr( $output, 1, 999 );
        
    }
    
    /**
     * Auto generates a form
     * * output of fields
     * * values of fields
     * * saving and retrieving data
     * 
     * @param string $name - must be unique, data will be saved in options table based on name
     * @param $args = array(
     *          'fields'       => array( 
     *                  'checkbox_1' => %name%, 
     *                  'select_%name%' => $args ( 
     *                              options        => array( %key% => %value )
     *                              selected       => %value%
     *                              id             => %string%
     *                              all_label      => %string% ) 
     *                  'textarea_1' => array( 'name' => string, ['mce' => bool]),
     *                  'repeater_%name%' => array( 'checkbox_2' => %name%, 'textarea_1' => %name% ),
     *                  'button_%name%' => $args  => array(
     *                        'class' => %class%,
     *                        'value' => %value%,
     *                        'id'    => %id%
     *                        'onclick' => %onclick%
     *                        'extras'  => array( key => value pairs will be turned into attributes )
     *                      )
     *                  'hidden_%name'  => array( 
     *                                 'id' => %id%,
     *                                 'value' => %value%
     *                                  )
     *                  'image_%name => array(
     *                            'value'        => $value,
                                  'button_label' => 'Upload',
                                  'name'         => $name,
                                  'id'           => $name
     *                  ),
     *          ),
     *          'descriptions' => array(
     *                  'checkbox_1' => 'a little description about the first checkbox - html ok'
     *          ),
     *          'method'       => defaults to post
     *          'action'       => defaults to current page
     *          'submit_button_text' => 'Save',
     *          'data_option_name'   => $name - The name for the stored database option default to $name @param
     *          'no_form'            => Set to true to not have the <form> or <submit> generated for using the input functionality only
     *                     );
     * @param $echo defaults to true
     * @filters apply_filters('mvc-form-'.$name, $output, $args );
     * 
     * @since 2.1
     * 
     * @since 7.18.13
     * 
     * 
     * @TODO Convert this to use the standard MvcMetaBox::metaBoxOutput like checking for arrays and retrieving field names etc
     * 
     */
    function form($name, $args, $echo = true){
        global $MvcFramework;
        $defaults = array(
            'method'             => 'POST',
            'action'             => '#',
            'submit_button_text' => 'Save',
            'data_option_name'   => $name,
            'no_form'            => false
        );
        
        $args = wp_parse_args($args, $defaults);
        
        //Save new Data
        if( isset( $_POST[$name.'-submit']) && wp_verify_nonce($_POST[$name.'_form'], $name.'_form') ){
            $_POST = mvc_util()->arrayFilterRecursive( $_POST );
            update_option($args['data_option_name'], $_POST);
        }
        
        
        $data = get_option($args['data_option_name'], array());

        if( !$args['no_form'] ){
            $output = sprintf('<form id="%s" method="%s" action="%s">', $name, $args['method'], $args['action'] );
            $output .= wp_nonce_field( $name. '_form', $name. '_form', true, false );
        }
        
           
            
            $output .= '<ul>';
    
            //Go through all the fields
            foreach( $args['fields'] as $key => $field ){
                
                $output .= '<li style="list-style: none; margin: 0 0 15px 10px">';
                
              //labels  
                if( is_array( $field ) ){
                    if( strpos($key,'repeater') === false && strpos($key,'hidden') === false ){
                      $this_field = str_replace(array('select_','button_'),array('',''), $key);
                      $label = $MvcFramework->human_format_slug($this_field);
                      $output .= sprintf('<label for="%s">%s : </label> ', $this_field, $label );
                    }
                } else {
                    $label = $MvcFramework->human_format_slug($field);
                    $output .= sprintf('<label for="%s">%s : </label> ', $field, $label );
                }

                 
                 if( isset( $args['descriptions'][$key] ) ){
                    $output .= sprintf('<span class="description">%s</span>', $args['descriptions'][$key]);  
                 }

                 //Checkbox
                 if( strpos($key,'checkbox') !== false ){
                     if( !isset($data[$field]) ) $data[$field] = '';
                     $output .= $this->checkbox($field, $data[$field], false );
                 }
                 
                 //Button
                 if( strpos($key,'button_') !== false ){
                     $field_name = str_replace('button_', '', $key);
                     $output .= $this->button($field_name, $field, false );
                 } 
                  
                    
                //Select Field  
                 elseif( strpos($key,'select_') !== false ){
                    $field_name = str_replace('select_', '', $key);
                    if( !isset($data[$field_name]) ) $data[$field_name] = ''; 
                    $field['selected'] = $data[$field_name];
                    $output .= $this->select($name.'['.$num.']['.$field_name.']', $field, false );            
                
                } 
                
                //textarea field
                elseif( strpos($key,'textarea') !== false ){
                    if( !isset($data[$field]) ) $data[$field] = ''; 
                    $output .= $this->textarea($field, $data[$field], array(), false);
                }
                
                
                //repeater field
                elseif( strpos($key,'repeater') !== false ){
                    $field_name = str_replace('repeater_', '', $key);
                    if( !isset($data[$field_name]) ) $data[$field_name] = ''; 
                    $output .= $this->repeater($field_name, $field, $data[$field_name], array(), false);
                }
                
                //Hidden field
                elseif( strpos($key,'hidden_') !== false ){
                    $field_name = str_replace('hidden_', '', $key);
                   if( !isset($data[$field_name]) ) $data[$field_name] = ''; 
                   $output .= $this->hidden($field_name, $field, false);
                   
                 //Image Upload Form
                 } elseif( strpos($key, 'image_') !== false ){
                     $field_name = str_replace('image_', '', $key);
                     $output .= $this->imageUploadForm($field_name, $data[$field_name], $field, false );
                     
                     
                //Standard Text Field   
                } else {
                   if( !isset($data[$field]) ) $data[$field] = '';
                   $params = array(
                                'value' => $data[$field],
                                'id'    => $field
                                );
                   
                   $output .= $this->text($field, $params, false);
                }
            
            $output .=  '</li>';
        
        } //-- end foreach field
        
        $output .= '</ul>';
        
        if( !$args['no_form'] ){
            $output = apply_filters('mvc-form-'.$name, $output, $args );
            $output .= '<div class="submit">';
                $output .= $this->get_submit_button( $args['submit_button_text'], 'primary', $name.'-submit' );
            $output .= '</div>';
            $output .= '</form>';
        } else {
            $output = apply_filters('mvc-form-'.$name, $output, $name );
        }
        
        if( !$echo ){
            return $output;
        }
        echo $output;
        
    }


     /**
     * Image Upload Form complete with Jquery
     * 
     * @since 2.4.14
     * 
     * @param string $name - the fields name if no specified in the args
     * @param string $value
     * @param array $args - array(
                'value'        => $value,
                'button_label' => 'Upload',
                'name'         => $name,
                'id'           => $name
                  );
     * @param bool $echo (defaults to true );
     * 
     * @uses contains and event called 'MVCImageUploadReturn' which is triggered when a new image is returned
     *       This may be tapped into via js like so JQuery(document).bind("MVCImageUploadReturn", function( e, url ){});
      * 
     * @uses Be sure the ID does not already exist on the dom or this will break
     *
     */
    function imageUploadForm( $name, $value = '', $args = array(), $echo = true ){
    	
       wp_enqueue_media();
         
       $defaults = array(
      		'value'        => $value,
            'button_label' => 'Upload',
            'name'         => $name,
            'id'           => $name,
            'size'         => 36
       );
       
       $args = wp_parse_args($args, $defaults);
       
	   
	   $atts = $args;
	   unset( $atts[ 'button_label' ] );
       
       $input  = sprintf( '<input type="text" %s />', $this->attributeFactory( $args ) );
	   $input .= sprintf( '<input type="button" rel="%s" value="%s" class="button-secondary image_upload" />', $args['id'], $args['button_label'] );
       

       //only display the js once
       if( $been_here ){
           if( $echo ){
                echo $input;
           } else {
                return $input;
           }    
           return;
       }
       
       self::$image_js_out = true;
	   
	   ob_start();
	   
	   echo $input;
       ?>
       
       <script type="text/javascript">
           function handle_mvc_form_image_upload(e){
               var cu = wp.media ({
                    button: {
                        text: 'Use Selected Media'
                    },
                    multiple: false
                    }).on('select', function(){
                        var items = cu.state().get('selection' );
                        var attachment = items.models[0].toJSON ();
                        jQuery.event.trigger('MVCImageUploadReturn', [attachment.url, attachment, attachment]);
                        jQuery("#"+e.attr('rel')).val(attachment.url);
                }).open();
                return false;
           }
           jQuery( function($){
               jQuery('.image_upload').click(function(e){
                    handle_mvc_form_image_upload(jQuery(this));     
                });
            });
      </script>
       
       <?php   
       if( $echo ){
           echo ob_get_clean();
       } else {
           return ob_get_clean();
       }
       
    }
        
        


    /**
     * 
     * Creates an Html Button
     * 
     * @param string $name
     * @param string|array  $args  => array(
     *                        'class' => %class%,
     *                        'value' => %value%,
     *                        'id'    => %id%
     *                        'onclick' => %onclick%
     *                      )
     *        if a string is sent will be converted to value
     * 
     * @param bool $echo - defaults to true
     * 
     * @since 11.12.13
     */
    function button($name, $atts = array(), $echo = true ){
        $defaults = array(
            'id'    => $name,
            'value' => 'Click Here',
            'onclick' => false,
            'class'   => false
        );
        
        if( !is_array( $atts ) ){
             $atts = array(
                'value' => $atts
             );
         }

        $atts = wp_parse_args($atts, $defaults);
        
        $output = '<input type="button" ';
        $output .= $this->attributeFactory($atts);
           
           $output .= '/>';
           
           if( !$echo ){
               return $output;
           }
           
           echo $output;

    }
    
    
    
    
    /**
     * Creates a Textarea
     * 
     * @param string $name
     * @param string $value - defaults to empty
     * @param array  $atts - html attributes
     * @param bool   $echo - defaults to true
     * @param array $args - array(
     *                          'mce' => bool - to use the mce or not (defaults to false)
     *                           )
     * 
     * @since 2.0
     * 
     * @since 5.29.13
     */
    function textarea( $name, $value = '', $atts = array(), $echo = true, $args = array()){
        
           $defaults = array(
               'name' => $name,
               'id'   => $name,
               'cols' => 100,
               'rows' => 3,
           );
           
           $default_args = array(
                'mce' => FALSE
                );
           
           $args = wp_parse_args( $args, $default_args );
           $atts = wp_parse_args($atts, $defaults);
          
           if( $args['mce'] ){
               ob_start();
               wp_editor($value, $atts['name'], array('media_buttons' => false ) );
               $output = ob_get_clean();
           } else {
                $output =  '<br><textarea ';
                $output .= $this->attributeFactory($atts);
                $output .= '>'. htmlspecialchars($value) . '</textarea>';  
           }
           
            
           if( !$echo ){
               return $output;
           }
           echo $output;
    }


    /**
     * meta_checkbox
     *
     * Quick checkbox based on the current posts meta
     * Really all you need is the name and this will take care of everything else
     *
     * @see $this->update_meta_checkbox() for saving the checkbox
     *
     * @param      $name
     * @param null $post_id
     *
     * @return void
     */
    function meta_checkbox( $name, $post_id = null ){
        $post = get_post( $post_id );
        ?>
        <input
            type="checkbox"
            name="<?php echo $name; ?>"
            <?php checked( get_post_meta( $post->ID, $name, true ) ); ?>
            value="1"
            />
        <?php
    }


    /**
     * update_meta_checkbox
     *
     * Quick save a checkbox that is using a value of 1 and post
     * meta data to keep track
     *
     * @see $this->meta_checkbox() for generating the checkbox
     *
     * @param      $name
     * @param null $post_id
     *
     * @return void
     */
    function update_meta_checkbox( $name, $post_id = null ){
        $post_id = get_post( $post_id )->ID;
        if( empty( $_POST[ $name ] ) ){
            update_post_meta( $post_id, $name, 0 );
        } else {
            update_post_meta( $post_id, $name, 1 );
        }
    }


    /**
     * Outputs a Checkbox 
     * 
     * @param string $name
     * @param bool   $checked - defaults to false
     * @param bool   $echo - defaults to true
     * @param array  $atts - (id, value)
     * 
     * 
     * @since 2.0
     * 
     * @since 5.29.13
     */
    function checkbox($name, $checked = false, $echo = true, $atts = array() ){
        
        $defaults = array(
                'id' => $name,
                'value' => 1,
                'name' => $name,
        );
        
        $atts = wp_parse_args($atts, $defaults);

        $output = '<input type="checkbox" '; 
        $output .= $this->attributeFactory($atts);
        $output .= ' '. checked( $checked, true, false ) . '/>';
        
        
        if( !$echo ){
            return $output;
        }
        echo $output;           
    }
    
    
    
    /**
     * Creates repeatable sections using javascript
     * 
     * @param string $name
     * @param $args = array(
     *          'fields'       => array( 
     *                  'checkbox_1' => %name%, 
     *                  'select_%name%' => $args ( 
     *                              options        => array( %key% => %value )
     *                              selected       => %value%
     *                              id             => %string%
     *                              all_label      => %string% )
     *       
     *                  'textarea_1' => %name%,
     *                  'repeater_name' => array( 'checkbox_2' => %name%, 'textarea_1' => %name% ) ,
     *                  'button_%name%' => $args  => array(
     *                        'class' => %class%,
     *                        'value' => %value%,
     *                        'id'    => %id%
     *                        'onclick' => %onclick%
     *                        'extras'  => array( key => value pairs will be turned into attributes )
     *                      )
     *                  'hidden_%name'  => array( 
     *                                 'id' => %id%,
     *                                 'value' => %value%
     *                                  )
     *                  'image_%name => array(
     *                            'value'        => $value,
                                  'button_label' => 'Upload',
                                  'name'         => $name,
                                  'id'           => $name
     *                  ),
     *          'descriptions' => array(
     *                  'checkbox_1' => 'a little description about the first checkbox - html ok'
     *          ),
     *          'button_text' => 'Add Another',
     *          'delete_button' => 'X'
     * )
     * @param array $data - data like values - keys should match field names
     * @param bool  $echo defaults to true
     * 
     * 
     * @since 2.4.14
     * 
     * @TODO find out why you have to click an image twice when using the imageUploadForm and Add Another
     * 
     * @TODO Convert this to use the standard MvcMetaBox::metaBoxOutput like checking for arrays and retrieving field names etc
     * 
     */
    function repeater( $name, $args = array(), $data, $echo = true ){
        $data[] = array(); //Add another so there will be a new available row always
        $defaults = array(
                    'button_text'   => 'Add Another',
                    'delete_button' => ' X '
                    );
        $args = wp_parse_args($args, $defaults);

        $output = sprintf('<ul id="repeater-%s">', $name );
        
        foreach( $data as $num => $row){
            $item = $num;
            //so the new ones may be cloned in javascript    
            if( empty( $row ) ){
             //   $num = '';
            }
 
            
            $output .= '<li style="list-style:none" id="'.$name.'-item-'.$item.'">
                           <ul class="repeater-item">';
            
            //Go through all the fields
            foreach( $args['fields'] as $key => $field ){
                $output .= '<li style="list-style:none">';
              //labels  
                if( is_array( $field ) ){
                    if( strpos($key,'repeater') === false && strpos($key,'hidden') === false ){
                      $this_field = str_replace(array('select_','button_','image_'),array('',''), $key);
                      $label = $this->human_format_slug($this_field);
                      $output .= sprintf('<label for="%s">%s</label> : ', $this_field, $label );
                    }
                } else {
                    $label = $this->human_format_slug($field);
                    $output .= sprintf('<label for="%s">%s</label> : ', $field, $label );
                }

                 
                 if( isset( $args['descriptions'][$key] ) ){
                    $output .= sprintf('<span class="description">%s</span>', $args['descriptions'][$key]);  
                 }

                 //Checkbox
                 if( strpos($key,'checkbox') !== false ){
                     if( !isset($data[$num][$field]) ) $data[$num][$field] = '';
                     $output .= $this->checkbox($name.'['.$num.']['.$field.']', $data[$num][$field], false );
                 } 
                 
                 //Button
                 elseif( strpos($key,'button_') !== false ){
                     $field_name = str_replace('button_', '', $key);
                     $output .= $this->button($field_name, $field, false );
                 } 
                 
                    
                //Select Field  
                 elseif( strpos($key,'select') !== false ){
                    $field_name = str_replace('select_', '', $key);
                    if( !isset($data[$num][$field_name]) ) $data[$num][$field_name] = ''; 
                    $field['selected'] = $data[$num][$field_name];
                    $output .= $this->select($name.'['.$num.']['.$field_name.']', $field, false );
                
                } 
                
                //textarea field
                elseif( strpos($key,'textarea') !== false ){
                    if( !isset($data[$num][$field]) ) $data[$num][$field] = ''; 
                    $output .= $this->textarea($name.'['.$num.']['.$field.']', $data[$num][$field], array(), false);
                }
                
                
                //repeater field
                elseif( strpos($key,'repeater') !== false ){
                    $field_name = str_replace('repeater_', '', $key);
                    if( !isset($data[$num][$field_name]) ) $data[$num][$field_name] = ''; 
                    $output .= $this->repeater($name.'['.$num.']['.$field_name.']', $field, $data[$num][$field_name], array(), false);
                }
                
                //Hidden field
                elseif( strpos($key,'hidden_') !== false ){
                    $field_name = str_replace('hidden_', '', $key);
                   if( !isset($data[$num][$field_name]) ) $data[$num][$field_name] = '';
                   $field['extras'] = array( 'item' => $num );
                   
                   $output .= $this->hidden($name.'['.$num.']['.$field_name.']', $field, false);
                
                //Image Upload Form
                 } elseif( strpos($key, 'image_') !== false ){
                     
                     if( isset( $field['name'] ) ){
                         $field_name = $field['name'];
                         unset( $field['name'] );
                     } else {    
                        $field_name = str_replace('image_', '', $key);
                     }
                     
                     $field['id'] = $name.'-'.$num.'-'.$field_name;

                     $output .= $this->imageUploadForm($name.'['.$num.']['.$field_name.']', $data[$num][$field_name], $field, false ); 

                //Standard Text Field   
                } else {
               
                   if( !isset($data[$num][$field]) ) $data[$num][$field] = '';
                   
                   $params = array(
                                    'value' => $data[$num][$field],
                                    'id'    => $field
                                );
                   $output .= $this->text($name.'['.$num.']['.$field.']', $params, false);
                }

                  $output .=  '</li>';
                  
            }
             
               $output .= '<li class="delete-button"><input type="button" remove="'.$name.'-item-'.$item.'" class="delete" value="'.$args['delete_button'].'" /></li>';
            
              $output .= '</ul>';
            
            $output .= '</li>';

        }
            
        $output .= '</ul>';
        
        $output .= sprintf('<div id="another-%s" class="another">', $name );
        
            $output .= $this->get_submit_button($args['button_text'],'secondary','repeater-add-'.$name, '<div class="repeater-add">', array('id'=> 'repeater-add-'.$name) );
        $output .= '</div>';
        
        $output .= '<div class="clear"></div>';
            
        ob_start();
        ?>
        <script type="text/javascript">
            jQuery(function($){
                var newId;
                var count = 1;
                var self = $('#repeater-<?php echo $name; ?>');
                
                $('#repeater-add-<?php echo $name; ?>').click( function(){
                    var another = $('#repeater-<?php echo $name; ?> > li').last().clone();
                    another.find('[type="text"]').val('');
                    another.find('[type="checkbox"]').attr('checked', false);
                    
                    var oldId = another.find('input').attr('id');
                    another.filter('[id]').each( function(){
                        newId = this.id+count;
                        this.id = newId;
                        another.find('input').not('[type="button"]').attr('id', oldId+count);
                        another.find('input').attr('rel', oldId+count);
                        $(this).html( $(this).html().replace(/<?php echo $name; ?>\[/g,'<?php echo $name; ?>['+count) );
                        $(this).find('.delete').attr('remove',newId);
                        count++;
                    });

                    //In case of the repeater being used with the image uploader
                    jQuery('.repeater-item .image_upload').unbind('click');
                    jQuery('.repeater-item .image_upload').click(function(e){
                        handle_mvc_form_image_upload(jQuery(this));     
                    });
                    
                    $('#repeater-<?php echo $name; ?> > li').last().after(another);
                    self.find('.delete').click( function(){
                        if( self.find('.delete').length > 1 ){
                            $('#'+$(this).attr('remove')).remove();
                        }
                    });
                    
                    return false;
                });
                
                self.find('.delete').click( function(){
                    if( self.find('.delete').length > 1 ){
                        $('#'+$(this).attr('remove')).remove();
                    }
                });
                
            });
        </script>
        <?php
        
        
        $output .= ob_get_clean();
        
        if( !$echo ){
            return $output;
        }
        
        echo $output;
    }
    
    
    
    
    /**
     * Creates a select from an array
     * 
     * 
     * @param sting $name
     * @param array $args ( 
     *                    options        => array( %key% => %value )
     *                    selected       => %value%
     *                    id             => %string%
     *                    all_label      => %string%,
     *                    class          => %string% )
     *                    
     * @param bool $echo display or return default to true
     * 
     * 
     * @uses array( value => display )
     * 
     * @since 2.3.14
     * 
     * 
     */
    function select($name, $args = array(), $echo = true ){
            
           
        if( !$echo ) ob_start();

        $defaults = array(
                            'selected'  => '',
                            'id'        => 'mvc_select',
                            'all_label' => false,
                            'class'     => false
                            );
        $args = wp_parse_args($args, $defaults);
        
        extract( $args );
        
        if( $args['class'] ){
            $args['class'] = 'class="'.$args['class'].'"';
        } 

        printf( '<select name="%s" id="%s" %s>', $name, $id, $args['class']);
            if( $all_label ){
                printf('<option value="">%s</option>', $all_label );
            }
            foreach( $args['options'] as $key => $value ){
                printf('<option value="%s" %s>%s</option>', $key, selected($key, $selected, false ), $value );
            }
        printf('</select>');
        
        
        if( !$echo ) return ob_get_clean();
    }
    
    
    
  /**
     * Creates a text Field
     * @param string $name the field name
     * @param string|array [$atts]  array( 
     *                          'id' => %id%,
     *                          'value' => %value%,
     *                          'name'  => %name%
     *                                  )
     *         if string is sent will use as the value 
     *
     * @param bool $echo defaults to true
     * 
     * @since 11.12.13
     */
    function text($name, $atts = array(), $echo = true){
         $defaults = array(
                       'id'     => $name,
                       'value'  => '',
                       'name'   => $name
                       
         );
         
         if( !is_array( $atts ) ){
             $atts = array(
                        'value' => $atts
             );
         }
            
        $atts = wp_parse_args($atts, $defaults); 

        $output = '<input type="text" ';
        $output .= $this->attributeFactory($atts);
        
        
        $output .= '/>';
        if( $echo ){
            echo $output;
        } else {
            return $output;
        } 
    }



    /**
     * Creates a hidden Field
     * @param string $name the field name
     * @param array $args array( 
     *                          'id' => %id%,
     *                          'value' => %value%
     *                          'extras' => array( key => values turned into attributes )
     *                                  )
     * @param bool $echo defaults to true
     * @since 2.1
     * 
     * @since 12.9.13
     */
    function hidden($name, $args, $echo = true){

        if( !is_array( $args ) ){
            $args = array('value' => $args );   
        }

        $defaults = array(
                       'id'     => false,
                       'value'  => '',
                       'extras' => array()
                       );
        $args = wp_parse_args($args, $defaults); 

        $output = '<input type="hidden" name="'.$name.'" value="'.$args['value'].'" ';
        
        
        if( $args['id'] ){
            $output .= 'id="'.$args['id'].'" ';
        }
        
        foreach( $args['extras'] as $key => $value ){
                $output .= "$key=\"$value\" ";
        }
        
        $output .= '/>';
        if( $echo ){
            echo $output;
        } else {
            return $output;
        } 
    }
    
    
    
    /**
     * Echos a submit button, with provided text and appropriate class
     *
     * @since 0.5.0
     *
     * @param string $text The text of the button (defaults to 'Save Changes')
     * @param string $type The type of button. One of: primary, secondary, delete
     * @param string $name The HTML name of the submit button. Defaults to "submit". If no id attribute
     *               is given in $other_attributes below, $name will be used as the button's id.
     * @param bool $wrap True if the output button should be wrapped in a paragraph tag,
     *             false otherwise. Defaults to true
     * @param array|string $other_attributes Other attributes that should be output with the button,
     *                     mapping attributes to their values, such as array( 'tabindex' => '1' ).
     *                     These attributes will be output as attribute="value", such as tabindex="1".
     *                     Defaults to no other attributes. Other attributes can also be provided as a
     *                     string such as 'tabindex="1"', though the array format is typically cleaner.
     */
    function submitButton( $text = null, $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = null ){
        echo $this->get_submit_button( $text, $type, $name, $wrap, $other_attributes);
    }
    
    
    /**
    * Returns a submit button, with provided text and appropriate class
     *
     * @since 3.1.0
     *
     * @param string $text The text of the button (defaults to 'Save Changes')
     * @param string $type The type of button. One of: primary, secondary, delete
     * @param string $name The HTML name of the submit button. Defaults to "submit". If no id attribute
     *               is given in $other_attributes below, $name will be used as the button's id.
     * @param bool $wrap True if the output button should be wrapped in a paragraph tag,
     *             false otherwise. Defaults to true
     * @param array|string $other_attributes Other attributes that should be output with the button,
     *                     mapping attributes to their values, such as array( 'tabindex' => '1' ).
     *                     These attributes will be output as attribute="value", such as tabindex="1".
     *                     Defaults to no other attributes. Other attributes can also be provided as a
     *                     string such as 'tabindex="1"', though the array format is typically cleaner.
     */
    function get_submit_button( $text = null, $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = null ) {
    if ( ! is_array( $type ) )
        $type = explode( ' ', $type );

    $button_shorthand = array( 'primary', 'small', 'large' );
    $classes = array( 'button' );
    foreach ( $type as $t ) {
        if ( 'secondary' === $t || 'button-secondary' === $t )
            continue;
        $classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
    }
    $class = implode( ' ', array_unique( $classes ) );

    if ( 'delete' === $type )
        $class = 'button-secondary delete';

    $text = $text ? $text : __( 'Save Changes' );

    // Default the id attribute to $name unless an id was specifically provided in $other_attributes
    $id = $name;
    if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
        $id = $other_attributes['id'];
        unset( $other_attributes['id'] );
    }

    $attributes = '';
    if ( is_array( $other_attributes ) ) {
        foreach ( $other_attributes as $attribute => $value ) {
            $attributes .= $attribute . '="' . esc_attr( $value ) . '" '; // Trailing space is important
        }
    } else if ( !empty( $other_attributes ) ) { // Attributes provided as a string
        $attributes = $other_attributes;
    }

    $button = '<input type="submit" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" class="' . esc_attr( $class );
    $button .= '" value="' . esc_attr( $text ) . '" ' . $attributes . ' />';

    if ( $wrap ) {
        $button = '<p class="submit">' . $button . '</p>';
    }

    return $button;
    }


	/********** SINGLETON FUNCTIONS **********/

	/**
	 * Instance of this class for use as singleton
	 */
	private static $instance;

	/**
	 * Get (and instantiate, if necessary) the instance of the class
	 *
	 * @static
	 * @return self
	 */
	public static function get_instance() {
		if( !is_a( self::$instance, __CLASS__ ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

}