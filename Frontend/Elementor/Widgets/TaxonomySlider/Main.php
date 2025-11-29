<?php
namespace BlogKit\Frontend\Elementor\Widgets\TaxonomySlider;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Main extends Widget_Base
{

    public function get_name()
    {
        return 'taxonomy_slider';
    }
    public function get_title()
    {
        return 'Taxonomy Slider';
    }
    public function get_icon()
    {
        return 'eicon-slider-full-screen';
    }
    public function get_categories()
    {
        return ['general'];
    }

    public function get_script_depends()
    {
        return ['swiper-bundle-js'];
    }
    public function get_style_depends()
    {
        return ['swiper-bundle-css', 'blogkit-elementor-style'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('slides', ['label' => 'Slides']);

        // Slider Settings Desktop
        $this->add_control('slides_per_desktop', [
            'label' => 'Slides per View (Desktop)',
            'type' => Controls_Manager::NUMBER,
            'default' => 6
        ]);
        $this->add_control('space_between_desktop', [
            'label' => 'Space Between Slides (Desktop)',
            'type' => Controls_Manager::NUMBER,
            'default' => 30
        ]);
        $this->add_control(
            'divider_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // Slider Settings Tablet
        $this->add_control('slides_per_tablet', [
            'label' => 'Slides per View (Tablet)',
            'type' => Controls_Manager::NUMBER,
            'default' => 3
        ]);
        $this->add_control('space_between_tablet', [
            'label' => 'Space Between Slides (Tablet)',
            'type' => Controls_Manager::NUMBER,
            'default' => 30
        ]);
        $this->add_control(
            'divider_2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // Slider Settings Mobile
        $this->add_control('slides_per_mobile', [
            'label' => 'Slides per View (Mobile)',
            'type' => Controls_Manager::NUMBER,
            'default' => 2
        ]);
        $this->add_control('space_between_mobile', [
            'label' => 'Space Between Slides (Mobile)',
            'type' => Controls_Manager::NUMBER,
            'default' => 20
        ]);
        $this->add_control(
            'divider_3',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $this->add_control('autoplay', [
            'label' => 'Autoplay',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);
        // Autoplay Speed
        $this->add_control('autoplay_speed', [
            'label' => 'Autoplay Speed',
            'type' => Controls_Manager::NUMBER,
            'description' => 'Delay in milliseconds between slides when autoplay is enabled.',
            'min' => 100,
            'step' => 100,
            'condition' => [
                'autoplay' => 'yes'
            ],
            'default' => 2500
        ]);
        //Infinite Loop
        $this->add_control('infinite_loop', [
            'label' => 'Infinite Loop',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes'
        ]);
        //Pause on Mouse Hover
        $this->add_control('pause_on_hover', [
            'label' => 'Pause on Mouse Hover',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes'
        ]);
        //Pause on Interaction
        $this->add_control('pause_on_interaction', [
            'label' => 'Pause on Interaction',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes'
        ]);

        $this->add_control(
            'divider_4',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        // Navigation Arrows
        $this->add_control('navigation_arrows', [
            'label' => 'Navigation Arrows',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes'
        ]);
        // Pagination Dots
        $this->add_control('pagination_dots', [
            'label' => 'Pagination Dots',
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes'
        ]);
        $this->end_controls_section();


        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'blogkit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        // Add style controls here as needed
        //Image Size
        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //Padding
        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Background Color
        $this->add_control(
            'slides_background_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        //Border Control
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box',
            ]
        );
        //Hover Border Color
        $this->add_control(
            'hover_border_color',
            [
                'label' => esc_html__('Hover Border Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        //Border Radius
        $this->add_responsive_control(
            'slides_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .image-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Title 
        $this->add_control(
            'taxonomy_name_style_heading',
            [
                'label' => esc_html__('Taxonomy Title', 'blogkit'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'taxonomy_name_typography',
                'label' => esc_html__('Typography', 'blogkit'),
                'selector' => '{{WRAPPER}} .taxonomy-slider .taxonomy-item .taxonomy-name',
            ]
        );
        //Text Color
        $this->add_control(
            'taxonomy_name_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider .taxonomy-item .taxonomy-name' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();

        //Navigation Style Section
        $this->start_controls_section(
            'navigation_style_section',
            [
                'label' => esc_html__('Navigation', 'blogkit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation_arrows' => 'yes',
                ],
            ]
        );

        //Arrow 
        $this->add_control(
            'navigation_arrow_heading',
            [
                'label' => esc_html__('Arrows', 'blogkit'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        //Arrow Size
        $this->add_responsive_control(
            'navigation_arrow_size',
            [
                'label' => esc_html__('Size', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .taxonomy-slider-button-prev svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Padding
        $this->add_responsive_control(
            'navigation_arrow_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next, {{WRAPPER}} .taxonomy-slider-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'navigation_arrow_border',
                'selector' => '{{WRAPPER}} .taxonomy-slider-button-next, {{WRAPPER}} .taxonomy-slider-button-prev',
            ]
        );
        //Border Radius
        $this->add_responsive_control(
            'navigation_arrow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next, {{WRAPPER}} .taxonomy-slider-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //Arrow Position 
        $this->add_control(
            'navigation_arrow_position_heading',
            [
                'label' => esc_html__('Previous Arrow Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //Previous Arrow - Left Position
        $this->add_responsive_control(
            'prev_arrow_left_position',
            [
                'label' => esc_html__('Left Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Previous Arrow - Top Position
        $this->add_responsive_control(
            'prev_arrow_top_position',
            [
                'label' => esc_html__('Top Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Next Arrow Position
        $this->add_control(
            'navigation_next_arrow_position_heading',
            [
                'label' => esc_html__('Next Arrow Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        //Next Arrow - Right Position
        $this->add_responsive_control(
            'next_arrow_right_position',
            [
                'label' => esc_html__('Right Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //Next Arrow - Top Position
        $this->add_responsive_control(
            'next_arrow_top_position',
            [
                'label' => esc_html__('Top Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Control Tabs
        $this->start_controls_tabs(
            'navigation_style_tabs'
        );
        //Control Normal Tab
        $this->start_controls_tab(
            'navigation_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );
        
        //Color
        $this->add_control(
            'navigation_arrow_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .taxonomy-slider-button-prev svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );
        //Background Color
        $this->add_control(
            'navigation_arrow_background_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .taxonomy-slider-button-prev' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        //Control Hover Tab
        $this->start_controls_tab(
            'navigation_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'blogkit'),
            ]
        );
        //Hover Color
        $this->add_control(
            'navigation_arrow_hover_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next:hover svg path' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .taxonomy-slider-button-prev:hover svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );
        //Hover Background Color
        $this->add_control(
            'navigation_arrow_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .taxonomy-slider-button-prev:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        //Hover Border Color
        $this->add_control(
            'navigation_arrow_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-slider-button-next:hover' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .taxonomy-slider-button-prev:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tabs();





        $this->end_controls_section();

        // Pagination Style Section
        $this->start_controls_section(
            'pagination_style_section',
            [
                'label' => esc_html__('Pagination', 'blogkit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'pagination_dots' => 'yes',
                ]
            ]
        );
       //Dot Heading
       $this->add_control(
            'pagination_dot_heading',
            [
                'label' => esc_html__('Dots', 'blogkit'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        //Space Between Dots
        $this->add_responsive_control(
            'pagination_dot_space_between',
            [
                'label' => esc_html__('Space Between Dots', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // Dots size
        $this->add_responsive_control(
            'pagination_dot_size',
            [
                'label' => esc_html__('Size', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //Dot Color
        $this->add_control(
            'pagination_dot_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );
        //Active Dot Color
        $this->add_control(
            'pagination_active_dot_color',
            [
                'label' => esc_html__('Active Dot Color', 'blogkit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }




    protected function render()
    {
        include 'RenderView.php';
    }
}
