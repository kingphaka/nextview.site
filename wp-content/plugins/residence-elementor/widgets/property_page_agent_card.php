<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Repeater;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Wpresidence_Property_Page_Agent_Card extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Agent_Card';
	}

        public function get_categories() {
		return [ 'wpresidence_property' ];
	}


	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Agent Card', 'residence-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-group';
	}



	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
	return [ '' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
         public function elementor_transform($input){
            $output=array();
            if( is_array($input) ){
                foreach ($input as $key=>$tax){
                    $output[$tax['value']]=$tax['label'];
                }
            }
            return $output;
        }




        protected function _register_controls() {
            $text_align=array('left'=>'left','right'=>'right','center'=>'center');
            $this->start_controls_section(
                    'section_content',
                    [
                            'label' => __( 'Content', 'residence-elementor' ),
                    ]
            );

             $agent_card=array(
                 'one column'=>'one column',
                 'two columns'=>'two columns'
                 );


            $this->add_control(
                    'columns',
                    [
                        'label' => __( 'Columns', 'residence-elementor' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'default' => 'one column'  ,
                        'options' => $agent_card
                    ]
            );



            $this->add_control(
                             'hide_section_phone',
                             [
                                             'label' => esc_html__( 'Hide Phone ', 'residence-elementor' ),
                                             'type' => Controls_Manager::SWITCHER,
                                             'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                             'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                             'return_value' => 'none',
                                             'default' => '',
                                             'selectors' => [
                                                             '{{WRAPPER}}  .agent_phone_class' => 'display: {{VALUE}};',
                                             ],
                             ]
             );

             $this->add_control(
                            'hide_section_mobile',
                            [
                                            'label' => esc_html__( 'Hide Mobile ', 'residence-elementor' ),
                                            'type' => Controls_Manager::SWITCHER,
                                            'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                            'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                            'return_value' => 'none',
                                            'default' => '',
                                            'selectors' => [
                                                            '{{WRAPPER}}  .agent_mobile_class' => 'display: {{VALUE}};',
                                            ],
                            ]
            );
            $this->add_control(
                     'hide_section_email',
                     [
                                     'label' => esc_html__( 'Hide Email ', 'residence-elementor' ),
                                     'type' => Controls_Manager::SWITCHER,
                                     'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                     'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                     'return_value' => 'none',
                                     'default' => '',
                                     'selectors' => [
                                                     '{{WRAPPER}}  .agent_email_class' => 'display: {{VALUE}};',
                                     ],
                     ]
            );
            $this->add_control(
                     'hide_section_skype',
                     [
                                     'label' => esc_html__( 'Hide skype ', 'residence-elementor' ),
                                     'type' => Controls_Manager::SWITCHER,
                                     'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                     'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                     'return_value' => 'none',
                                     'default' => '',
                                     'selectors' => [
                                                     '{{WRAPPER}}  .agent_skype_class' => 'display: {{VALUE}};',
                                     ],
                     ]
            );
            
             $this->add_control(
                     'hide_section_website',
                     [
                                     'label' => esc_html__( 'Hide Website ', 'residence-elementor' ),
                                     'type' => Controls_Manager::SWITCHER,
                                     'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                     'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                     'return_value' => 'none',
                                     'default' => '',
                                     'selectors' => [
                                                     '{{WRAPPER}}  .agent_web_class' => 'display: {{VALUE}};',
                                     ],
                     ]
            );


            $this->add_control(
                     'hide_section_social',
                     [
                                     'label' => esc_html__( 'Hide Social ', 'residence-elementor' ),
                                     'type' => Controls_Manager::SWITCHER,
                                     'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
                                     'label_off' => esc_html__( 'No', 'residence-elementor' ),
                                     'return_value' => 'none',
                                     'default' => '',
                                     'selectors' => [
                                                     '{{WRAPPER}}  .agent_unit_social_single' => 'display: {{VALUE}};',
                                     ],
                     ]
            );

         


            $this->end_controls_section();

         /*-------------------------------------------------------------------------------------------------
        * Start shadow section
        */
        $this->start_controls_section(
          'section_grid_box_shadow',
          [
              'label' => esc_html__( 'Box Shadow', 'residence-elementor' ),
              'tab'   => Controls_Manager::TAB_STYLE,
          ]
          );
          $this->add_group_control(
              Group_Control_Box_Shadow::get_type(),
              [
                  'name'     => 'box_shadow',
                  'label'    => esc_html__( 'Box Shadow', 'residence-elementor' ),
                  'selector' => '{{WRAPPER}} .wpestate_agent_details_wrapper',
              ]
          );

          $this->end_controls_section();
        /*
        *-------------------------------------------------------------------------------------------------
        * End shadow section
        */
        $this->start_controls_section(
                               'section_spacing_margin_section',
                               [
                                               'label'     => esc_html__( 'Spaces & Sizes', 'residence-elementor' ),
                                               'tab'       => Controls_Manager::TAB_STYLE,
                               ]
               );

               $this->add_responsive_control(
                               'property_title_margin_bottom',
                               [
                                               'label' => esc_html__( 'Agent Postion Margin Bottom(px)', 'residence-elementor' ),
                                               'type' => Controls_Manager::SLIDER,
                                               'range' => [
                                                               'px' => [
                                                                               'min' => 0,
                                                                               'max' => 100,
                                                               ],
                                               ],
                                               'devices' => [ 'desktop', 'tablet', 'mobile' ],
                                               'desktop_default' => [
                                                               'size' => '',
                                                               'unit' => 'px',
                                               ],
                                               'tablet_default' => [
                                                               'size' => '',
                                                               'unit' => 'px',
                                               ],
                                               'mobile_default' => [
                                                               'size' => '',
                                                               'unit' => 'px',
                                               ],
                                               'selectors' => [
                                                               '{{WRAPPER}} .agent_position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                                               ],
                               ]
               );

               $this->add_responsive_control(
                        'property_content_padding',
                        [
                                        'label'      => esc_html__( 'Content Area Padding', 'residence-elementor' ),
                                        'type'       => Controls_Manager::DIMENSIONS,
                                        'size_units' => [ 'px', '%', 'em' ],
                                        'selectors'  => [
                                                        '{{WRAPPER}} .wpestate_agent_details_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                        ],
                        ]
        );

        $this->add_responsive_control(
                   'border_radius',
                   [
                       'label' => esc_html__( 'Border Radius', 'residence-elementor' ),
                       'type' => Controls_Manager::DIMENSIONS,
                       'size_units' => [ 'px', '%' ],
                       'selectors' => [
                                                                               '{{WRAPPER}} .wpestate_agent_details_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                                            ],
                   ]
               );

               $this->end_controls_section();
        /*
        *-------------------------------------------------------------------------------------------------
        * End shadow section
        */
        /*
        *-------------------------------------------------------------------------------------------------
        * Start typography section
        */
        $this->start_controls_section(
                        'typography_section',
                        [
                                        'label'     => esc_html__( 'Typography', 'residence-elementor' ),
                                        'tab'       => Controls_Manager::TAB_STYLE,
                        ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                                'name'     => 'property_title',
                                'label'    => esc_html__( 'Agent Name', 'residence-elementor' ),
                                'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                'selector' => '{{WRAPPER}} .agent_details h3',
                ]
        );
        
         $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                                'name'     => 'agent_Details',
                                'label'    => esc_html__( 'Agent Details', 'residence-elementor' ),
                                'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                'selector' => '{{WRAPPER}} .agent_detail',
                ]
        );

      
     $this->end_controls_section();
    /*
    *-------------------------------------------------------------------------------------------------
    * End shadow section
    */
    /*





                                    /*
    *-------------------------------------------------------------------------------------------------
    * Start color section
    */
    $this->start_controls_section(
      'section_colors',
      [
          'label' => esc_html__( 'Colors', 'residence-elementor' ),
          'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'unit_color',
      [
          'label'     => esc_html__( 'Background Color', 'residence-elementor' ),
          'type'      => Controls_Manager::COLOR,
          'default'   => '',
          'selectors' => [
              '{{WRAPPER}} .wpestate_agent_details_wrapper' => 'background-color: {{VALUE}}',
                                                                                            '{{WRAPPER}} .agent_contanct_form  ' => 'background-color: {{VALUE}}',
                                                                                            '{{WRAPPER}} .elementor_agent_wrapper  ' => 'background-color: {{VALUE}}',


                                                                      ],
      ]
);
    $this->add_control(
                   'title_color',
                   [
                                   'label'     => esc_html__( 'Agent Title Color', 'residence-elementor' ),
                                   'type'      => Controls_Manager::COLOR,
                                   'default'   => '',
                                   'selectors' => [
                                                   '{{WRAPPER}} .agent_details h3 a' => 'color: {{VALUE}}',
                                                   '{{WRAPPER}} .agent_details h3' => 'color: {{VALUE}}',
                                   ],
                   ]
    );
    $this->add_control(
                    'unit_font_color',
                    [
                                    'label'     => esc_html__( 'Text Color', 'residence-elementor' ),
                                    'type'      => Controls_Manager::COLOR,
                                    'default'   => '',
                                    'selectors' => [
                                                    '{{WRAPPER}} .wpestate_agent_details_wrapper' => 'color: {{VALUE}}',
                                                    '{{WRAPPER}} .wpestate_agent_details_wrapper a' => 'color: {{VALUE}}',


                                    ],
                    ]
    );
    $this->end_controls_section();
    /*
    *-------------------------------------------------------------------------------------------------
    * End shadow section
    */



	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */

        public function wpresidence_send_to_shortcode($input){
            $output='';
            if($input!==''){
                $numItems = count($input);
                $i = 0;

                foreach ($input as $key=>$value){
                    $output.=$value;
                    if(++$i !== $numItems) {
                      $output.=', ';
                    }
                }
            }
            return $output;
        }
	protected function render() {
            $settings = $this->get_settings_for_display();
            $attributes['is_elementor']      =   1;
            $attributes['columns']            =   $settings['columns'];





            echo  wpestate_estate_property_design_agent($attributes);
	}


}
