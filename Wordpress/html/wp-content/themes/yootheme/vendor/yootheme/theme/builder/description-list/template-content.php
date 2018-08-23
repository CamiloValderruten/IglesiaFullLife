<?php

// Link
$attrs['class'][] = $element['link_style'] ? "uk-link-{$element['link_style']}" : '';
$attrs['target'] = $item['link_target'] ? '_blank' : '';
$attrs['uk-scroll'] = (strpos($item['link'], '#') === 0) ? true : false;

?>

<?php if ($item['link']) : ?>
    <?= $this->link($item, $item['link'], $attrs) ?>
<?php else : ?>
    <?= $item ?>
<?php endif ?>