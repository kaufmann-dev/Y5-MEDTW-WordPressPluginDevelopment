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
        add_options_page(
            'Post Stat Settings' ,
            'Post Stat',
            'manage_options',
            'htl-post-stat',
            array($this, 'pluginSettingHTML')
        );
    }
    
    /**
     * Markup für die Umsetzung der Backend Page des HTL Post Stat Plugins
     */

    function pluginSettingHTML(){
        ?>
            <div class="wrap">
                <h1>Post Stat Settings</h1>
                <form action="options.php" method="post">
                    <?php
                        settings_fields('post-stat-plugin');
                        do_settings_sections('post-stat-settings-page');
                        submit_button();
                    ?>
                </form>
        <?php
    }

    /**
     * name: muss sich mit der ID des jeweiligen Setting FIelds decken => "Display location" ist das psp_location
     */

    function locationHTML(){
        ?>
            <select name="psp_location">
                <option value="0">Beginning of post</option>
                <option value="1">End of post</option>
        <?php
    }
}

new PostStat();
