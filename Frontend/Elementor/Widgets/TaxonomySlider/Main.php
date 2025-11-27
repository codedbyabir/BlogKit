<?php
namespace BlogKit\Frontend\Elementor\Widgets\TaxonomySlider;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Main extends Widget_Base {

    public function get_name() { return 'taxonomy_slider'; }
    public function get_title() { return 'Taxonomy Slider'; }
    public function get_icon() { return 'eicon-slider-full-screen'; }
    public function get_categories() { return ['general']; }

    public function get_script_depends() { 
        return ['swiper-bundle-js']; 
    }
    public function get_style_depends() { 
        return ['swiper-bundle-css' , 'blogkit-elementor-style']; 
    }

    protected function register_controls() {
        $this->start_controls_section('content', ['label'=>'Content']);

        // Slider Settings Desktop
        $this->add_control('slides_per_desktop', [
            'label'=>'Slides per View (Desktop)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>6
        ]);
        $this->add_control('space_between_desktop', [
            'label'=>'Space Between Slides (Desktop)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>30
        ]);
        $this->add_control(
			'divider_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
       
        // Slider Settings Tablet
        $this->add_control('slides_per_tablet', [
            'label'=>'Slides per View (Tablet)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>3
        ]);
        $this->add_control('space_between_tablet', [
            'label'=>'Space Between Slides (Tablet)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>30
        ]);
        $this->add_control(
			'divider_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
     
        // Slider Settings Mobile
        $this->add_control('slides_per_mobile', [
            'label'=>'Slides per View (Mobile)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>2
        ]);
        $this->add_control('space_between_mobile', [
            'label'=>'Space Between Slides (Mobile)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>20
        ]);
        $this->add_control(
			'divider_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
       

        $this->add_control('autoplay', [
            'label'=>'Autoplay',
            'type'=>Controls_Manager::SWITCHER,
            'return_value'=>'yes',
            'default'=>'yes'
        ]);
        // Autoplay Speed
        $this->add_control('autoplay_speed', [
            'label'=>'Autoplay Speed',
            'type'=>Controls_Manager::NUMBER,
            'description' => 'Delay in milliseconds between slides when autoplay is enabled.',
            'min' => 100,
            'step' => 100,
            'condition' => [
                'autoplay' => 'yes'
            ],
            'default'=>2500
        ]);
        //Infinite Loop
         $this->add_control('infinite_loop', [
            'label'=>'Infinite Loop',
            'type'=>Controls_Manager::SWITCHER,
            'return_value'=>'yes',
            'default'=>'yes'
        ]);
        //Pause on Mouse Hover
         $this->add_control('pause_on_hover', [
            'label'=>'Pause on Mouse Hover',
            'type'=>Controls_Manager::SWITCHER,
            'return_value'=>'yes',
            'default'=>'yes'
        ]);
        //Pause on Interaction
        $this->add_control('pause_on_interaction', [
            'label'=>'Pause on Interaction',
            'type'=>Controls_Manager::SWITCHER,
            'return_value'=>'yes',
            'default'=>'yes'
        ]);

        $this->add_control(
			'divider_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
        

        $this->end_controls_section();
    }

    protected function render() {
        include 'RenderView.php';
    }
}
