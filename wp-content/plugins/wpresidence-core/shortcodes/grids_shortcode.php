<?php
/*
* Widget wpresidence grids function
*
*
*/

if( !function_exists('wpresidence_display_grids') ):
function wpresidence_display_grids($args){
  $display_grids= wpresidence_display_grids_setup();
  $taxonomies   = wpresidence_query_taxonomies($args);

  $type         = intval( $args['type']);
  $place_type   = intval($args['wpresidence_design_type']);
  $use_grid     = $display_grids[$type];

  $item_height_style='';
  $item_height=300;

  $category_tax=$args['grid_taxonomy'];





  $container='<div class="row elementor_wpresidece_grid">';
    foreach(  $use_grid['position'] as $key=>$item_length ){


        //$container.='<div class="elementor_residence_grid_inside"></div>';
        if( isset($taxonomies[$key-1]) ):
          $container.='<div class="'.esc_attr($item_length).' col-sm-12 elementor_residence_grid">';
            ob_start();
              $place_id       = $taxonomies[$key-1]->term_id;
              $category_name  = $taxonomies[$key-1]->name;
              $category_count = $taxonomies[$key-1]->count;

              if($place_type==1){
                  include( locate_template('templates/places_unit_elementor.php' ) );
              }else{
                  include( locate_template('templates/places_unit_type2_elementor.php') );
              }
              $container.=ob_get_contents();
            ob_end_clean();
          $container.='</div>';
        endif;


    }
  $container.='</div>';

  return $container;
}
endif;




/*
*
*
*
*
*
*/

function wpresidence_query_taxonomies($args){
  $requested_tax= $args['grid_taxonomy'];
  $arguments= array(
    'hide_empty' =>   $args['hide_empty_taxonomy'],
    'number'     => 	$args['items_no']	,
    'orderby'    => 	$args['orderby'],
    'order'      =>   $args['order'],
    'taxonomy'   =>   $args['grid_taxonomy'],
  );

  if( !empty($args[$requested_tax]) ){
    $arguments['slug']=$args[$requested_tax];
  }

  $temrs = get_terms($arguments);

  if ( !is_wp_error( $temrs ) ) {
    return $temrs;
  }else{
    return array();
  }


}






/*
* Default values for ELementor wpresidence grids
*
*
*/

if( !function_exists('wpresidence_display_grids_setup') ):
function wpresidence_display_grids_setup(){
  $setup=array(
    1 =>  array(
              'position' => array(
                              1=> 'col-md-8',
                              2=> 'col-md-4',
                              3=> 'col-md-4',
                              4=> 'col-md-4',
                              5=> 'col-md-4',

                            )
          ),
      2 =>  array(
                'position' => array(
                                1=> 'col-md-6',
                                2=> 'col-md-3',
                                3=> 'col-md-3',
                                4=> 'col-md-3',
                                5=> 'col-md-3',
                                6=> 'col-md-6',
                              )
            ),
      3 =>  array(
                'position' => array(
                                  1=> 'col-md-4',
                                  2=> 'col-md-4',
                                  3=> 'col-md-4',
                                  4=> 'col-md-4',
                                  5=> 'col-md-4',
                                  6=> 'col-md-4',
                              )
            ),
        4 =>  array(
                  'position' => array(
                                  1=> 'col-md-4',
                                  2=> 'col-md-4',
                                  3=> 'col-md-4',
                                  4=> 'col-md-6',
                                  5=> 'col-md-6',
                                )
              ),
        5 =>  array(
                  'position' => array(
                                  1=> 'col-md-4',
                                  2=> 'col-md-8',
                                  3=> 'col-md-8',
                                  4=> 'col-md-4',
                                )
              ),
        6 =>  array(
                  'position' => array(
                                  1=> 'col-md-3',
                                  2=> 'col-md-3',
                                  3=> 'col-md-3',
                                  4=> 'col-md-3',
                                  5=> 'col-md-3',
                                  6=> 'col-md-3',
                                  7=> 'col-md-3',
                                  8=> 'col-md-3',
                                )
              ),
  );
  return $setup;
}
endif;
