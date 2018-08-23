<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_container = [];

$attrs['uk-grid'] = true;

$class[] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';
$class[] = $element['divider'] && $element['gutter'] != 'collapse' ? 'uk-grid-divider' : '';
$class[] = $element['vertical_align'] ? 'uk-flex-middle' : '';

// Visibility
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = 4;

foreach ($element as $el) {
    $visible = min(array_search($el['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $class[] = "uk-visible@{$visibilities[$visible]}";
}

// Margin
$margin = '';
switch ($element['margin']) {
    case '':

        switch ($element['gutter']) {
            case '':
                $margin = 'uk-grid-margin';
                break;
            case 'small':
            case 'medium':
            case 'large':
                $margin = "uk-grid-margin-{$element['gutter']}";
        }

        break;
    case 'default':
        $margin = 'uk-margin';
        break;
    default:
        $margin = "uk-margin-{$element['margin']}";
}

// Container and width
if ($element['width']) {

    switch ($element['width']) {
        case 'default':
            $attrs_container['class'][] = 'uk-container';
            break;
        case 'small':
        case 'large':
        case 'expand':
            $attrs_container['class'][] = "uk-container uk-container-{$element['width']}";
    }

    // Margin
    $attrs_container['class'][] = $margin;

} else {

    // Margin
    $class[] = $margin;

}

?>

<?php if ($attrs_container) : ?>
<div<?= $this->attrs($attrs_container) ?>>
<?php endif ?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <?= $element ?>
</div>

<?php if ($attrs_container) : ?>
</div>
<?php endif ?>