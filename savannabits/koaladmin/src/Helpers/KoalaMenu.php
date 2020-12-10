<?php

namespace Savannabits\Koaladmin\Helpers;

use Illuminate\Support\Collection;
use Spatie\Menu\Link;

class KoalaMenu
{
    /**
     * @var MenuItem[] $menu
     */
    private $items;
    private
        $activeClass = '',
        $activeClassOnParent = true,
        $menuAttributes = [],
        $itemParentAttributes = [],
        $itemAttributes = [],
        $currentActive;

    public function __construct()
    {
        $instance = $this;
        $instance->currentActive = url()->current();
        $instance->activeClass = "bg-primary-lighter dark:bg-primary text-gray-600 dark:text-gray-200 border-b-0 border-l-4 border-primary dark:border-primary-darker";
        $instance->itemParentAttributes = [
            "class" => "relative p-0"
        ];
        $instance->itemAttributes = [
            "class" => 'inline-flex items-center w-full text-sm p-4 my-0 border-b font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200'
        ];
    }

    public static function instance()
    {
        $instance = new self();
        return $instance;
    }

    /**
     * @param MenuItem[] $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function setMenuAttributes(array $attributes)
    {
        $this->menuAttributes = array_merge($this->menuAttributes,$attributes);
        return $this;
    }
    public function setActiveClass(string $class) {
        $this->activeClass = $class;
        return $this;
    }
    public function setActiveClassOnParent($useParent=true) {
        $this->activeClassOnParent = $useParent;
        return $this;
    }
    public function setItemParentAttributes(array $attributes) {
        $this->itemParentAttributes = array_merge($this->itemParentAttributes, $attributes);
        return $this;
    }
    public function setItemAttributes(array $attributes) {
        $this->itemAttributes = array_merge($this->itemAttributes, $attributes);
        return $this;
    }
    public function setActiveLink(string $current_active) {
        $this->currentActive = $current_active;
        return $this;
    }

    /**
     * @return \Spatie\Menu\Menu
     */
    public function make()
    {
        $menu = \Spatie\Menu\Menu::new();
        foreach ($this->menuAttributes as $key=>$menuAttribute) {
            $menu->setAttribute($key,$menuAttribute);
        }
        foreach ($this->items as $item) {
            if ($item->getPermission()){
                $menu->addIf(\Auth::check() && \Auth::user()->can($item->getPermission()),\Spatie\Menu\Link::to($item->getLink(), \Spatie\Menu\Html::raw($item->getTitle().$item->getIcon())->render()));
            } else {
                $menu->add(\Spatie\Menu\Link::to($item->getLink(), \Spatie\Menu\Html::raw($item->getTitle().$item->getIcon())->render()));
            }
        }
        $menu->each(function ($item) {
            foreach ($this->itemParentAttributes as $key => $itemParentAttribute) {
                $item->setParentAttribute($key, $itemParentAttribute);
            }
            foreach ($this->itemAttributes as $key => $itemAttribute) {
                $item->setAttribute($key, $itemAttribute);
            }
        })
        ->setActiveClassOnParent($this->activeClassOnParent)
        ->setActiveClass($this->activeClass)
        ->setActive($this->currentActive);
        return $menu;
    }
}
