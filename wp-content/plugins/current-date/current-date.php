<?php
/**
 * Plugin Name: Current Date
 * Description: Display date
 * Version: 1.0
 * Author: David Kaufmann
 */

 /**
  * Hooks im Allgemeinen und Filter Hooks im Speziellen bilden die Schnittstelle zum Wordpress-Core.
  * Dieser Hook wird bei jedem Klick im Frontend ausgeführt.
  * @param: the_content: enthält den jeweiligen Page/Post-Inhalt
  * @param: addDateToEndOfPost: Die Funktion, die es auszuführen gibt.
  */

add_filter('the_content', 'addDateToEndOfThePost');

function addDateToEndOfThePost($content){
    return $content . "<p>" . date('d.m.Y') . "</p>";
}