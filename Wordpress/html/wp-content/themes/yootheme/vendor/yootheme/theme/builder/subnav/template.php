<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_subnav = [];
$attrs_link = [];

// Style
$attrs_subnav['class'][] = 'uk-subnav uk-flex-inline uk-margin-remove-bottom';
$attrs_subnav['class'][] = $element['subnav_style'] ? "uk-subnav-{$element['subnav_style']}" : '';

// Link
$attrs_link['class'][] = $element['link_style'] ? "uk-link-{$element['link_style']}" : '';

// Margin
$attrs_subnav['uk-margin'] = true;

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <ul<?= $this->attrs($attrs_subnav) ?>>
        <?php foreach ($element as $item) :

            $attrs_link['href'] = $item['link'];
            $attrs_link['target'] = $item['link_target'] ? '_blank' : '';
            $attrs_link['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;

            ?>
            <li>

                <?php if ($item['link']) : ?>
                    <a<?= $this->attrs($attrs_link) ?>><?= $item ?></a>
                <?php else : ?>
                    <a class="uk-disabled"><?= $item ?></a>
                <?php endif ?>

            </li>
        <?php endforeach ?>
    </ul>

</div>