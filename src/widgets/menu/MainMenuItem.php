<?php

namespace Itstructure\AdminModule\widgets\menu;

use Yii;
use yii\base\{Widget, InvalidConfigException};

/**
 * Class MainMenuItem
 * Widget to render menu item for main menu.
 *
 * @property string $icon
 * @property bool $active
 * @property string $title
 * @property MainMenu[] $subItems
 * @property string $url
 *
 * @package Itstructure\AdminModule\widgets
 */
class MainMenuItem extends Widget
{
    /**
     * Css-class for icon of menu item.
     * Example: fa fa-database.
     *
     * @var string
     */
    protected $icon = '';
    /**
     * Is menu item need to be displayed.
     *
     * @var bool
     */
    protected $active = true;
    /**
     * Title of menu item.
     *
     * @var string
     */
    protected $title = '';
    /**
     * Array of subItems menu items.
     *
     * @var MainMenu[]
     */
    protected $subItems = [];
    /**
     * Url of menu item.
     *
     * @var string
     */
    protected $url = '';

    /**
     * Executes the widget.
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        if (false === $this->active) {
            return '';
        }

        return $this->render('main-menu-items', [
            'item' => $this,
        ]);
    }

    /**
     * Icon getter.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Icon setter.
     *
     * @param string $icon Icon of menu item
     *
     * @return void
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Url getter.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Url setter.
     *
     * @param string $url Url of menu item
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return MainMenu[]
     */
    public function getSubItems()
    {
        return $this->subItems;
    }

    /**
     * @param array|MainMenu[] $subItems
     *
     * @throws InvalidConfigException
     *
     * @return $this
     */
    public function setSubItems(array $subItems)
    {
        $this->subItems = [];
        foreach ($subItems as $menuItem) {
            $this->addSubItems($menuItem);
        }

        return $this;
    }

    /**
     * @param array|MainMenu $menuItem
     *
     * @throws InvalidConfigException
     *
     * @return $this
     */
    public function addSubItems($menuItem)
    {
        if (is_array($menuItem)) {
            if (!array_key_exists('class', $menuItem)) {
                $menuItem['class'] = MainMenuItem::class;
            }

            $menuItem = Yii::createObject($menuItem);
        }

        $this->subItems[] = $menuItem;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasSubItems()
    {
        return count($this->subItems) > 0;
    }
}
