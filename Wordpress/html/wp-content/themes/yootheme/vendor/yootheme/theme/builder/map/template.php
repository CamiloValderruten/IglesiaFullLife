<?php

$id = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Position context
$class[] = 'uk-position-relative uk-position-z-index';

// Titles
if ($element['show_title']) {

    foreach ($element['markers'] as $marker) {

        if (!trim($marker['title'])) {
            continue;
        }

        $marker->set('content', '<strong class="uk-display-block uk-margin">'.$marker['title'].'</strong>'.$marker['content']);
    }
}

// Height
$element['height'] = $element['height'] ?: '300px';
$attrs['style'] = 'height:'.(is_numeric($element['height']) ? "{$element['height']}px" : $element['height']);

$attrs['data-map'] = json_encode($element->all());

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>></div>
