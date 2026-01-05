<?php
namespace BlogKit\Frontend\Elementor\Widgets\PostCard;

use Elementor\Core\Editor\Data\Globals\Endpoints\Typography;
use Jet_Engine\Blocks_Views\Dynamic_Content\Blocks\Heading;

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
        return 'blogkit-post-card';
    }

    public function get_title()
    {
        return esc_html__('Post Card', 'blogkit');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid blogkit-icon';
    }

    public function get_categories()
    {
        return ['blogkit'];
    }

    public function get_keywords()
    {
        return ['blog', 'card', 'grid', 'post', 'blogkit'];
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
                    'style_2' => esc_html__('Style 2', 'blogkit'),
                    'style_3' => esc_html__('Style 3', 'blogkit'),
                ]
            ]
        );
        // Posts Per Page
        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'blogkit'),
                'type' => Controls_Manager::NUMBER,
            ]
        );
        // Columns
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 Column', 'blogkit'),
                    '2' => esc_html__('2 Columns', 'blogkit'),
                    '3' => esc_html__('3 Columns', 'blogkit'),
                    '4' => esc_html__('4 Columns', 'blogkit'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-posts' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );


        // Order By
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
        // Order
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
        // Category
        $this->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'blogkit'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_blogkit_categories(),
                'multiple' => true,
                'label_block' => true,
            ],
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
                'separator' => 'after',
                'condition' => [
                    'layout_style!' => 'style_2',
                ]
            ]
        );

        // Title tag control 
        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'blogkit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',

                ],
                'default' => 'h3',
                'separator' => 'after',

                'condition' => [
                    'layout_style!' => 'style_2',
                ]
            ]
        );

        // Hunamize Date
        $this->add_control(
            'show_humanize_date',
            [
                'label' => esc_html__('Human Different Time', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'blogkit'),
                'label_off' => esc_html__('Hide', 'blogkit'),
                'return_value' => 'yes',
                'default' => 'yes',

                'condition' => [
                    'layout_style!' => 'style_2',
                ]
            ]
        );

        // Excerpt Lenght 
        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length', 'blogkit'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'layout_style' => 'style_2',
                ]
            ]
        );

        // Pagination
        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Pagination', 'blogkit'),
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
                'condition' => [
                    'layout_style!' => 'style_2',
                ],
            ]
        );

        // Columns Gap
        $this->add_responsive_control(
            'columns-gap',
            [
                'label' => esc_html__('Columns Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1' => 'column-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Rows Gap

        $this->add_responsive_control(
            'rows-gap',
            [
                'label' => esc_html__('Rows Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1' => 'row-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Border control
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item , {{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item',
            ]
        );

        //Content Padding 
        $this->add_responsive_control(
            'item_body_padding',
            [
                'label' => esc_html__('Content Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Padding 
        $this->add_responsive_control(
            'grid_item_padding',
            [
                'label' => esc_html__('Item Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Background Color
        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__('Item Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        //Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item , {{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item',
                'fields_options' => [
                    'box_shadow_type' => [
                    ],
                    'box_shadow' => [
                    ],
                ],
            ]
        );


        $this->end_controls_section();
        /**
         * Style section: Thumbnail
         */
        $this->start_controls_section(
            'blogkit_card_grid_thumb_style',
            [
                'label' => esc_html__('Thumbnail', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style!' => 'style_2',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'thumb_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        // Thumbnail Position
        $this->add_responsive_control(
            'thumbnail_position',
            [
                'label' => esc_html__('Position', 'blogkit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Top', 'blogkit'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'blogkit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Bottom', 'blogkit'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'row' => [
                        'title' => esc_html__('Left', 'blogkit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                // 'default' => 'column',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item' => 'flex-direction: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item' => 'flex-direction: {{VALUE}};',
                ],
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
                'condition' => [
                    'show_category' => 'yes',
                    'layout_style!' => 'style_2',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category , {{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category',
            ]
        );

        //Border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category , {{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category',
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
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'category_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'category_style_hover_tab',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );

        // Hover & Current Text Color
        $this->add_control(
            'category_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Hover & Active Background
        $this->add_control(
            'category_hover_bg',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hover Border Color
        $this->add_control(
            'category_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-category:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-category:hover' => 'border-color: {{VALUE}};',
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
            'blogkit_card_grid_meta_style',
            [
                'label' => esc_html__('Meta Info', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style!' => 'style_2',
                    'layout_style!' => 'style_3',
                ],
            ]
        );

        //Text Color
        $this->add_control(
            'meta_text_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-meta span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content .blogkit-post-card-comments' => 'color: {{VALUE}};',
                ],
            ]
        );

        //Icon Color
        $this->add_control(
            'meta_icon_color',
            [
                'label' => esc_html__('Icon Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content .blogkit-post-card-comments svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-meta span, {{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-comments',
            ]
        );

        $this->end_controls_section();

        /**
         * Style section: Heading
         */
        $this->start_controls_section(
            'blogkit_card_grid_title_style',
            [
                'label' => esc_html__('Heading', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style!' => 'style_2',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content .blogkit-post-card-title , {{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-title',
            ]
        );



        $this->start_controls_tabs(
            'color-tabs'
        );

        $this->start_controls_tab(
            'style_normal_color',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content .blogkit-post-card-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_color',
            [
                'label' => esc_html__('Hover', 'blogkit'),
            ]
        );

        $this->add_control(
            'heading_hover_color',
            [
                'label' => esc_html__('Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card-wrapper.grid-style1 .blogkit-post-card-item .blogkit-post-card-content .blogkit-post-card-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogkit-post-card-wrapper.card-style-3 .blogkit-post-card-item .blogkit-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();




       

        // Post Card Style 2 Settings
        $this->start_controls_section(
            'blogkit_post_card_style_2_settings',
            [
                'label' => esc_html__('Featured Settings', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style' => 'style_2',
                ],
            ]
        );

        //Columns Gap
        $this->add_responsive_control(
            'style2_columns_gap',
            [
                'label' => esc_html__('Columns Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-posts' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Rows Gap
        $this->add_responsive_control(
            'style2_rows_gap',
            [
                'label' => esc_html__('Rows Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-posts' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Thumbnail Border Radius
        $this->add_responsive_control(
            'style2_featured_thumb_border_radius',
            [
                'label' => esc_html__('Thumbnail Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        //Item Padding
        $this->add_responsive_control(
            'style2_featured_padding',
            [
                'label' => esc_html__('Item Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Content Padding
        $this->add_responsive_control(
            'style2_featured_content_padding',
            [
                'label' => esc_html__('Content Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Border Radius
        $this->add_responsive_control(
            'style2_featured_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Background Color
        $this->add_control(
            'style2_featured_background_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        //Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'style2_featured_box_shadow',
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post',
                'fields_options' => [
                    'box_shadow_type' => [
                    ],
                    'box_shadow' => [
                    ],
                ],
            ]
        );

        //Divider
        $this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


        //Meta Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'style2_featured_meta_typography',
                'label' => esc_html__('Meta Typography', 'blogkit'),
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-meta',
            ],
        );

        //Color
        $this->add_control(
            'style2_featured_meta_color',
            [
                'label' => esc_html__('Meta Text Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-meta span' => 'color: {{VALUE}};',
                ],
            ]
        );

        //Icon Color
        $this->add_control(
            'style2_featured_meta_icon_color',
            [
                'label' => esc_html__('Meta Icon Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-meta svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        //Divider
        $this->add_control(
			'hr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        //Heading Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'style2_featured_heading_typography',
                'label' => esc_html__('Heading Typography', 'blogkit'),
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-title a',
                
            ],
        );

        //Heading Color
        $this->add_control(
            'style2_featured_heading_color',
            [
                'label' => esc_html__('Heading Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        //Heading Hover Color
        $this->add_control(
            'style2_featured_heading_hover_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-featured-post .blogkit-featured-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Bottom Grid Settings
        $this->start_controls_section(
            'blogkit_post_card_style_2_grid_settings',
            [
                'label' => esc_html__('Bottom Grid Settings', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style' => 'style_2',
                ],
            ]
        );

        //Columns Gap
        $this->add_responsive_control(
            'style2_bottom_grid_columns_gap',
            [
                'label' => esc_html__('Columns Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Rows Gap
        $this->add_responsive_control(
            'style2_bottom_grid_rows_gap',
            [
                'label' => esc_html__('Rows Gap', 'blogkit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 100]
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        //Thumbnail Border Radius
        $this->add_responsive_control(
            'style2_bottom_grid_thumb_border_radius',
            [
                'label' => esc_html__('Thumbnail Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Item Padding
        $this->add_responsive_control(
            'style2_bottom_grid_item_padding',
            [
                'label' => esc_html__('Item Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Content Padding
        $this->add_responsive_control(
            'style2_bottom_grid_content_padding',
            [
                'label' => esc_html__('Content Padding', 'blogkit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Border Radius
        $this->add_responsive_control(
            'style2_bottom_grid_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        //Background Color
        $this->add_control(
            'style2_bottom_grid_background_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        //Box Shadow
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'style2_bottom_grid_box_shadow',
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item',
                'fields_options' => [
                    'box_shadow_type' => [
                    ],
                    'box_shadow' => [
                    ],
                ],
            ]
        );

        //Divider
        $this->add_control(
			'hr5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        // Heading Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'style2_bottom_grid_heading_typography',
                'label' => esc_html__('Heading Typography', 'blogkit'),
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-title a',
                
            ],
        );

        // Heading Color
        $this->add_control(
            'style2_bottom_grid_heading_color',
            [
                'label' => esc_html__('Heading Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Heading Hover Color
        $this->add_control(
            'style2_bottom_grid_heading_hover_color',
            [
                'label' => esc_html__('Hover Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        //Divider
        $this->add_control(
			'hr3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

        // Excerpt Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'style2_bottom_grid_excerpt_typography',
                'label' => esc_html__('Excerpt Typography', 'blogkit'),
                'selector' => '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-excerpt',
                
            ],
        );

        // Excerpt Color
        $this->add_control(
            'style2_bottom_grid_excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-post-card.card-style-2 .blogkit-post-card-bottom-grid .blogkit-post-card-item .blogkit-post-card-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );



        $this->end_controls_section();


         /**
         * Style section: Pagination
         */
        $this->start_controls_section(
            'blogkit_card_grid_pagination_style',
            [
                'label' => esc_html__('Pagination', 'blogkit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        // Alignment
        $this->add_responsive_control(
            'pagination_align',
            [
                'label' => esc_html__('Alignment', 'blogkit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'blogkit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'blogkit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'blogkit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Spacing 
        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label' => esc_html__('Spacing', 'blogkit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'selector' => '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current',
            ]
        );


        // Padding
        $this->add_responsive_control(
            'pagination_padding',
            [
                'label' => esc_html__('Padding', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label' => esc_html__('Border Radius', 'blogkit'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Border 
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'selector' => '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current',
            ]
        );




        $this->start_controls_tabs(
            'pagination_style_tabs'
        );

        $this->start_controls_tab(
            'pagination_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'blogkit'),
            ]
        );

        // Text Color
        $this->add_control(
            'pagination_text_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'pagination_bg_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'blogkit'),
            ]
        );

        // Text Color
        $this->add_control(
            'pagination_text_hover_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a:hover, {{WRAPPER}} .blogkit-pagination .page-numbers.current:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'pagination_bg_hover_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a:hover, {{WRAPPER}} .blogkit-pagination .page-numbers.current:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border Color
        $this->add_control(
            'pagination_pagination_border_hover_color',
            [
                'label' => esc_html__('Border', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a:hover, {{WRAPPER}} .blogkit-pagination .page-numbers.current:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'pagination_style_active_tab',
            [
                'label' => esc_html__('Active', 'blogkit'),
            ]
        );

        // Text Color
        $this->add_control(
            'pagination_text_active_color',
            [
                'label' => esc_html__('Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a.active, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background Color
        $this->add_control(
            'pagination_bg_active_color',
            [
                'label' => esc_html__('Background Color', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a.active, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border Color
        $this->add_control(
            'pagination_pagination_border_active_color',
            [
                'label' => esc_html__('Border', 'blogkit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blogkit-pagination ul li a.active, {{WRAPPER}} .blogkit-pagination .page-numbers.current' => 'border-color: {{VALUE}};',
                ],
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
     * Render frontend output.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $layout_style = $settings['layout_style'] ?? 'style_1';

        // Start capturing the output
        ob_start();

        switch ($layout_style) {
            case 'style_1':
                include 'style1.php'; // Changed to include
                break;
            case 'style_2':
                include 'style2.php'; // Changed to include
                break;
                case 'style_3':
                include 'style3.php'; // Changed to include
                break;
            default:
                include 'style1.php'; // Changed to include
                break;
        }

        // Echo the captured content and clear the buffer
        echo ob_get_clean();
    }
}