<?php
/**
 * Plugin Name: HTL Registrations
 * Description: Renders a form for creations of and a table for display of all users.
 * Version: 1.0
 * Author: David Kaufmann
 */

class Registrations {

    public function __construct() {
        // Constructor
        $this -> uploadRegistration();
        add_action('admin_menu', array($this, 'pluginSettingMenuEntry'));
        add_action('admin_init', array($this, 'settings'));
        add_shortcode('registrations', array($this, 'outputForm'));
    }

    function settings() {
        // Settings Page
        add_settings_section('ifp_first_section', null, null, 'it-form-settings-page');

        // Submit Message Entry
        add_settings_field('submit_message', 'Submit Message', array($this, 'messageHTML'), 'it-form-settings-page', 'ifp_first_section');
        register_setting('it_form_plugin', 'submit_message', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Submit Message'));
    }

    function pluginSettingMenuEntry() {
        // Einstellungen Entry
        add_options_page('Registrations Einstellungen', 'Registrations', 'manage_options', 'it_form_plugin', array($this, 'pluginSettingHTML'));
    }

    function messageHTML() {
        // Submit Message Input
        ?>
            <div class="input-group">
                <input type="text" name="submit_message" placeholder="Submit Message" class="form-control input-lg"
                    value="<?php echo get_option('submit_message', 'Vielen Dank für Ihre Anmeldung!'); ?>">
            </div>
        <?php
    }

    function pluginSettingHTML() {
        // Einstellungen HTML
        global $wpdb;
        $users = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "htl_users");

        ?>
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-5">
                        <h1>Einstellungen</h1>
                        <form action="options.php" method="post">
                            <?php
                            settings_fields('it_form_plugin');
                            do_settings_sections('it-form-settings-page');
                            submit_button();
                            ?>
                        </form>
                    </div>
                    <div class="col">
                        <h1>Registrierte Benutzer</h1>
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>EMail</th>
                                <th>Newsletter</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $row) { ?>
                                    <tr>
                                        <td><?php echo $row->first_name ?></td>
                                        <td><?php echo $row->last_name ?></td>
                                        <td><?php echo $row->email ?></td>
                                        <td><input type="checkbox" disabled <?php echo $row->newsletter_abo ?>></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
    }

    function outputForm() {
        // Registrations Form
        if (is_main_query() && !isset($_POST["first_name"])) {
            ?>
                <h3 class="lead">Anmeldung</h3>
                <form action="#" method="post" class="px-5 pt-5 pb-3 mb-5 border">
                    <input name='action' type="hidden" value='custom_form_submit'>
                    <div class="form-group">
                        <label>Vorname</label>
                        <input type="text" name="first_name" class="form-control" required placeholder="David">
                        <label>Nachname</label>
                        <input type="text" name="last_name" class="form-control" required placeholder="Kaufmann">
                        <label>E-Mail</label>
                        <input type="text" name="email" class="form-control" required placeholder="d.kaufmann@htlkrems.at">
                        <div class="form-check">
                            <input type="checkbox" name="newsletter_abo" class="form-check-input">
                            <label>Newsletter</label>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="contact_form">
                    <button class="btn btn-secondary" type="submit">Anmelden</button>
                </form>
            <?php
        } else {
            echo '<p>' . get_option('submit_message', 'Vielen Dank für Ihre Anmeldung!') . '</p>';
        }
    }

    function uploadRegistration() {
        // Database Insert
        if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"])) {
            global $wpdb;
            $table_name = $wpdb->prefix . "htl_users";
            $first_name = sanitize_text_field($_POST["first_name"]);
            $last_name = sanitize_text_field($_POST["last_name"]);
            $email = sanitize_text_field($_POST["email"]);

            if (isset($_POST["newsletter_abo"])) {
                $newsletter = "checked";
            } else {
                $newsletter = "";
            }

            $data = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'newsletter_abo' => $newsletter);
            $wpdb -> insert($table_name, $data);
        }
    }
}

new Registrations();