<?php
/**
 * Plugin Name: Post Statistics
 * Description: Another amazing plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

/**
 * https://developer.wordpress.org/reference/functions/add_action/
 * https://developer.wordpress.org/reference/hooks/admin_menu/
 */

class PostStat{
    function __construct(){
        add_action('admin_menu', 'pluginSettingMenuEntry');
        add_action('admin_init', array($this, 'settings'));
    }

    /**
     * 
     */

    function seeting(){
        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section('psp_first_section', null, null, 'post-stat-settings-page');
        add_settings_field('psp_location', 'Display location', array($this, 'locationHTML'), 'post-stat-settings-page');
    }

    function pluginSettingMenuEntry(){
        add_options_page('Post Stat Settings' , 'Post Stat', 'manage_options', 'htl-post-stat', array($this, 'pluginSettingHTML'));
    }
    
    /**
     * Markup für die Umsetzung der Backend Page des HTL Post Stat Plugins
     */
    
    function pluginSettingHTML(){
        echo "<p>Hello</p>";
    }
}

new PostStat();
