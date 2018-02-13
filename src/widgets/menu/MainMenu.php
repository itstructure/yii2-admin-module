<?php

namespace Itstructure\AdminModule\widgets\menu;

use Yii;
use yii\base\Widget;

/**
 * Class MainMenu
 * Widget to render main menu.
 *
 * @property MainMenuItem[] $menuItems
 *
 * @package Itstructure\AdminModule\widgets
 */
class MainMenu extends Widget
{
    /**
     * Main menu item config.
     *
     * @var MainMenuItem[]
     */
    protected $menuItems = [];

    /**
     * @return MainMenuItem[]
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     * Main menu items setter.
     *
     * @param array|MainMenuItem[] $menuItems menu items config.
     *
     * @return $this
     */
    public function setMenuItems(array $menuItems)
    {
        $this->menuItems = [];
        foreach ($menuItems as $item) {
            $this->addMenuItem($item);
        }
        return $this;
    }

    /**
     * Create a MenuItem instance and fill menu items array.
     *
     * @param array|MainMenuItem $item
     *
     * @return void
     */
    public function addMenuItem($item)
    {
        if (is_array($item)) {
            if (!array_key_exists('class', $item)) {
                $item['class'] = MainMenuItem::class;
            }
            $item = Yii::createObject($item);
        }
        $this->menuItems[] = $item;
    }

    /**
     * Returns main menu template with rendered menu items.
     *
     * @return string.
     */
    public function run()
    {
        return $this->render('main-menu', [
            'menuItems' => $this->menuItems,
        ]);
    }
}
