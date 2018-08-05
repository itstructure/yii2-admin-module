<?php

namespace Itstructure\AdminModule\widgets\menu;

use Yii;
use yii\base\{Widget, InvalidConfigException};

/**
 * Class MainMenuItem
 * Widget to render menu item for main menu.
 *
 * @property string $icon Css-class for icon of menu item.
 * Example: fa fa-database.
 * @property bool $active Is menu item need to be opened (if has subitems) or selected.
 * @property bool $display Is menu item need to be displayed.
 * @property string $title Title of menu item.
 * @property MainMenu[] $subItems Array of subItems menu items.
 * @property string $url Url of menu item.
 * @property string $class Class for <li> tag.
 *
 * @package Itstructure\AdminModule\widgets
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
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
     * Is menu item need to be opened (if has subitems) or selected.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Is menu item need to be displayed.
     *
     * @var bool
     */
    protected $display = true;

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
     * Class for <li> tag.
     *
     * @var string
     */
    protected $class;

    /**
     * Executes the widget.
     *
     * @return string the result of widget execution to be outputted.
     */
    public function run(): string
    {
        if (false === $this->display) {
            return '';
        }

        if ($this->hasSubItems()) {
            $this->class = $this->isActive() ? 'active treeview' : 'treeview';
        } else {
            $this->class = $this->isActive() ? 'active' : '';
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
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Icon setter.
     *
     * @param string $icon Icon of menu item
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Url getter.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Url setter.
     *
     * @param string $url Url of menu item
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get class for <li> tag.
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Is menu item need to be opened (if has subitems) or selected.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Set menu item need to be opened (if has subitems) or selected.
     *
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
     * Is menu item need to be displayed.
     *
     * @return bool
     */
    public function isDisplay()
    {
        return $this->display;
    }

    /**
     * Set menu item need to be displayed.
     *
     * @param bool $display
     *
     * @return $this
     */
    public function setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }

    /**
     * Get title of menu item.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set title of menu item.
     *
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
     * Get array of subItems menu items.
     *
     * @return MainMenu[]
     */
    public function getSubItems()
    {
        return $this->subItems;
    }

    /**
     * Set array of subItems menu items.
     *
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
     * Add to array of subItems menu items.
     *
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
     * Check if item has subitems.
     *
     * @return bool
     */
    public function hasSubItems()
    {
        return count($this->subItems) > 0;
    }
}
