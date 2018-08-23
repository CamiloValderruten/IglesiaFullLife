<?php

$links = $theme->get('social_links', [])->splice(0, 5)->filter();

$attrs['class'] = $theme->get('header.social_style') ? 'uk-icon-button' : 'uk-icon-link';
$attrs['target'] = $theme->get('header.social_target') ? '_blank' : '';

// Grid
$attrs_grid = [];
$attrs_grid['class'][] = 'uk-grid-small uk-flex-middle uk-flex-nowrap';
$attrs_grid['uk-grid'] = true;

 if (in_array($theme->get('header.social'), ['navbar', 'header'])) {
     $attrs_grid['class'][] = $theme->get('header.layout') == 'toggle-modal' ? 'uk-flex-center' : '';
 }

?>

<?php if (count($links)) : ?>
<ul<?= $this->attrs($attrs_grid) ?>>
    <?php foreach ($links as $link) : ?>
    <li>
        <a<?= $this->attrs(['href' => $link], $attrs) ?> uk-icon="icon: <?= $this->e($link, 'social') ?>"></a>
    </li>
    <?php endforeach ?>
</ul>
<?php endif ?>
