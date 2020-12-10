<?php


namespace Savannabits\Koaladmin\Helpers;


class MenuItem
{
    protected $name = null, $title = null,$link = null, $icon = null, $hasChildren = false, $children = [];
    public static function instance() {
        return new self();
    }

    /**
     * @param MenuItem[] $children
     * @return MenuItem
     */
    public function setChildren(array $children): MenuItem
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @param bool $hasChildren
     * @return MenuItem
     */
    public function setHasChildren(bool $hasChildren): MenuItem
    {
        $this->hasChildren = $hasChildren;
        return $this;
    }

    /**
     * @param string|null $icon
     * @return MenuItem
     */
    public function setIcon($icon): MenuItem
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @param null $link
     * @return MenuItem
     */
    public function setLink($link): MenuItem
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param null $name
     * @return MenuItem
     */
    public function setName($name): MenuItem
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param null $title
     * @return MenuItem
     */
    public function setTitle($title): MenuItem
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return  string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }
}
