# Wordpress Plugin Development I - Current Date Plugin

Ziel ist die Entwicklung eines Plugins, das das aktuelle Datum am Ende oder Anfang eines *Posts* oder einer *Page*
hinzufügt. Grundlage bildet das *Wordpress Plugin Development Tutorial* (https://developer.wordpress.org/plugins/intro/)
. Wenn es eine Regel bei der Wordpress-Entwicklung gibt, dass diese:

> *Don’t touch WordPress core.*

Besteht also die Notwendigkeit, die Wordpress-Kernfunktion zu erweitern, dann hat das mithilfe eines Plugins zu
erfolgen. Punkt.

## Plugin Basics

Jedes Plugin wird in einen separaten Ordner gepackt, welcher im Verzeichnis `wp-content\plugins` zu erstellen ist. Der
Name muss *unique* sein, sodass es zu keinen Kollisionen kommt. Ordner `htl-current-date` erstellen.

```shell
wordpress\plugins$ mkdir htl-current-date
```

Anschließend die Datei `htl-current-date.php` im Ordner `htl-current-date` erstellen; wobei an dieser Stelle
festgehalten sei, dass die Namen nicht unbedingt gleich sein müssen. Das PHP-Sktipt könnte genauso gut `test.php`
heißen.

Die Wordpress-Dokumentation (https://developer.wordpress.org/plugins/plugin-basics/header-requirements/) definiert
einige Anforderungen an den Kommentar-Header eines Plugins. Eine Minimalversion könnte folgendermaßen aussehen:

````php
<?php
/**
 * Plugin Name: Our first Plugin
 * Description: Amazing Plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */
````

Nach diesem Schritt sollte das Plugin *Our first Plugin* im Wordpress-Backend ersichtlich sein (siehe *Plugins*).
Lediglich die Aktivierung ist noch ausständig. Momentan ist noch nicht viel zu sehen. Es braucht noch ein wenig Code,
der die Ausgabe des Datums am z.B. Ende eines Posts/einer Page erzeugt.

Nachdem die Ausgabe dynamisch - also ohne unser Zutun - bei jedem Post erfolgen soll, braucht es eine "
Wordpress-Schnittstelle", die uns die Verzahnung von Theme und Plugin ermöglicht. Die Lösung sind sog. *
Hooks* (https://developer.wordpress.org/plugins/hooks/)
.

````php
<?php
/**
 * Plugin Name: Our first Plugin
 * Description: Amazing Plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

add_filter('the_content', 'addDateToEndOfPost');
````

Mit einem *Filter*-Hook kann man Daten (= Content) während der Ausführung von Wordpress-Core ändern. Die Umsetzung
erfolgt mit der Funktion `add_filter` in der Plugin-Datei. Mit dem Argument `the_content` wird der jeweilige
Post/Page-Inhalt von Wordpress bereitgestellt. Das zweite Argument ist der frei wählbare Name der Callback-Funktion, die
es noch zu implementieren gilt:

```php
<?php
/**
 * Plugin Name: Our first Plugin
 * Description: Amazing Plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

add_filter('the_content', 'addDateToEndOfPost');

function addDateToEndOfPost($content){
return $content . "<p>Hello!</p>";
}
```

Wordpress kopiert den Seiteninhalt (eines Posts/einer Page) in das Argument `$content`. Diesem wird in weiterer Folge
der HTML-Absatz mit "Hello" hinzugefügt - am Ende wohlgemerkt. Abschließend ist "Hello"-Ausgabe mit dem Datum zu
ersetzen:

```php
<?php
/**
 * Plugin Name: Our first Plugin
 * Description: Amazing Plugin.
 * Version: 1.0
 * Author: HTL Super Coder
 */

add_filter('the_content', 'addDateToEndOfPost');

function addDateToEndOfPost($content){
    return $content . "<p>".date('d.m.Y')."</p>";
}
```