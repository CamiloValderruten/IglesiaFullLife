<?php

// Blank
if (empty($style)) {

    foreach ($items as $index => $item) {
        echo $this->render('module', ['index' => $index, 'module' => $item, 'position' => $name]);
    }

    return;
}

// Cell
if ($style == 'cell') {

    foreach ($items as $index => $item) {
        echo '<div>'.$this->render('module', ['index' => $index, 'module' => $item, 'position' => $name]).'</div>';
    }

    return;
}

// Grid
$position = $theme->get($name, []);
$attrs = ['class' => [], 'uk-grid' => true];
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = 4;

if ($style == 'grid-stack') {
    $attrs['class'][] = 'uk-child-width-1-1';
} else {
    $attrs['class'][] = "uk-child-width-expand@{$position['breakpoint']}";
}

$attrs['class'][] = $position['grid_gutter'] ? "uk-grid-{$position['grid_gutter']}" : '';
$attrs['class'][] = $position['grid_divider'] ? 'uk-grid-divider' : '';
$attrs['class'][] = $position['match'] & !$position['vertical_align'] ? 'uk-grid-match' : '';
$attrs['class'][] = $position['vertical_align'] ? 'uk-flex-middle' : '';


// Widgets/Modules
foreach ($items as $index => $item) {

    $item->cell = [];

    if ($width = $item->config['width']) {
        $item->cell[] = "uk-width-{$width}@{$position['breakpoint']}";
    }

    if ($visibility = $item->config['visibility']) {
        $item->cell[] = "uk-visible@{$visibility}";
    }

    $visible = min(array_search($visibility, $visibilities), $visible);

    $item->content = $this->render('module', ['index' => $index, 'module' => $item, 'position' => $name]);
}

if ($visible) {
    $attrs['class'][] = "uk-visible@{$visibilities[$visible]}";
}

?>

<div<?= $this->attrs($attrs) ?>>
    <?php foreach ($items as $item) : ?>
        <div<?= $this->attrs(['class' => $item->cell]) ?>><?= $item->content ?></div>
    <?php endforeach ?>
</div>
