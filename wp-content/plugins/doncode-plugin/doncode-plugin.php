<?php

/**
 * @package Custome Post Type Plugin
 * @version 1.0
 */
/*
Plugin Name: Custome Post Type Plugin
Plugin URI: http://wordpress.org/plugins/CPT-Plugin/
Description: this is the plugin to create a Custome Post Type
Author: Haris Takam
Version: 1.0
Author URI: http://CPT-Plugin/
*/

// ABSPATH => ABSOLUTE PATH Is the constant variable define by wordpress to initialize the wordpress site
if (!defined('ABSPATH')) {
    die;
}

defined('ABSPATH') or die('Your wordpress is not initialize very well');


if(file_exists( dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use Inc\Activate;
use Inc\Deactivate;
use Inc\Admin\AdminPages;


if (!class_exists('appartPlugin')) {


    class appartPlugin
    {
        public $plugin_name;

        //Public : Can be accessed everywhere

        //Protected : Can be accessed only within the class itself or extensions of that class

        //Private : Can be accessed only within the class itself


        function __construct()
        {
            $this->plugin_name = plugin_basename('__FILE__');
        }

        function register()
        {
            add_action('admin_enqueue_scripts', array($this, 'enqeue'));

            add_action( 'admin_menu', array($this, 'add_admin_pages'));

            add_filter('plugin_action_links', array($this,'settings_link'));

        }


        public function settings_link($links)
        {
            $setting_link = '<a href="admin.php?page=doncode_plugin">Setting</a>';
            array_push($links, $setting_link);
            return $links;
        }


        function add_admin_pages(){
            add_menu_page( 'DonCode Plugin', 'DonCode', 'manage_options', 'doncode_plugin', array($this, 'admin_index'),'dashicons-store','110');
        }

        function admin_index(){
            require_once plugin_dir_path(__FILE__) . 'Templates/admin.php';
        }

        function activate()
        {
            // require_once plugin_dir_path(__FILE__) . 'inc/doncode-plugin-activate.php';
            Activate::activate();
        }

        function deactivate()
        {
            // require_once plugin_dir_path(__FILE__) . 'inc/doncode-plugin-deactivate.php';
            Deactivate::deactivate();
        }

        function enqeue()
        {
            wp_enqueue_style("plugin_style", plugins_url('/Assets/style.css', __FILE__));
            wp_enqueue_script('plugin_script', plugins_url('/scripts/script.js', __FILE__));
        }



        protected function create_post_type(){
            add_action('init', array($this, 'custome_post_type'));
        }


        function custome_post_type()
        {
            register_post_type('book', [
                'public' => true,
                'label' => 'Books',

            ]);
        }
    }

    $appartPlugin = new appartPlugin();
    $appartPlugin->register();

    // Activate plugin
    register_activation_hook(__FILE__, array($appartPlugin, 'activate'));

    // Deactivate plugin
    register_deactivation_hook(__FILE__, array($appartPlugin, 'deactivate'));

    //Uninstall
    register_uninstall_hook(__FILE__, array($appartPlugin, 'uninstall'));

}
