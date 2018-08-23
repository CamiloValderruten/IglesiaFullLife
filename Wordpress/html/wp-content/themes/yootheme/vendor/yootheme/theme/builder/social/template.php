<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];

// Grid
$attrs_grid['class'][] = 'uk-child-width-auto uk-flex-inline';
$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';
$attrs_grid['uk-grid'] = true;

// Links
$links = array_filter($element['links'] ?: []);

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <div<?= $this->attrs($attrs_grid) ?>>

    <?php foreach ($links as $link) :

        // Icon
        $options = ["icon: {$this->e($link, 'social')}"];
        $options[] = ($element['icon_ratio'] && $element['link_style'] != 'button') ? "ratio: {$element['icon_ratio']}" : '';
        $attrs_icon = ['uk-icon' => implode(';', array_filter($options))];

        // Link
        $attrs_icon['href'] = $link;
        $attrs_icon['target'] = $element['link_target'] ? '_blank' : '';

        switch ($element['link_style']) {
            case '':
                $attrs_icon['class'][] = "uk-icon-link";
                break;
            case 'button':
                $attrs_icon['class'][] = 'uk-icon-button';
                break;
            case 'link':
                $attrs_icon['class'][] = "";
                break;
            case 'muted':
                $attrs_icon['class'][] = "uk-link-muted";
                break;
            case 'reset':
                $attrs_icon['class'][] = "uk-link-reset";
                break;
        }

        ?>
        <div>
            <a<?= $this->attrs($attrs_icon) ?>></a>
        </div>
    <?php endforeach ?>

    </div>
</div>
