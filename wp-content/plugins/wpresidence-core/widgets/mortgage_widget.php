<?php
class Mortgage_widget extends WP_Widget {
	function __construct(){
	//function Mortgage_widget(){
		$widget_ops = array('classname' => 'mortgage_calculator_li boxed_widget', 'description' => 'Mortgage Calculator.');
		$control_ops = array('id_base' => 'mortgage_widget');
		//$this->WP_Widget('mortgage_widget', 'Wp Estate: Mortgage', $widget_ops, $control_ops);
                parent::__construct('mortgage_widget', 'Wp Estate: Mortgage', $widget_ops, $control_ops);
	}
	
	function form($instance){
		$defaults = array('title' => 'Contact');
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $title_instance='';
                $display='';
                
                if(isset($instance['title'])){
                   $title_instance=$instance['title'];
                }
                
		$title = apply_filters('widget_title',$title_instance );

		print $before_widget;

		
		$display.='
                <h3 class="widget-title-sidebar"> '.esc_html__('Mortgage Calculator','wpresidence-core').'</h3>
               
                <div id="input_formula">
                    <label for="sale_price">'.esc_html__('Sale Price','wpresidence-core').'</label>    
                    <div class="sale_price_wrapper">    
                        <input type="text" id="sale_price" value="100000" class="form-control">
                    </div>
                    
                    <label for="percent_down">'.esc_html__('Percent Down','wpresidence-core').'</label>    
                    <div class="percent_down_wrapper">    
                        <input type="text" id="percent_down" value="10" class="form-control">
                    </div>
                  
                    <label for="term_years">'.esc_html__('Term (Years)','wpresidence-core').'</label>    
                    <div class="years_wrapper">    
                        <input type="text" id="term_years" value="30" class="form-control">
                    </div>
                    
                    <label for="interest_rate">'.esc_html__('Interest Rate in %','wpresidence-core').'</label>    
                    <div class="interest_wrapper">    
                        <input type="text" id="interest_rate" value="5" class="form-control">
                    </div>
                    
                    <div id="morg_results">
                        <span id="am_fin"></span>
                        <span id="morgage_pay"></span>                      
                        <span id="anual_pay"></span>
                    </div>
                    <button class="wpresidence_button" id="morg_compute">'.esc_html__('Calculate','wpresidence-core').'</button>
                   
            
                
                ';
		
		$display.='</div>';
		print $display;
		print $after_widget;
	}




}

?>