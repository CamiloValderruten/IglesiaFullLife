<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Theme;
use YOOtheme\Util\Collection;

class MenuWalker extends \Walker_Nav_Menu
{
    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var Current item
     */
    protected $current;

    /**
     * @var Parents
     */
    protected $parents = [];

    /**
     * @var Items
     */
    protected $items = [];

    /**
     * @var Params
     */
    protected $params = [];

    /**
     * @var Menu position
     */
    protected $position;

    /**
     * Constructor.
     */
    public function __construct($theme, $position, $params = [])
    {
        $this->theme = $theme;
        $this->position = $position;
        $this->params = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        $this->item->children = [];
        $this->parents[] = $this->item;
    }

    /**
     * {@inheritdoc}
     */
    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        array_splice($this->parents, -1);
    }

    /**
     * {@inheritdoc}
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;

        // standardize values
        $item->level = $depth + 1;
        $item->class = implode(" ", $classes);

        // set parent
        if (count($this->parents)) {
            $this->parents[count($this->parents) - 1]->children[] = $item;
        } else {
            $this->items[] = $item;
        }

        // set current
        $item->active = isset($item->active) && $item->active
            || in_array('current-menu-item', $classes)
            || in_array('current_page_item', $classes)
            || $item->url == 'index.php' && (is_home() || is_front_page())
            || is_page() && in_array($item->object_id, get_post_ancestors(get_the_ID()));

        // set menu config
        $item->config = $this->theme->get("menu.items.{$item->ID}", []);

        $this->item = $item;
    }

    public function end_el(&$output, $object, $depth = 0, $args = [])
    {
        if (!isset($object->children)) {
            return;
        }

        foreach ($object->children as $child) {
            if ($child->active) {
                $object->active = true;
                break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function walk($elements, $max_depth)
    {
        parent::walk($elements, $max_depth);
        echo $this->theme->render('menu/menu', ['items' => $this->items, 'params' => new Collection($this->params), 'position' => $this->position]);
    }
}
