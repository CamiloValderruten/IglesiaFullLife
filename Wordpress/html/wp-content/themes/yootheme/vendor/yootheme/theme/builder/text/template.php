<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Column
if ($element['column'] && $element['column_breakpoint']) {

    $class[] = "uk-column-{$element['column']}@{$element['column_breakpoint']}";
    $breakpoints = [
        's'  => [''],
        'm'  => ['s',''],
        'l'  => ['m','s',''],
        'xl' => ['l','m','s','']
    ];
    $breakpoints = $breakpoints[$element['column_breakpoint']];

    list($base, $columns) = explode('-', $element['column']);

    foreach ($breakpoints as $breakpoint) {
        if ($columns < 2) {
            break;
        }
        $class[] = 'uk-column-1-'.(--$columns).($breakpoint ? '@'.$breakpoint:'');
    }

} else if ($element['column']) {
    $class[] = "uk-column-{$element['column']}";
}

$class[] = ($element['column'] && $element['column_divider']) ? 'uk-column-divider' : '';

// Drop Cap
$class[] = $element['dropcap'] ? 'uk-dropcap' : '';

// Style
$class[] = $element['text_style'] ? "uk-text-{$element['text_style']}" : '';

// Color
$class[] = !$element['text_style'] && $element['text_color'] ? "uk-text-{$element['text_color']}" : '';

// Size
$class[] = !$element['text_style'] && $element['text_size'] ? "uk-text-{$element['text_size']}" : '';

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <?= $element ?>
</div>
