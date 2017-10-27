<?php

/** Creation Tool for menu_items
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
echo "\n adding menu items for " . $name;

if ($name !== "aggregations") {
    //$name = $argv[1];
    $cname = ucfirst($name);

    $content = <<<'CODE'

<li class="{{ (Request::is('NAME') ? 'active' : '') }}">
    <a href="{{ URL::to('NAME') }}">CNAME</a>
</li>

CODE;

    $content = str_replace('CNAME', $cname, $content);
    $content = str_replace('NAME', $name, $content);

    $current_content = file_get_contents("../../resources/views/partials/menu-items.blade.php");
    $pos = strpos($current_content, trim($content));
    if ($pos === FALSE) {
        file_put_contents("../../resources/views/partials/menu-items.blade.php", $content, FILE_APPEND | LOCK_EX);
    }
}

// metatables
$content = <<<'CODE'
   
<li class="{{ (Request::is('aggregations') ? 'active' : '') }}">
    <a href="{{ URL::to('aggregations') }}">Aggregations</a>
</li>

CODE;

$current_content = file_get_contents("../../resources/views/partials/menu-meta-items.blade.php");
$pos = strpos($current_content, trim($content));
if ($pos === FALSE) {
    file_put_contents("../../resources/views/partials/menu-meta-items.blade.php", $content, FILE_APPEND | LOCK_EX);
}



/*
// NOT NEEDED
$navbar_content = file_get_contents('../../resources/views/partials/nav.blade.php');

$xmlstr = "<?xml version='1.0' standalone='yes'?>" . PHP_EOL . $navbar_content;

$nav = new SimpleXMLElement($xmlstr);

$menu = $nav->xpath('//ul')[0];

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

file_put_contents('../../resources/views/partials/nav.blade.php', $new_nav_string);
*/
