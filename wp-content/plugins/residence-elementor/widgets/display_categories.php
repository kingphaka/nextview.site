<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


class Wpresidence_Display_Categories extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'WpResidence_Display_Categories';
    }

    public function get_categories()
    {
        return [ 'wpresidence' ];
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
    public function get_title()
    {
        return __('WpResidence Display Categories', 'residence-elementor');
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
    public function get_icon()
    {
        return ' eicon-product-categories';
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
    public function get_script_depends()
    {
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
    public function elementor_transform($input)
    {
        $output=array();
        if (is_array($input)) {
            foreach ($input as $key=>$tax) {
                $output[$tax['value']]=$tax['label'];
            }
        }
        return $output;
    }




    protected function _register_controls()
    {
        global $all_tax;

        $all_tax_elemetor=$this->elementor_transform($all_tax);

        $featured_listings  =   array('no'=>'no','yes'=>'yes');
        $items_type         =   array('properties'=>'properties','articles'=>'articles');
        $alignment_type     =   array('vertical'=>'vertical','horizontal'=>'horizontal');
        $type1_alignment    =   array('one row'=>'one row','multiple rows'=>'multiple rows');
        $list_cities_or_areas=  array(1=>'Design Type 1',2=>'Design Type 2');

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'residence-elementor'),
            ]
        );

        $this->add_control(
            'place_list',
            [
                            'label' => __('Type Categories,Actions,Cities,Areas,Neighborhoods or County name you want to show', 'residence-elementor'),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'options' => $all_tax_elemetor,
            ]
        );

        $this->add_control(
            'place_per_row',
            [
                            'label' => __('Items per row', 'residence-elementor'),
                            'type' => Controls_Manager::TEXT,
                                                      'default' => 1,
            ]
        );



        $this->add_control(
            'place_type',
            [
                            'label' => __('Type', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                                                        'options' => $list_cities_or_areas,
                                                      'default' =>1,
            ]
        );

        $this->add_control(
            'place_type1_align',
            [
                            'label' => __('Type 1 Alingmet', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,

                            'options' => $type1_alignment,
                                                        'default'=>'one row'
            ]
        );




        $this->add_control(
            'extra_class_name',
            [
                            'label' => __('Extra Class Name', 'residence-elementor'),
                            'type' => Controls_Manager::TEXT,
            ]
        );





        $this->end_controls_section();

        /*
        *-------------------------------------------------------------------------------------------------
        * Start Sizes
        */

        $this->start_controls_section(
            'size_section',
            [
                                 'label'     => esc_html__('Item Settings', 'residence-elementor'),
                                 'tab'       => Controls_Manager::TAB_STYLE,
                         ]
        );


        $this->add_responsive_control(
            'item_height',
            [
                            'label' => esc_html__('Item Height', 'residence-elementor'),
                            'type' => Controls_Manager::SLIDER,
                            'range' => [
                                    'px' => [
                                            'min' => 150,
                                            'max' => 500,
                                    ],
                            ],
                            'devices' => [ 'desktop', 'tablet', 'mobile' ],
                            'desktop_default' => [
                                    'size' => 400,
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
                                '{{WRAPPER}} .places_wrapper_type_2' => 'height: {{SIZE}}{{UNIT}}!important;',
                                '{{WRAPPER}} .property_listing.places_listing' => 'height: {{SIZE}}{{UNIT}}!important;',

                    ],
                    ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                            'label' => esc_html__('Border Radius', 'residence-elementor'),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .places_wrapper_type_2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .places_wrapper_type_2 .places_cover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .elementor_places_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                '{{WRAPPER}} .listing_wrapper .property_listing'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                                ],
                    ]
        );


        $this->end_controls_section();

        /*
        *-------------------------------------------------------------------------------------------------
        * Start Typografy
        */

        $this->start_controls_section(
            'typography_section',
            [
                                     'label'     => esc_html__('Typography', 'residence-elementor'),
                                     'tab'       => Controls_Manager::TAB_STYLE,
                             ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                                     'name'     => 'tax_title',
                                     'label'    => esc_html__('Title Typography', 'residence-elementor'),
                                     'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                     'selector' => '{{WRAPPER}} .places_wrapper_type_2 h4 a,{{WRAPPER}} .property_listing h4',
                                     'fields_options' => [
                                             // Inner control name
                                             'font_weight' => [
                                                     // Inner control settings
                                                     'default' => '500',
                                             ],
                                             'font_family' => [
                                                     'default' => 'Roboto',
                                             ],
                                             'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 24 ] ],
                                     ],
                             ]
        );
        $this->add_responsive_control(
            'property_title_margin_bottom',
            [
                                     'label' => esc_html__('Title Margin Bottom(px) - Design Type 2', 'residence-elementor'),
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
                                             '{{WRAPPER}} .places_wrapper_type_2 h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                                     ],

                             ]
        );

        $this->add_responsive_control(
            'property_tagline_margin_bottom',
            [
                                     'label' => esc_html__('Tagline Margin Bottom(px) - Design Type 2', 'residence-elementor'),
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
                                             '{{WRAPPER}} .places_type_2_tagline' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                                     ],
                             ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                                     'name'     => 'tax_tagline',
                                     'label'    => esc_html__('Tagline Typography - Design Type 2', 'residence-elementor'),
                                     'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                     'selector' => '{{WRAPPER}} .places_type_2_tagline',
                                     'fields_options' => [
                                             // Inner control name
                                             'font_weight' => [
                                                     // Inner control settings
                                                     'default' => '300',
                                             ],
                                             'font_family' => [
                                                     'default' => 'Roboto',
                                             ],
                                             'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
                                     ],
                             ]
        );



        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                                     'name'     => 'tax_listings',
                                     'label'    => esc_html__('Listings Text Typography', 'residence-elementor'),
                                     'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                     'selector' => '{{WRAPPER}} .places_type_2_listings_no,{{WRAPPER}} .property_listing.places_listing .property_location',
                                     'fields_options' => [
                                             // Inner control name
                                             'font_weight' => [
                                                     // Inner control settings
                                                     'default' => '300',
                                             ],
                                             'font_family' => [
                                                     'default' => 'Roboto',
                                             ],
                                             'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
                                     ],
                             ]
        );


        $this->add_control(
            'tax_title_color',
            [
                                     'label'     => esc_html__('Title Color', 'residence-elementor'),
                                     'type'      => Controls_Manager::COLOR,
                                     'default'   => '',
                                     'selectors' => [
                                             '{{WRAPPER}} .places_wrapper_type_2 h4 a' => 'color: {{VALUE}}',
                                             '{{WRAPPER}} .property_listing h4'        => 'color: {{VALUE}}',
                                             '{{WRAPPER}} .places_list_1 h4 a'        => 'color: {{VALUE}}',


                                     ],
                             ]
        );

        $this->add_control(
            'tax_tagline_color',
            [
                                     'label'     => esc_html__('Subtitle Color - Design Type2', 'residence-elementor'),
                                     'type'      => Controls_Manager::COLOR,
                                     'default'   => '',
                                     'selectors' => [
                                             '{{WRAPPER}}  .places_type_2_tagline' => 'color: {{VALUE}}',
                                     ],
                             ]
        );

        $this->add_control(
            'tax_listings_color',
            [
                                    'label'     => esc_html__('Listings text Color', 'residence-elementor'),
                                    'type'      => Controls_Manager::COLOR,
                                    'default'   => '',
                                    'selectors' => [
                                            '{{WRAPPER}}  .places_type_2_listings_no' => 'color: {{VALUE}}',
                                            '{{WRAPPER}} .property_listing.places_listing .property_location'  => 'color: {{VALUE}}',
                                    ],
                            ]
        );

        $this->add_control(
            'tax_listings_color_back',
            [
                                    'label'     => esc_html__('Listings Backgorund Color - Design Type2', 'residence-elementor'),
                                    'type'      => Controls_Manager::COLOR,
                                    'default'   => '',
                                    'selectors' => [
                                            '{{WRAPPER}}  .places_type_2_listings_no' => 'background: {{VALUE}}',
                                    ],
                            ]
        );


        $this->add_control(
                       'ovarlay_color_back',
                       [
                                       'label'     => esc_html__( 'Image Overlay Backgorund Color - Design Type2', 'residence-elementor' ),
                                       'type'      => Controls_Manager::COLOR,
                                       'default'   => '',
                                       'selectors' => [
                                                       '{{WRAPPER}}  .places_wrapper_type_2 .places_cover' => 'background: {{VALUE}};opacity: 1;',

                                       ],
                       ]
        );
          

        $this->end_controls_section();
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

    public function wpresidence_send_to_shortcode($input)
    {
        $output='';
        if ($input!=='') {
            $numItems = count($input);
            $i = 0;

            foreach ($input as $key=>$value) {
                $output.=$value;
                if (++$i !== $numItems) {
                    $output.=', ';
                }
            }
        }
        return $output;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $attributes['place_list']          =   $this -> wpresidence_send_to_shortcode($settings['place_list']);
        $attributes['place_per_row']       =   $settings['place_per_row'];
        $attributes['place_type']          =   $settings['place_type'];
        $attributes['place_type1_align']   =   $settings['place_type1_align'];
        $attributes['extra_class_name']    =   $settings['extra_class_name'];
        $attributes['item_height']         =   $settings['item_height'];


        echo  wpestate_places_list_function($attributes);
    }
}
