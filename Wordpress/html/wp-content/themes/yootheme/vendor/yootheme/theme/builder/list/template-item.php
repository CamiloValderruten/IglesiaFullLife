<?php

$attrs_grid = [];
$attrs_cell = [];
$attrs_content = [];
$attrs_link = [];

// Display
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Image Align
$attrs_grid['class'][] = 'uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle';
$attrs_grid['uk-grid'] = true;
$attrs_cell['class'][] = 'uk-width-auto';
$attrs_cell['class'][] = $element['image_align'] == 'right' ? 'uk-flex-last' : '';

// Image
if ($item['image']) {

    $attrs_image = [];

    $attrs_image['class'][] = $element['image_border'] ? "uk-border-{$element['image_border']}" : '';
    $attrs_image['alt'] = $item['image_alt'];

    if (pathinfo($item['image'], PATHINFO_EXTENSION) == 'svg') {
        $item['image'] = $this->image($item['image'], array_merge($attrs_image, ['width' => $element['image_width'], 'height' => $element['image_height']]));
    } elseif ($element['image_width'] || $element['image_height']) {
        $item['image'] = $this->image([$item['image'], 'thumbnail' => [$element['image_width'], $element['image_height']], 'sizes' => '80%,200%'], $attrs_image);
    } else {
        $item['image'] = $this->image($item['image'], $attrs_image);
    }

} elseif ($item['icon']) {

    $attrs_icon = [];

    $options = ["icon: {$item['icon']}"];
    $options[] = ($element['icon_ratio']) ? "ratio: {$element['icon_ratio']}" : '';
    $attrs_icon['uk-icon'] = implode(';', array_filter($options));

    $attrs_icon['class'][] = $item['icon_color'] ? "uk-text-{$item['icon_color']}" : '';

    $item['image'] = "<span {$this->attrs($attrs_icon)}></span>";
}

// Deprecated
if ($element['text_style'] && $element['content_style'] === null) {
    $element['content_style'] = $element['text_style'];
}

switch ($element['content_style']) {
    case '':
        break;
    case 'bold':
    case 'muted':
        $attrs_content['class'][] = "uk-text-{$element['content_style']}";
        break;
    default:
        $attrs_content['class'][] = "uk-{$element['content_style']}";
}

// Link
if ($item['link']) {

    $attrs_link['target'] = $item['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;
    $attrs_link['class'][] = $element['link_style'] ? "uk-link-{$element['link_style']}" : '';

    $item->content = $this->link($item, $item['link'], $attrs_link);

    if ($item['image']) {
        $item['image'] = $this->link($item['image'], $item['link'], ['class' => 'uk-link-reset']);
    }
}

?>

<?php if ($item['image']) : ?>
    <div<?= $this->attrs($attrs_grid) ?>>
        <div<?= $this->attrs($attrs_cell) ?>>
            <?= $item['image'] ?>
        </div>
        <div>
            <div<?= $this->attrs($attrs_content) ?>>
                <?= $item ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div<?= $this->attrs($attrs_content) ?>>
        <?= $item ?>
    </div>
<?php endif ?>