<?php
/**
 * Plugin Name: Registrations
 * Description: Late Registration
 * Version: 0.1
 * Author: Kanye West
 */

/**
 * https://developer.wordpress.org/reference/functions/add_action/
 * https://developer.wordpress.org/reference/hooks/admin_menu/
 */

class Registration{
    function __construct(){
        add_action(
            'admin_menu',
            array($this, 'pluginSettingMenuEntry')
        );
        add_action(
            'admin_init',
            array($this, 'settings')
        );
    }

    function settings(){
        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section(
            'psp_first_section',
            null,
            null,
            'registrations-settings-page'
        );

        // https://developer.wordpress.org/reference/functions/add_settings_field/
        add_settings_field(
            'psp_location',
            'Display location', 
            array($this, 'locationHTML'), 'registrations-settings-page', 'psp_first_section');

        // https://developer.wordpress.org/reference/functions/register_setting/
        register_setting(
            'registrations-plugin',
            'psp_location',
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 0)
        );

        // Selbst erstellte Funktionen

        add_settings_field(
            'psp_headline',
            'Headline Text',
            array($this, 'headlineHTML'),
            'registrations-settings-page',
            'psp_first_section'
        );
        register_setting(
            'registrations_plugin',
            'psp_headline',
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Registration')
        );

        add_settings_field(
            'psp_wordcount',
            'Word Count',
            array($this, 'checkboxHTML'),
            'registrations-settings-page',
            'psp_first_section',
            array('name'=>'psp_wordcount')
        );
        register_setting(
            'registrations_plugin',
            'psp_wordcount',
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 1)
        );

        add_settings_field(
            'psp_charcount',
            'Character Count',
            array($this, 'checkboxHTML'),
            'registrations-settings-page',
            'psp_first_section',
            array('name'=>'psp_charcount')
        );
        register_setting(
            'registrations_plugin',
            'psp_charcount',
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 1)
        );

        add_settings_field(
            'psp_readtime',
            'Read time',
            array($this, 'checkboxHTML'),
            'registrations-settings-page',
            'psp_first_section',
            array('name'=>'psp_readtime')
        );
        register_setting(
            'registrations_plugin',
            'psp_readtime',
            array('sanitize_callback' => 'sanitize_text_field', 'default' => 1)
        );
    }

    // Benötigt für die selbst erstellten Funktionen
    function checkboxHTML($args){
        ?>
            <input
                type="checkbox" 
                name="<?php echo $args['name'] ?>" 
                value='1' 
                <?php checked(get_option($args['name']), 1); ?>
            >
        <?php
    }

    function pluginSettingMenuEntry(){
        // https://developer.wordpress.org/reference/functions/add_options_page/
        add_options_page(
            'Registrations Settings' ,
            'Registrations',
            'manage_options',
            'htl-registrations',
            array($this, 'pluginSettingHTML')
        );
    }
    
    /**
     * Markup für die Umsetzung der Backend Page des HTL Registrations Plugins
     */

    function pluginSettingHTML(){
        ?>
            <div class="wrap">
                <h1>Registrations Settings</h1>
                <form action="options.php" method="post">
                    <?php
                        settings_fields('registrations-plugin');
                        do_settings_sections('registrations-settings-page');
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
                <option value="0"><?php selected(get_option('psp_location'), '0') ?>Beginning of post</option>
                <option value="1"><?php selected(get_option('psp_location'), '1') ?>End of post</option>
            </select>
        <?php
    }

    function headlineHTML(){
        ?>
            <input type="text" name="psp_headline" value="<?php echo get_option('psp_headline', 'Registrations') ?>">
        <?php
    }
}

new Registration();
