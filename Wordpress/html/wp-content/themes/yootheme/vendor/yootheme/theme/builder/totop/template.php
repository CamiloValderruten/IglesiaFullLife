<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Link Title
$attrs['title'] = $element['link_title'];

?>

<div<?= $this->attrs(compact('id', 'class')) ?>>
    <a href="#" uk-totop uk-scroll<?= $this->attrs($attrs) ?>></a>
</div>
