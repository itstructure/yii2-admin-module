<?php

use Itstructure\AdminModule\widgets\menu\MainMenuItem;

/* @var $item MainMenuItem */
?>

<li <?php if (!empty($item->getClass())):?> class="<?php echo $item->getClass(); ?>" <?php endif; ?> >

    <a href="<?php echo $item->getUrl() ?>" target="_self">

        <i class="<?php echo $item->getIcon() ?>"></i>
        <span><?php echo $item->getTitle() ?></span>

        <?php if ($item->hasSubItems()):?>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        <?php endif; ?>
    </a>

    <?php if ($item->hasSubItems()):?>
        <ul class="treeview-menu">
            <?php
            /* @var $subItem MainMenuItem */
            foreach ($item->getSubItems() as $subItem) {
                echo $subItem->run();
            } ?>
        </ul>
    <?php endif; ?>

</li>
