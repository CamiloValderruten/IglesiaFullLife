<?php

// Menu ID
if ($id = $params->get('tag_id')) {
    $attrs['id'] = $id;
}

// determine layout
if (strpos($position, 'navbar') === 0) {

    $layout = $theme->get('header.layout');

    if (in_array($layout, ['toggle-offcanvas', 'toggle-modal'])) {

        $type = 'nav';
        $attrs['class'][] = 'uk-nav';

        if ($layout == 'toggle-offcanvas') {
            $attrs['class'][] = 'uk-nav-default';
        } else {
            $attrs['class'][] = 'uk-nav-primary uk-nav-center';
        }

    } else {

        $type = 'navbar';
        $attrs['class'][] = 'uk-navbar-nav';

    }

    if ($layout == 'stacked-center-split' && $params->get('split')) {

        $length = ceil(count($items) / 2);

        if ($position == 'navbar-split') {
            $items = array_slice($items, 0, $length);
        } else {
            $items = array_slice($items, $length);
        }
    }

} else if ($params->get('menu_style') == 'subnav' || in_array($position, ['toolbar-left', 'toolbar-right'])) {

    $type = 'subnav';
    $attrs['class'][] = 'uk-subnav uk-subnav-line';

} else {

    $type = 'nav';
    $attrs['class'][] = 'uk-nav';

    if ($position == 'mobile' && $theme->get('mobile.animation') == 'modal') {

        $attrs['class'][] = 'uk-nav-primary uk-nav-center';

    } else if ($position != 'mobile') {

        $params->set('accordion', true);
        $attrs['class'][] = 'uk-nav-default uk-nav-parent-icon uk-nav-side uk-nav-accordion';
        $attrs['uk-nav'] = true;

    } else {

        $attrs['class'][] = 'uk-nav-default';

    }

}

?>

<ul<?= $this->attrs($attrs) ?>>
<?= $this->render("menu/{$type}", ['items' => $items]) ?>
</ul>
