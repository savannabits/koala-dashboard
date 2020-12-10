<?php
namespace Savannabits\Koaladmin\Helpers;

define('MENU_FILE','koala_menu.json');
class KoalaHelper
{
    public static function pushItemToJsonMenu(array $item) {
        if (!collect($item)->has('slug')) return false;
        $array = json_decode(file_get_contents(base_path(MENU_FILE)));
        $existing = collect($array)->where('slug','=', $item['slug'])->first();
        if ($existing) return null;
        array_push($array,$item);
        return file_put_contents(base_path(MENU_FILE),json_encode($array,JSON_PRETTY_PRINT))!==false;
    }
    public static function fetchMenuItems() {
        $items = json_decode(file_get_contents(base_path('koala_menu.json')));
        return $items;
    }

    /**
     * @param array $items
     * @return MenuItem[]
     */
    public static function arrayToMenuItems(array $items) {
        $menuItems = collect([]);
        foreach ($items as $item) {
            $collection = collect($item);
            $menuItem = MenuItem::instance()
                ->setTitle($collection->get('title'))
                ->setSlug($collection->get('slug'))
                ->setPermission($collection->get('permission_name'))
                ->setIcon('<i class="'.$collection->get('icon_class').'"></i>')
            ;
            if ($collection->get('manual_link')) {
                $menuItem->setLink($collection->get('manual_link'));
            } else {
                if ($collection->get('route_name')) {
                    $menuItem->setLink(route($collection->get('route_name')));
                } else {
                    $menuItem->setLink('#');
                }
            }
            $menuItem->setHasChildren($collection->get('has_children'));
            if (count($collection->get('children'))) {
                $children = self::arrayToMenuItems($collection->get('children'));
                $menuItem->setHasChildren(true)->setChildren($children);
            }

            $menuItems->push($menuItem);
        }
        return $menuItems->toArray();
    }

    /**
     * @return \Spatie\Menu\Menu
     */
    public static function makeMenu() {
        $items = self::fetchMenuItems();
        $menuItems = self::arrayToMenuItems($items);
        $menu = KoalaMenu::instance()->setItems($menuItems)->make();
        return $menu;
    }
}
