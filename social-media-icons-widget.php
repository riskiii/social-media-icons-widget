<?php
/*
Plugin Name: Social Icons Widget
Plugin URI: http://github.com/dannisbet/Social-Icons-Widget
Version: 14.03
Description: Displays a list of social media website icons and a link to your profile.
Author: Dan Nisbet
Author URI: http://dannisbet.com/
*/

class Social_Icons_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'social-icons-widget', // Base ID
			'Social Icons', // Widget Name
			array(
				'classname' => 'social-icons-widget',
				'description' => 'Displays a list of social media website icons and a link to your profile.',
			),
			array(
				'width' => 600,
			)
		);

		// Register Stylesheets
		add_action('admin_print_styles', array($this, 'register_admin_styles'));
		add_action('wp_enqueue_scripts', array($this, 'register_widget_styles'));

		include('lib/social-networks.php');
	}

	function form($instance) {
		include('lib/form.php');
	}

	function update($new_instance, $old_instance) {
		global $social_accounts;
		$instance = array();

		foreach ($social_accounts as $site => $id) {
			$instance[$id] = $new_instance[$id];
		}

		$instance['title'] = $new_instance['title'];
		$instance['icons'] = $new_instance['icons'];
		$instance['labels'] = $new_instance['labels'];

		return $instance;
	}

	function widget($args, $instance) {
		include('lib/widget.php');
	}

	function register_admin_styles() {
		wp_enqueue_style('social-icons-widget-admin', plugins_url('social-media-icons-widget/css/social_icons_admin.css'));
	}

	function register_widget_styles() {
		wp_enqueue_style('social-icons-widget-widget', plugins_url('social-media-icons-widget/css/social_icons_widget.css'));
	}

}

add_action('widgets_init', create_function('', 'register_widget("Social_Icons_Widget");') );

?>