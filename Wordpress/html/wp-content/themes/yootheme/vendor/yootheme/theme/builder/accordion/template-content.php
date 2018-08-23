<?php

$attrs_content = [];
$attrs_link = [];

// Content
$attrs_content['class'][] = 'uk-margin';
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';

// Link
if ($item['link']) {

    $attrs_link['href'] = $item['link'];
    $attrs_link['target'] = $element['link_target'] ? '_blank' : '';
    $attrs_link['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;

    switch ($element['link_style']) {
        case '':
            break;
        case 'link-muted':
            $attrs_link['class'][] = "uk-{$element['link_style']}";
            break;
        default:
            $attrs_link['class'][] = "uk-button uk-button-{$element['link_style']}";
            $attrs_link['class'][] = $element['link_size'] ? "uk-button-{$element['link_size']}" : '';
    }

}

?>

<?php if ($item['content']) : ?>
<div<?= $this->attrs($attrs_content) ?>><?= $item['content'] ?></div>
<?php endif ?>

<?php if ($item['link'] && $element['link_text']) : ?>
<p><a<?= $this->attrs($attrs_link) ?>><?= $element['link_text'] ?></a></p>
<?php endif ?>