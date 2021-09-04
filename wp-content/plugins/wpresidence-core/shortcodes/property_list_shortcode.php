<?php
/*
*
*  recent itenms list
*
*
*
*
*/
if( !function_exists('wpestate_recent_posts_pictures_new') ):

function wpestate_recent_posts_pictures_new($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $wpestate_currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $current_user;
    global $curent_fav;
    global $wpestate_property_unit_slider;
    global $wpestate_no_listins_per_row;
    global $wpestate_uset_unit;
    global $wpestate_custom_unit_structure;

    $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit                =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
    $curent_fav                        =    wpestate_return_favorite_listings_per_user();

    $attributes = shortcode_atts(
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'status_ids'            =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '',
                    'control_terms_id'      =>  '',
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'featured_first'        =>  'no',
                    'sort_by'               =>   0,
                    //'price_min'             =>  0,
                  //  'price_max'             =>  9999999999,
                    'card_version'          =>   '',
                ), $attributes) ;


    $shortcode_arguments            =   wpestate_prepare_arguments_shortcode($attributes);
    $wpestate_property_unit_slider  =   wpresidence_get_option('wp_estate_prop_list_slider','');


    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $control_terms_id   =   '';
    $wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';
    $show_featured_only =   '';
    $random_pick        =   '';
    $featured_first     =   '';
    if(isset($shortcode_arguments['featured_first']))  $featured_first =$shortcode_arguments['featured_first'];
    $orderby            =   'meta_value';




    $property_card_type_string = wpestate_return_property_card_type($shortcode_arguments);



    if ($shortcode_arguments['type'] == 'properties') {
      $type = 'estate_property';
    } else if ($shortcode_arguments['type'] == 'agents') {
      $type = 'agents';
    }else{
      $type = 'post';
    }

    if (isset($shortcode_arguments['random_pick'])){
        $random_pick=   $shortcode_arguments['random_pick'];
        if($random_pick==='yes'){
            $orderby    =   'rand';
        }
    }



   $row_number_col       =  wpestate_shortocode_return_column($shortcode_arguments['row_number']);
   if($shortcode_arguments['row_number']==1 && $shortcode_arguments['align']=='vertical'){
        $row_number_col =  0;
   }
    $align        = '';
    $align_class  = '';
    if(isset($shortcode_arguments['align']) && $shortcode_arguments['align']=='horizontal'){
        $align          = "col-md-12";
        $align_class    = 'the_list_view';
        $row_number_col = '12';
    }


    $args = wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);

    if ($shortcode_arguments['type'] == 'properties') {
        $button .= '<div class="listinglink-wrapper_sh_listings">
           <span class="wpresidence_button wpestate_item_list_sh">'.esc_html__('load more listings','wpresidence-core').' </span>
           </div>';
    }else if ($shortcode_arguments['type'] == 'agents') {
        $button .= '<div class="listinglink-wrapper_sh_listings">
           <span class="wpresidence_button wpestate_item_list_sh">'.esc_html__('load agents','wpresidence-core').' </span>
           </div>';
    } else {
        $button .= '<div class="listinglink-wrapper_sh_listings">
           <span class="wpresidence_button wpestate_item_list_sh">  '.esc_html__('load articles','wpresidence-core').' </span>
           </div>';
         $class.=" blogs_wrapper ";
    }


    $category = $shortcode_arguments['category'];
    $action   = $shortcode_arguments['action'];
    $city     = $shortcode_arguments['city'];
    $area     = $shortcode_arguments['area'];
    $state    = $shortcode_arguments['state'];
    $status   = $shortcode_arguments['status'];
    if($category!=''){
        $category.=',';
    }
    if($action!=''){
        $action.=',';
    }
    if($city!=''){
        $city.=',';
    }
    if($area!=''){
        $area.=',';
    }
    if($state!=''){
        $state.=',';
    }

    if($status!=''){
        $status.=',';
    }


    $anime_id='wpestate_sh_anime_'.rand(1,999);
    $return_string .= '<div id="'.$anime_id.'" class="article_container wpestate_anime wpestate_latest_listings_sh bottom-'.$type.' '.$class.'"  '
            . 'data-type="'.$type.'" '
            . 'data-category_ids="'.$category.'" '
            . 'data-action_ids="'.$action.'" '
            . 'data-city_ids="'.$city.'" '
            . 'data-area_ids="'.$area.'" '
            . 'data-state_ids="'.$state.'" '
            . 'data-status_ids="'.$status.'" '
            . 'data-number="'.$shortcode_arguments['number'].'" '
            . 'data-row-number="'.$shortcode_arguments['row_number'].'" '
            . 'data-card-version="'.$shortcode_arguments['card_version'].'" '
            . 'data-align="'.$shortcode_arguments['align'].'" '
            . 'data-show_featured_only="'.$shortcode_arguments['show_featured_only'].'"  '
            . 'data-random_pick="'.$shortcode_arguments['random_pick'].'"  '
            . 'data-featured_first="'.$featured_first.'" '
            . 'data-sort-by="'.$shortcode_arguments['sort_by'].'"'
            . 'data-page="1" >';

    if($shortcode_arguments['title']!=''){
         $return_string .= '<h2 class="shortcode_title">'.$shortcode_arguments['title'].'</h2>';
    }


    if($shortcode_arguments['control_terms_id'] !=''){
        $control_taxonomy_array     =   explode (',',$shortcode_arguments['control_terms_id']);

        $return_string.='<div class="control_tax_wrapper">';
        foreach($control_taxonomy_array as $key=>$term_name){
            $term_data      =   get_term($term_name);
            if(isset($term_data->term_id)){
                $return_string .=   '<div  class="control_tax_sh" data-taxid="'.$term_data->term_id.'" data-taxonomy="'.$term_data->taxonomy.'">'.$term_data->name.'</div>';
            }
        }
        $return_string.='</div>';

    }

    $transient_name= 'wpestate_recent_posts_pictures_query_' . $type . '_' . $category . '_' . $action . '_' . $city . '_' . $area.'_'.$state.'_'.$shortcode_arguments['row_number'].'_'.$shortcode_arguments['number'].'_'.$featured_first;
    $transient_name.='_'.$shortcode_arguments['align'].'_'.$shortcode_arguments['random_pick'];
    $transient_name=wpestate_add_global_details_transient($transient_name);

    $templates=false;
    if(function_exists('wpestate_request_transient_cache')){
        $templates = wpestate_request_transient_cache( $transient_name);
    }




    if( $templates === false || $random_pick=='yes' ) {

        if ($shortcode_arguments['type'] == 'properties') {
              $recent_posts =wpestate_return_filtered_query($args,$featured_first );
        }else{
            $recent_posts = new WP_Query($args);
        }

        $count = 1;

        ob_start();
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            if($type == 'estate_property'){
                include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            } else {
                if(isset($shortcode_arguments['align']) && $shortcode_arguments['align']=='horizontal'){
                    include( locate_template('templates/blog_unit.php') ) ;
                }else{
                    include( locate_template('templates/blog_unit2.php') ) ;
                }
            }
        endwhile;

        $templates = ob_get_contents();
        ob_end_clean();
        if($orderby!=='rand'){
            if(function_exists('wpestate_set_transient_cache')){
                wpestate_set_transient_cache( $transient_name,wpestate_html_compress( $templates ), 60*60*4 );
            }
        }
    }


    $return_string .=$templates;
    $return_string.='<div class="wpestate_listing_sh_loader">
       <div class="new_prelader"></div>
    </div>';
    $return_string .=$button;
    $return_string .= '</div>';

    if ($shortcode_arguments['type'] == 'properties'){
            $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                  //  wpestate_anime("#'.$anime_id.'");
                   // wpestate_property_list_sh("#'.$anime_id.' .wpestate_item_list_sh", "#'.$anime_id.' .control_tax_sh");
                });
                //]]>
            </script>';
    }
    if ($shortcode_arguments['type'] == 'articles'){
            $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    //wpestate_anime("#'.$anime_id.'");
                   // wpestate_property_list_sh("#'.$anime_id.' .wpestate_item_list_sh", "#'.$anime_id.' .control_tax_sh");

                });
                //]]>
            </script>';
    }

    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;


}
endif; // end   wpestate_recent_posts_pictures
