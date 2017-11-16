<?php

/** Creation Tool for menu_items
 *
 * @author Thomas Pfuhl <thomas.pfuhl@mfn-berlin.de>
 * @todo:  install and use  https://github.com/constant-null/backstubber
 */
echo "\n adding menu item for " . $name;

if (strtolower($name) !== "aggregations") {
    
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
   
<li class="{{ (Request::is('gdm_aggregations') ? 'active' : '') }}">
    <a href="{{ URL::to('gdm_aggregations') }}">Aggregations</a>
</li>

CODE;

$current_content = file_get_contents("../../resources/views/partials/menu-meta-items.blade.php");
$pos = strpos($current_content, trim($content));
if ($pos === FALSE) {
    file_put_contents("../../resources/views/partials/menu-meta-items.blade.php", $content, FILE_APPEND | LOCK_EX);
}


// start menu item

$content = <<<'CODE'
   
<li class="{{ (Request::is('ITEM') ? 'active' : '') }}">
    <a href="{{ URL::to( 'ITEM' ) }}"><i class="fa fa-home"></i> Start</a> 
</li>

CODE;

$startMenuItem = toCamelCase(GDM_MAIN_TABLE);
$content = str_replace('ITEM', $startMenuItem, $content);
file_put_contents("../../resources/views/partials/menu-start-item.blade.php", $content);
