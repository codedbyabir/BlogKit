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

        $this->add_control('slides_per_desktop', [
            'label'=>'Slides per View (Desktop)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>6
        ]);
        $this->add_control('slides_per_tablet', [
            'label'=>'Slides per View (Tablet)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>3
        ]);
        $this->add_control('slides_per_mobile', [
            'label'=>'Slides per View (Mobile)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>2
        ]);

        $this->add_control('space_between', [
            'label'=>'Space Between (px)',
            'type'=>Controls_Manager::NUMBER,
            'default'=>20
        ]);

        $this->add_control('autoplay', [
            'label'=>'Autoplay',
            'type'=>Controls_Manager::SWITCHER,
            'return_value'=>'yes',
            'default'=>'yes'
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        include 'RenderView.php';
    }
}
