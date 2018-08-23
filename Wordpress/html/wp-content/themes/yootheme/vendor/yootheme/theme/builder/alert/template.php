<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Style
$class[] = $element['alert_style'] ? "uk-alert uk-alert-{$element['alert_style']}" : 'uk-alert';

// Size
$class[] = $element['alert_size'] ? "uk-padding" : '';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($element['title']) : ?>
    <h3><?= $element['title'] ?></h3>
    <?php endif ?>

    <div><?= $element ?></div>

</div>
