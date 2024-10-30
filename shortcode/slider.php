<?php
$mo_rss_slider_shortcode = new mo_rss_slider_shortcode();
class mo_rss_slider_shortcode{
	private $short_code_url;
	private $short_code_class;
	private $short_code_footer;
		
	public function __construct() {
		add_shortcode('mo_rss_slider', array($this, 'mo_rss_slider'));
		add_action( 'wp_footer', array($this, 'register_slider_styles') );
     }
	
	//Bring in the script
	public function slider_scripts() {
		wp_register_script( 'jquery-rss', plugin_dir_url( dirname(__FILE__) ) . 'js/jquery.rss.js', array('jquery'), '1.0.0', true );
		wp_register_script( 'bxslider', plugin_dir_url( dirname(__FILE__) ) . 'vendor/bxslider/jquery.bxslider.min.js', array('jquery'), '1.0.0', true );	
		wp_enqueue_script('jquery-rss');
		wp_enqueue_script('bxslider');
		
		foreach( $this->short_code_footer as $script ){
	        echo $script;
	     }
	}
	
	// Register style sheet.
	public function register_slider_styles() {
		wp_register_style( 'mo-bxslider-css', plugin_dir_url( dirname(__FILE__) ) . 'vendor/bxslider/jquery.bxslider.css' );
		wp_enqueue_style( 'mo-bxslider-css' );
		
		wp_register_style( 'mo-slider-css', plugin_dir_url( dirname(__FILE__) ) . 'css/slider.css' );
		wp_enqueue_style( 'mo-slider-css' );
	}
     
     public function mo_rss_slider($atts){	 
		$attrs = shortcode_atts( array(
			'url' => 'something',
			'class' => 'something else',
			'limit' => '12',
			'more' => ''
		), $atts );
		
		$this->short_code_url = esc_attr($attrs['url']);
		$this->short_code_class = 'mo_slider_'.rand();
		$this->short_code_limit = esc_attr($attrs['limit']);
		
		if(esc_attr($attrs['more']) != ''){
			$this->short_code_more = esc_attr($attrs['more']);
		}else{
			$this->short_code_more = esc_attr($attrs['url']);
		}
		
		$this->short_code_limit = esc_attr($attrs['limit']);
		
		$this->short_code_footer[] = '<script type="text/javascript" language="JavaScript">
		jQuery(document).ready(function($) { 
				$(\'.'.$this->short_code_class.'\').rss(\''.$this->short_code_url.'\', {
					ssl: true,
					limit:'.$this->short_code_limit.',
					layoutTemplate: \'{entries}\',
					entryTemplate: \'<div class="slide"><div class="rss-image-container"><a href="{url}" target="_blank">{teaserImage}</a></div><h3><a href="{url}" target="_blank">{title}</a></h3><p>{bodyPlain}</p></div>\'
				},
				function callback() {
					$(".'.$this->short_code_class.' .slide a img").attr("src", function(i, src) {
					    return src.replace( "http://", "https://" );
					}); 
				}
				);
				 
				$(window).bind(\'load\', function() {
					$(\'.'.$this->short_code_class.'\').bxSlider({
						slideWidth: 300,
						minSlides: 1,
						maxSlides: 3,
						slideMargin: 10
					});
				});
			});
			</script>';
		
			
		add_action( 'wp_footer', array($this, 'slider_scripts') );
		
		return '<section class="mo-rss-feed-container" style="margin-bottom:40px;"><div class="'.$this->short_code_class.'"></div><a href="'.$this->short_code_more.'" class="rss-more">View All</a></section>';
	}	
}