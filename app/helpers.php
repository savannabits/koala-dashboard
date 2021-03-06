<?php
function makeMenu() {
    $menu = \Spatie\Menu\Menu::new()
        ->setAttribute('class','list-none')
        ->setAttribute('x-cloak')
        ->setAttribute("role","navigation")
        ->add(\Spatie\Menu\Link::to(route('home'),\Spatie\Menu\Html::raw('<i class="fas fa-home"></i> HOME')->render()))
        ->add(\Spatie\Menu\Link::to(route('alerts'),"Alerts"))
        ->add(\Spatie\Menu\Link::to(route('admin.dashboard'),"Admin Dashboard"))
        ->each(function ($item) {
            $item->setParentAttribute('class','p-2 py-4 border-b font-semibold hover:bg-secondary-lighter')
            ;
        })
        ->setActiveClass('bg-blue-100 border-l-4 border-primary')
        ->setActive(url()->current())
    ;
    return $menu;
}
function adminSidebarMenu() {
    $menu = \Spatie\Menu\Menu::new()
        ->setAttribute('class','')
        ->setAttribute('x-cloak')
        ->setAttribute("role","navigation")
        ->add(\Spatie\Menu\Link::to(route('home'),\Spatie\Menu\Html::raw('Front Home <i class="fas fa-home ml-auto"></i>')->render()))
        ->add(\Spatie\Menu\Link::to(route('alerts'),\Spatie\Menu\Html::raw('Alerts <i class="fa fa-warning ml-auto"></i>')->render()))
        ->add(\Spatie\Menu\Link::to(route('admin.dashboard'),\Spatie\Menu\Html::raw('Dashboard <i class="fas fa-chart-area ml-auto"></i>')->render()))
        ->each(function ($item) {
            $item->setParentAttribute('class','relative p-0')
                ->setAttribute('class','inline-flex items-center w-full text-sm p-4 my-0 font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200')
            ;
        })
        ->setActiveClassOnParent()
        ->setActiveClass('bg-primary-lighter dark:bg-primary text-gray-600 dark:text-gray-200 border-l-4 border-primary dark:border-primary-darker')
        ->setActive(url()->current())
    ;
    return $menu;
}

