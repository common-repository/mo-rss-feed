<?php
$mo_rss_column_shortcode = new mo_rss_column_shortcode();
class mo_rss_column_shortcode{
	private $short_code_url;
	private $short_code_class;
	private $short_code_footer;
		
	public function __construct() {
		add_shortcode('mo_rss_column', array($this, 'mo_rss_column'));
		add_action( 'wp_footer', array($this, 'register_column_styles') );
     }
	
	//Bring in the script
	public function column_scripts() {
		wp_register_script( 'jquery-rss', plugin_dir_url( dirname(__FILE__) ) . 'js/jquery.rss.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script('jquery-rss');
		
		foreach( $this->short_code_footer as $script ){
	        echo $script;
	     }
	}
	
	// Register style sheet.
	public function register_column_styles() {
		wp_register_style( 'mo-column-css', plugin_dir_url( dirname(__FILE__) ) . 'css/column.css' );
		wp_enqueue_style( 'mo-column-css' );
	}
	     
     public function mo_rss_column($atts){	 
		$attrs = shortcode_atts( array(
			'url' => 'something',
			'class' => 'something else',
		), $atts );
		
		$this->short_code_url = esc_attr($attrs['url']);
		$this->short_code_class = 'mo_rss_column_'.rand();
		
		$this->short_code_footer[] = '<script type="text/javascript" language="JavaScript">
		jQuery(document).ready(function($) { 
				$(\'.'.$this->short_code_class.'\').rss(\''.$this->short_code_url.'\', {
					ssl: true,
					limit: 6,
					layoutTemplate: \'{entries}\',
					entryTemplate: \'<div class="one-half"><div class="twelve columns"><div class="six columns"><a href="{url}" target="_blank">{teaserImage}</a></div><div class="six columns"><h3><a href="{url}" target="_blank">{title}</a></h3></div></div></div>\'
				});
			});
			</script>';
			
		add_action( 'wp_footer', array($this, 'column_scripts') );
		
		return '<section class="mo-rss-feed-container" style="margin-bottom:40px; display:inline-block;"><div class="twelve columns '.$this->short_code_class.'"></div><a href="'.$this->short_code_url.'" class="rss-more" target="_blank">View All</a></section>';
	}	
}