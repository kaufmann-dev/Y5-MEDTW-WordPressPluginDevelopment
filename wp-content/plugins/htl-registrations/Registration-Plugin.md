# Wordpress Plugin Development III - *Registration*

Das Plugin soll ein Registrierungsformular ausgeben, das die eingegebenen Daten in einer Tabelle in die Datenbank speichert.

Das Formular soll folgende Felder beinhalten:  
**First Name, Last Name, E-Mail, Newsletter** (Wobei das Feld 'Newsletter' ein Checkbox Feld sein soll)
Nach dem Absenden des Fomulars soll statt dem Formular, der Satz: "Danke für die Registrierung!" erscheinen.

Alle Eintragungen sollen in der Datenbank gespeichert werden:
Erzeugen Sie dafür eine neue Tabelle in der WP-Datenbank mit den Feldern aus dem Formular, und zusätzlich einem Feld, das das Eintragungsdatum und Uhrzeit speichert.

Für die Anbindung an die WP-DB verwenden sie das DB-Object von Wordpress (*class wpdb {}*)  
Eine Doku zu der Verwendung finden Sie hier: https://developer.wordpress.org/reference/classes/wpdb/


### Wordpress Database Management

Die Datenbank Connection steht bereits global zur Verfügung und sollte nur noch einmal im Code deklariert werden:

```php
global $wpdb;
```

>die Klasse ist hier zu finden: wp-includes/wp-db.php


*$wpdb* ist ein globales Object, das während des Ladens vom WordPress Core durch die Klasse "wpdb" erstellt wird. Dieses Object enthält z.B. Informationen zu den vorhandenen Tabellen der Datenbank, die letzte durchgeführte Query, die Zugangsdaten, oder auch den verwendeten Tabellen Prefix.

Um zum Beispiel alle Posts ausgeben wollen, die mit der Kategorie 'Development' kategorisiert wurden gehen wir wie folgt vor:

```php
global $wpdb;
$cities = $wpdb->get_results("SELECT *  FROM ".$wpdb->prefix."posts WHERE post_category LIKE 'Development'");
```

mit `$wpdb->show_errors()` kann die Ausgabe der Fehler bei SQL Abfragen aktiviert werden, und mit `$wpdb->hide_errors();` wieder beendet

**SQL-Injections**  
gerade bei Wordpress Plugins ist auf eine hohe Security zu achten, deshalb gehört es zum Standard Abfragen vor SQL-Injection zu schützen

```php
$category = 'Development';

global $wpdb;
$query = $wpdb->prepare("SELECT *  FROM ".$wpdb->prefix."posts WHERE post_category LIKE %s", $category);
$cities = $wpdb->get_results($query);
```

### Wordpress Shortcodes

Die Redakteure sollen das Registrierungsformular selbstständig überall auf der Website platzieren können. Dazu brauchen wir die Funktionalität eines *Shortcodes*

Ein einfaches Beispiel für die Erzeugung eines Shortcodes wäre:

```php
add_shortcode( 'foobar', 'foobar_func' );
function foobar_func() {
	return "foobar";
}
```

Die Redakteure müssen im Editor nur mehr den Shortcode in der Form ``[foobar]`` an der Position eintragen, an der das Formular erscheinen soll.

Die Dokumentation dazu finden sie hier: https://developer.wordpress.org/reference/functions/add_shortcode/



### AdminPage:
Zusätzlich soll es auch eine Seite im Admin-Interface geben:  
Registrieren Sie eine Seite, die im Admin-Interface zur Verfügung gestellt wird.
Auf der Seite sollen alle Registrierungen in einer Tabelle ausgegeben werden.

Zusätzlich soll hier auch der Satz "Danke für die Registrierung!" bearbeitet werden können!

### Erweiterung I - Installation des Plugins

Da das Plugin für jeden zur Verfügung stehen soll, braucht es auch ein Script das bei der Installation des Plugins die Tabelle in der DB einrichtet.

Dazu gibt es  *Activation* - Hooks

```php
register_activation_hook( __FILE__, 'my_plugin_create_table' );
function my_plugin_create_table() {
	// Create DB-Tables here
}
```
Dokumentation: https://developer.wordpress.org/reference/functions/register_activation_hook/

Vergessen Sie nicht, die Tabelle mit dem Prefix das bei der Installation von WP konfiguriert wurde anzulegen (``$wpdb->prefix``)

Creating Tabels with Plugins - Doku: https://codex.wordpress.org/Creating_Tables_with_Plugins


### Erweiterung II - Widget

Widgets sind Blöcke die einfach in verschiedenen Seitenbereichen der Website eingebunden werden können. Jedes Wordpress Theme bietet gewisse Bereich die mit Widgets befüllt werden können an. Im Admin-Interface kann man die Widgets (entweder angeboten von Wordpress selbst oder aus einem Plugin) dann in den gewissen Bereichen des Themes platzieren.

![](registrationPlugin_images/widgets-admin-bereich.png)
![](registrationPlugin_images/addwidgetdemo.gif)

Entwickeln Sie ein Widget, das auf der öffentlichen Seite eingebunden werden kann und folgendes anzeigt:
*Awesome! We have 79 Newsletter subscribers!*

<!-- https://www.ionos.at/digitalguide/hosting/blogs/wordpress-widgets/ -->

Dokumentation Widget Development: https://developer.wordpress.org/themes/functionality/widgets/


