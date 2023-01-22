# Wordpress Plugin Development II - Post Statistics

Ziel ist die Entwicklung eines Plugins, das statische Kennwerte, wie die Anzahl der Wörter oder Zeichen eines Posts,
ermittelt und ausgibt.

![](.postStatPlugin_images/frontend.png)

## Menü-Eintrag erstellen

Nachdem das Plugin über einige Konfigurationsmöglichkeiten verfügen soll, ist die Erweiterung des Backends notwendig. Es
gilt den Hauptmenüeintrag *Settings* um den Unterpunkt *Post Stat* zu erweitern. Zu Testzwecken erfolgt die Ausgabe
von "Hello", wie nachfolgender Abbildung zu entnehmen ist.

![](.postStatPlugin_images/menueeintrag-settings.png)

Der entsprechende Code gestaltet sich folgendermaßen:

````php
/**
 * Plugin Name: Post Statistics
 * Description: Another amazing plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

add_action('admin_menu', 'pluginSettingMenuEntry');

function pluginSettingMenuEntry(){
    add_options_page('Post Stat Settings' , 'Post Stat', 'manage_options', 'post_stat_plugin', 'pluginSettingHTML');
}

function pluginSettingHTML(){
    echo "<p>Hello</p>";
}
````

Um Konflikte bzgl. Namensgleichheiten mit anderen Plugins (oder dem Wordpress-Core) zu vermeiden, empfiehlt sich die
Kapselung in einer Klasse (siehe Klasse `PostStat`). Dadurch reduziert sich das Konfliktpotenzial zumindest nur mehr auf
den Klassennamen.

````php
/**
 * Plugin Name: Post Statistics
 * Description: Another amazing plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

class PostStat
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'pluginSettingMenuEntry'));

    }

    function pluginSettingMenuEntry()
    {
        add_options_page('Post Stat Settings', 'Post Stat', 'manage_options', 'post_stat_plugin', array($this, 'pluginSettingHTML'));
    }

    function pluginSettingHTML()
    {
          echo "<div class='wrap'><h1>Post Stat Settings</h1></div>";
    }

}

new PostStat();
````

Im Zuge dieses Arbeitsschrittes wurde die Ausgabe der Funktion `pluginSettingHTML` auf "Post Stat Settings"
geändert. Die *Class* `wrap` ist für die Umsetzung des Wordpress-spezifischen Look & Feels verantwortlich.

## Post Stat Settings-Seite des Backendes implementieren

Dieser Abschnitt widmet sich der Erstellung jenes Backend-Formulars, mit dessen Hilfe Plugin-spezifische Einstellungen
vorgenommen werden können. Diese sind - egal, ob Theme oder Plugin -, in der DB zu speichern. Wordpress stellt hierzu
die DB-Tabelle *options* (vgl. *wp_options* beim Default-Prefix) zur Verfügung. Der Zugriff auf diese Tabelle erfolgt
mithilfe des sog. *Settings API* (https://codex.wordpress.org/Settings_API); es braucht also keine SQL-Statements. Glück
gehabt! Das *Settings API* stellt darüber hinaus noch eine Reihe weitere Funktionen zur Erstellung des Formulars (vgl.
HTML-Form) bereit.

### Umsetzung der Drop Down Liste für die Location

Hierzu braucht es einen HTML-Select-Tag mit den Optionen "Beginning of the post" und "End of the post".

![](.postStatPlugin_images/PostStatSettings-Form-Backend-1.png)

Der dazugehörige Quellcode gestaltet sich wie folgt:

````php
class PostStat
{
    function __construct(){
        add_action('admin_menu', array($this, 'pluginSettingMenuEntry'));
        add_action('admin_init', array($this, 'settings'));
    }

    function settings(){
        //add_settings_section( string $id, string $title, callable $callback, string $page )
        add_settings_section('psp_first_section', null, null, 'post-stat-settings-page');
        //add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )
        add_settings_field('psp_location', 'Display Location', array($this, 'locationHTML'), 'post-stat-settings-page', 'psp_first_section');
        //register_setting( string $option_group, string $option_name, array $args = array() )
        register_setting('post_stat_plugin', 'psp_location', array('sanitize_callback' => 'sanitize_text_field', 'default'=>0));
    }

    function pluginSettingMenuEntry(){
        add_options_page('Post Stat Settings', 'Post Stat', 'manage_options', 'post_stat_plugin', array($this, 'pluginSettingHTML'));
    }

    function pluginSettingHTML(){ ?>
        <div class='wrap'><h1>Post Stat Settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('post_stat_plugin');
                do_settings_sections('post-stat-settings-page');
                submit_button();
                ?>
            </form>
        </div>
    <?php }

    function locationHTML(){?>
        <select name="psp_location">
            <option value="0">Beginning of post</option>
            <option value="1">End of post</option>
        </select>
    <?php }
}
new PostStat();
````

Das Location-Feld mit dem Wert aus der DB initialisieren: Code-Auszug der Select:

````php
    function locationHTML()
    {
        ?>
        <select name="psp_location">
            <option value="0" <?php selected(get_option('psp_location'), '0') ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('psp_location'), '1') ?>>End of post</option>
        </select>
    <?php }
````

Dem gleichen Prinzip folgen die restlichen Formular-Elemente "Headline Text", "Word Count", "Character Count" und "Read
Time" - einerseits ist die Erweiterung der `settings`-Funktion und andererseits braucht es die Implementierung der
Callback-Funktion `checkboxHTML`. Der hierfür erforderliche Quellcode (Auszug):

````php
<?php
/**
 * Plugin Name: Post Statistics
 * Description: Another amazing plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

    function settings()
    {
        //add_settings_section( string $id, string $title, callable $callback, string $page )
        add_settings_section('psp_first_section', null, null, 'post-stat-settings-page');
        //add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )
        add_settings_field('psp_location', 'Display Location', array($this, 'locationHTML'), 'post-stat-settings-page', 'psp_first_section');
        //register_setting( string $option_group, string $option_name, array $args = array() )
        register_setting('post_stat_plugin', 'psp_location', array('sanitize_callback' => 'sanitize_text_field', 'default' => 0));

        add_settings_field('psp_headline', 'Headline Text', array($this, 'headlineHTML'), 'post-stat-settings-page', 'psp_first_section');
        register_setting('post_stat_plugin', 'psp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistic'));

        add_settings_field('psp_wordcount', 'Word Count', array($this, 'checkboxHTML'), 'post-stat-settings-page', 'psp_first_section', array('name'=>'psp_wordcount'));
        register_setting('post_stat_plugin', 'psp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => 1));

        add_settings_field('psp_charcount', 'Character Count', array($this, 'checkboxHTML'), 'post-stat-settings-page', 'psp_first_section', array('name'=>'psp_charcount'));
        register_setting('post_stat_plugin', 'psp_charcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => 1));

        add_settings_field('psp_readtime', 'Read time', array($this, 'checkboxHTML'), 'post-stat-settings-page', 'psp_first_section',  array('name'=>'psp_readtime'));
        register_setting('post_stat_plugin', 'psp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => 1));

    }

    function checkboxHTML($args){?>
        <input type="checkbox" name="<?php echo $args['name'] ?>" value='1' <?php checked(get_option($args['name']), 1);?>>
    <?php }

````

Der Ist-Stand im Backend gestaltet sich folgendermaßen:
![](.postStatPlugin_images/backend-settings-form.png)

Validierung der Benutzereingaben mit der Funktion `sanitizeLocation` (Auszug):

````php

    register_setting('post_stat_plugin', 'psp_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => 0));

    function sanitizeLocation($inputValue)
    {
        if ($inputValue != '0' && $inputValue != '1') {
            add_settings_error('psp_location', 'psp_location_error', 'Display Location must be either beginning or end.');
            return get_option('psp_location');
        }
        return $inputValue;
    }

````

## Frontend-Ausgabe implementieren

Abschließend ist noch jener Code zu implementieren, der die Anzahl der Wörter und Zeichen ermittelt und im Frontend
ausgibt.

![](.postStatPlugin_images/frontend.png)

Auf Code-Ebene ist nebern der Erweiterung des Konstruktors die Implementierung der Funktion `outputStats` notwendig.

````php
    function __construct()
    {
        add_action('admin_menu', array($this, 'pluginSettingMenuEntry'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'outputStats'));
    }

    function outputStats($content)
    {
        if ((is_main_query() AND is_single()) AND
            get_option('psp_wordcount', '1') OR
            get_option('psp_charcount', '1') OR
            get_option('psp_readtime', '1')){

            $html='<h3>'.get_option('psp_headline', 'Display Location').'</h3><p>';

            if(get_option('psp_wordcount', '1') || get_option('psp_readtime', '1')){
                $wordCount = str_word_count(strip_tags($content));
            }
            if(get_option('psp_wordcount')){
                $html.= "This page has " . $wordCount." words.<br>";
            }
            if(get_option('psp_charcount'))
                $html.= "This page has " . strlen($content)." characters.<br>";

            if(get_option('psp_readtime'))
                $html.= "This page will take " . round($wordCount/240). " minute(s) to read.</p>";

            return $html.$content;
        }
        else
            return $content;
    }

````

Abschließend ist noch die Ausgabe, ob die Statistik am Anfang oder am Ende eines Beitages/einer Seite stehen, soll zu
implementieren. Hierzu ist eine weitere Anfage der `psp_location` in der Funktion `outputStats` erforderlich.

````php
    function outputStats($content)
    {
        if ((is_main_query() AND is_single()) AND
            get_option('psp_wordcount', '1') OR
            get_option('psp_charcount', '1') OR
            get_option('psp_readtime', '1')){

            $html='<h3>'.get_option('psp_headline', 'Display Location').'</h3><p>';

            if(get_option('psp_wordcount', '1') || get_option('psp_readtime', '1')){
                $wordCount = str_word_count(strip_tags($content));
            }
            if(get_option('psp_wordcount')){
                $html.= "This page has " . $wordCount." words.<br>";
            }
            if(get_option('psp_charcount'))
                $html.= "This page has " . strlen($content)." characters.<br>";

            if(get_option('psp_readtime'))
                $html.= "This page will take " . round($wordCount/240). " minute(s) to read.</p>";

            if(get_option('psp_location', '0'))
                return $content.$html;
            else
                return $html.$content;
        }
        else
            return $content;
    }

````

