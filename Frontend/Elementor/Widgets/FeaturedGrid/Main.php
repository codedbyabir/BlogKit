<?php
namespace BlogKit\Frontend\Elementor\Widgets\FeaturedGrid;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Main extends Widget_Base
{
    public function get_name()
    {
        return 'blogkit_featured_grid';
    }

    public function get_title()
    {
        return esc_html__('Featured Grid', 'blogkit');
    }

    public function get_icon()
    {
        return 'eicon-posts-group blogkit-icon';
    }

    public function get_categories()
    {
        return ['blogkit'];
    }

    public function get_keywords()
    {
        return ['blog', 'featured', 'grid', 'posts', 'blogkit'];
    }


    /**
     * Register controls.
     */
    protected function register_controls()
    {

        // Query Tab
        $this->start_controls_section(
            'blogkit_card_grid_settings',
            [
                'label' => esc_html__('Query', 'blogkit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Styles 
        $this->add_control(
            'layout_style',
            [
                'label' => esc_html__('Layout Style', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'style_1',
                'options' => [
                    'style_1' => esc_html__('Style 1', 'blogkit'),
                ]
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'blogkit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'max' => 4,
            ]
        );


        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'blogkit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'blogkit'),
                    'title' => esc_html__('Title', 'blogkit'),
                    'rand' => esc_html__('Random', 'blogkit'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'blogkit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'blogkit'),
                    'ASC' => esc_html__('Ascending', 'blogkit'),
                ],
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'blogkit'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_blogkit_categories(),
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Layout Tab 
        $this->start_controls_section(
            'blogkit_card_grid_layout',
            [
                'label' => esc_html__('Layout', 'blogkit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        // Category switch control
        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Category', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'blogkit'),
                'label_off' => esc_html__('Hide', 'blogkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Random Color
        $this->add_control(
            'category_random_color_switch',
            [
                'label' => esc_html__('Use Random Color?', 'blogkit'),
                'description' => esc_html__('Use Random Color for Category Background color', 'blogkit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'blogkit'),
                'label_off' => esc_html__('No', 'blogkit'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );


        // Title switch control
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'blogkit'),
                'label_off' => esc_html__('Hide', 'blogkit'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );



        $this->end_controls_section();

        /**
         * Style section: Grid Item
         */
        $this->start_controls_section(
            'blogkit_card_grid_item_style',
            [
                'label' => esc_html__('Grid Item', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Gap

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        // Border control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card',
            ]
        );

        // Padding 
        $this->add_responsive_control(
            'grid_item_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Border Radius
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        //Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card',
            ]
        );


        $this->end_controls_section();

        /**
         * Style section: Category
         */
        $this->start_controls_section(
            'blogkit_card_grid_category_style',
            [
                'label' => esc_html__('Category', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //Category Alert
        $this->add_control(
			'category_switch_alert',
			[
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'warning',
				'heading' => esc_html__( 'Category Switch is Disabled', 'textdomain' ),
				'content' => esc_html__( 'Please enable Category Switch to use this feature.', 'blogkit' ),
                'condition' => [
                    'show_category!' => 'yes',
                ],
			]
		);


        // Category Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat',
            ]
        );


        // Padding 
        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'category_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs(
            'category_style_tabs'
        );

        $this->start_controls_tab(
            'category_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );


        // Text Color
        $this->add_control(
            'category_text_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'category_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'category_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'blogkit'),
            ]
        );

        // Hover & Current Text Color
        $this->add_control(
            'category_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover & Active Background
        $this->add_control(
            'category_hover_bg',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                 'type' => Controls_Manager::COLOR,
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();


        /**
         * Style section: Meta
         */
        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta Info', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //Text Color
        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__meta' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__meta',
            ]
        );

        $this->end_controls_section();

        /**
         * Style section: Title
         */
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        //Title Alert
        $this->add_control(
			'title_switch_alert',
			[
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'warning',
				'heading' => esc_html__( 'Title Switch is Disabled', 'textdomain' ),
				'content' => esc_html__( 'Please enable Title Switch to use this feature.', 'blogkit' ),
                'condition' => [
                    'show_title!' => 'yes',
                ],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__title',
            ]
        );



        $this->start_controls_tabs(
            'color-tabs'
        );

        $this->start_controls_tab(
            'title_style_normal_color',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_style_hover_color',
            [
                'label' => esc_html__('Hover', 'blogkit'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post-card__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
         * Style section: Left part
         */
        $this->start_controls_section(
            'blogkit_fg_post_card_left_part',
            [
                'label' => esc_html__('Left Part', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs(
            'blogkit_fg_post_card_left_part_style_tabs'
        );

        // Category 
        $this->start_controls_tab(
            'blogkit_fg_post_card_left_part_category',
            [
                'label' => esc_html__('Category', 'blogkit'),
            ]
        );

        //Alert
        $this->add_control(
			'category_alert',
			[
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'warning',
				'heading' => esc_html__( 'Category Switch is Disabled', 'blogkit' ),
				'content' => esc_html__( 'Please enable Category Switch to use this feature.', 'blogkit' ),
                'condition' => [
                    'show_category!' => 'yes',
                ],
			]
		);


        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blogkit_fg_laft_part_category_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat',

            ]
        );

        // Padding 
        $this->add_responsive_control(
            'blogkit_fg_laft_part_category_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'blogkit_fg_laft_part_category_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'blogkit_fg_laft_part_category_text_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Background Color
        $this->add_control(
            'blogkit_fg_laft_part_category_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Hover Color
        $this->add_control(
            'blogkit_fg_laft_part_category_hover_text_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat:hover' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Hover Background Color
        $this->add_control(
            'blogkit_fg_laft_part_category_hover_bg',
            [
                'label' => esc_html__('Hover Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        // Title 
        $this->start_controls_tab(
            'blogkit_fg_laft_part_title',
            [
                'label' => esc_html__('Title', 'blogkit'),
            ]
        );
        //Title Alert
        $this->add_control(
			'left_part_title_alert',
			[
				'type' => \Elementor\Controls_Manager::ALERT,
				'alert_type' => 'warning',
				'heading' => esc_html__( 'Title Switch is Disabled', 'textdomain' ),
				'content' => esc_html__( 'Please enable Title Switch to use this feature.', 'blogkit' ),
                'condition' => [
                    'show_title!' => 'yes',
                ],
			]
		);

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blogkit_fg_laft_part_title_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__title',
            ]
        );

        // Text Color
        $this->add_control(
            'blogkit_fg_laft_part_title_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover Color
        $this->add_control(
            'blogkit_fg_laft_part_hover_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        // Meta
        $this->start_controls_tab(
            'blogkit_fg_laft_part_meta',
            [
                'label' => esc_html__('Meta', 'blogkit'),
            ]
        );


        //Text Color
        $this->add_control(
            'blogkit_fg_laft_part_meta_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blogkit_fg_laft_part_meta_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__left .blogkit-fg-post-card__meta',
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_tabs();



        $this->end_controls_section();




        /**
         * Style section: Right Part
         */
        $this->start_controls_section(
            'blogkit_fg_right_part',
            [
                'label' => esc_html__('Right Part', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs(
            'blogkit_fg_right_part_style_tabs'
        );

        /*
            Category 
        */
        $this->start_controls_tab(
            'blogkit_fg_right_part_category',
            [
                'label' => esc_html__('Category', 'blogkit'),
            ]
        );

        // Category Alert
        $this->add_control(
            'right_part_category_alert',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Category Switch is Disabled', 'textdomain'),
                'content' => esc_html__('Please enable Category Switch to use this feature.', 'blogkit'),
                'condition' => [
                    'show_category!' => 'yes',
                ],
            ]
        );


        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blogkit_fg_right_part_category_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat',
            ]
        );

        // Padding 
        $this->add_responsive_control(
            'blogkit_fg_right_part_category_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'blogkit_fg_right_part_category_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'blogkit_fg_right_part_category_text_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Background Color
        $this->add_control(
            'blogkit_fg_right_part_category_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Hover & Current Text Color
        $this->add_control(
            'blogkit_fg_right_part_category_hover_text_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat:hover' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Hover & Active Background
        $this->add_control(
            'blogkit_fg_right_part_category_hover_bg',
            [
                'label' => esc_html__('Hover Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        /*
           Title 
       */
        $this->start_controls_tab(
            'blogkit_fg_right_part_title',
            [
                'label' => esc_html__('Title', 'blogkit'),
            ]
        );

        //Title Alert
        $this->add_control(
            'right_part_title_alert',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Title Switch is Disabled', 'textdomain'),
                'content' => esc_html__('Please enable Title Switch to use this feature.', 'blogkit'),
                'condition' => [
                    'show_title!' => 'yes',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'right_part_title_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__title',
            ]
        );

        // Text Color
        $this->add_control(
            'blogkit_fg_right_part_title_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover Color
        $this->add_control(
            'blogkit_fg_right_part_title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        /*
           Meta 
       */
        $this->start_controls_tab(
            'blogkit_fg_right_part_meta',
            [
                'label' => esc_html__('Meta', 'blogkit'),
            ]
        );


        //Text Color
        $this->add_control(
            'blogkit_fg_right_part_meta_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blogkit_fg_right_part_meta_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__right .blogkit-fg-post-card__meta',
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_tabs();



        $this->end_controls_section();







        /**
         * Style section: Bottom Part
         */
        $this->start_controls_section(
            'blogkit-fg-post-card_bottom_part',
            [
                'label' => esc_html__('Bottom Part', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs(
            'blogkit-fg-post-card_bottom_part_style_tabs'
        );

        // Category 
        $this->start_controls_tab(
            'blogkit-fg-post-card_bottom_part_category',
            [
                'label' => esc_html__('Category', 'blogkit'),
            ]
        );

        // Category Alert
        $this->add_control(
            'bottom_part_category_alert',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Category Switch is Disabled', 'textdomain'),
                'content' => esc_html__('Please enable Category Switch to use this feature.', 'blogkit'),
                'condition' => [
                    'show_category!' => 'yes',
                ],
            ]
        );


        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bottom_part_category_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat',
            ]
        );

        // Padding 
        $this->add_responsive_control(
            'bottom_part_category_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'bottom_part_category_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text Color
        $this->add_control(
            'bottom_part_category_text_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat' => 'color: {{VALUE}};',
                ],
            ]
        );



        // Background Color
        $this->add_control(
            'bottom_part_category_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'description' => esc_html__('This setting works only when Random Color is turned off.', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        // Hover Text Color
        $this->add_control(
            'bottom_part_category_hover_text_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat:hover' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Hover Background Color
        $this->add_control(
            'bottom_part_category_hover_bg',
            [
                'label' => esc_html__('Hover Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        // Title 
        $this->start_controls_tab(
            'blogkit-fg-post-card_bottom_part_title',
            [
                'label' => esc_html__('Title', 'blogkit'),
            ]
        );

        //Title Alert
        $this->add_control(
            'bottom_part_title_alert',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Title Switch is Disabled', 'textdomain'),
                'content' => esc_html__('Please enable Title Switch to use this feature.', 'blogkit'),
                'condition' => [
                    'show_title!' => 'yes',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bottom_part_title_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__title',
            ]
        );

        // Text Color
        $this->add_control(
            'bottom_part_title_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover Color
        $this->add_control(
            'bottom_part_title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        // Meta
        $this->start_controls_tab(
            'blogkit-fg-post-card_bottom_part_meta',
            [
                'label' => esc_html__('Meta', 'blogkit'),
            ]
        );


        //Text Color
        $this->add_control(
            'bottom_part_meta__color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bottom_part_meta_typography',
                'selector' => '{{WRAPPER}} .blogkit-featured-grid.grid-style1 .blogkit-fg-post__bottom .blogkit-fg-post-card__meta',
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_tabs();



        $this->end_controls_section();




    }

    /**
     * Helper: Get all categories.
     */
    private function get_blogkit_categories()
    {
        $categories = get_categories(['hide_empty' => false]);
        $cats = [];
        if ($categories) {
            foreach ($categories as $category) {
                $cats[$category->slug] = $category->name;
            }
        }
        return $cats;
    }



    /**
     * Render Random Color.
     */
    private function generate_random_color()
    {
        return sprintf('#%06X', wp_rand(0, 0xFFFFFF));
    }

    /**
     * Render frontend output.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $layout_style = $settings['layout_style'] ?? 'style_1'; // fallback to style_1 if not set

        switch ($layout_style) {
            case 'style_1':
                include_once 'style1.php';
                break;

            default:
                // Optional: fallback style
                include_once 'style1.php';
                break;
        }
    }
}
