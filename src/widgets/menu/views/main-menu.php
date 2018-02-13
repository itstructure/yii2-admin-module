<?php

use Itstructure\AdminModule\widgets\menu\MainMenuItem;

/* @var $menuItems MainMenuItem[] */
?>

<ul class="sidebar-menu tree" data-widget="tree">

    <?php foreach ($menuItems as $item) {
        echo $item->run();
    } ?>

</ul>
