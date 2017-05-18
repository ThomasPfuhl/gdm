<?php

$name = $argv[1];
$names = $name . 's';
$cname = ucfirst($name);
$cnames = $cname . 's';

$navbar_content = file_get_contents('../../resources/views/partials/nav.blade.php');

$xmlstr = "<?xml version='1.0' standalone='yes'?>" . PHP_EOL . $navbar_content;

$nav = new SimpleXMLElement($xmlstr);

$menu = $nav->xpath('//ul')[0];

//create new list item as follows:
//    <li class="{{ (Request::is('dummies') ? 'active' : '') }}">
//        <a href="{{ URL::to('dummies') }}">Dummies</a>
//    </li>
$new_item = $menu->addChild('li');
$new_item->addAttribute('class', "{{ (Request::is('" . $cnames . "') ? 'active' : '') }}");
$new_link = $new_item->addChild('a', $cnames);
$new_link->addAttribute('href', "{{ URL::to('" . $names . "') }}");


// we need empty elements in html output
$dom_sxe = dom_import_simplexml($nav);  // Returns a DomElement object

$dom_output = new DOMDocument('1.0');
$dom_output->preserveWhiteSpace = true;
$dom_output->formatOutput = true;
$dom_sxe = $dom_output->importNode($dom_sxe, true);
$dom_sxe = $dom_output->appendChild($dom_sxe);

$new_nav_string = $dom_output->saveXML($dom_output->documentElement, LIBXML_NOEMPTYTAG);
$new_nav_string = html_entity_decode($new_nav_string, ENT_HTML5, 'utf-8');


// make backup
copy('../../resources/views/partials/nav.blade.php', '../../resources/views/partials/nav' . date("_Ymd_his") . '.blade.php');

/*
  $new_nav_string = str_replace("<?xml version=\"1.0\"?>\n", '', html_entity_decode($nav->asXML(), ENT_HTML5, 'utf-8'));
 */

file_put_contents('../../resources/views/partials/nav.blade.php', $new_nav_string);

//file_put_contents('../../resources/views/partials/nav.blade.php', $new_nav_string);
//file_put_contents('../../resources/views/partials/nav' . '_dummy' . '.blade.php', $new_nav_string);

//echo "\n----------\n";

