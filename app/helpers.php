<?php
function makeMenu() {
    $menu = \Spatie\Menu\Menu::new()
        ->setAttribute('class','list-none')
        ->setAttribute('x-cloak')
        ->setAttribute("role","navigation")
        ->add(\Spatie\Menu\Link::to(route('home'),"Home"))
        ->add(\Spatie\Menu\Link::to(route('alerts'),"Alerts"))
        ->add(\Spatie\Menu\Link::to(route('login'),"Login"))
        ->each(function ($item) {
            $item->setParentAttribute('class','p-2 py-4 border-b font-semibold hover:bg-secondary-lighter')
            ;
        })
        ->setActiveClass('bg-blue-100 border-l-4 border-primary')
        ->setActive(url()->current())
    ;
    return $menu;
}
