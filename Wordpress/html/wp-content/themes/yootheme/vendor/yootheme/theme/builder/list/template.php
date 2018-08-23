<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Style
$class[] = $element['list_style'] ? "uk-list uk-list-{$element['list_style']}" : 'uk-list';

// Size
$class[] = $element['list_size'] ? 'uk-list-large' : '';

?>

<ul<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php foreach ($element as $item) : ?>
    <li><?= $this->render('@builder/list/template-item', compact('item')) ?></li>
    <?php endforeach ?>

</ul>
