<?php

// Options
$class = array_merge(['uk-logo'], isset($class) ? (array) $class : []);
$img = isset($img) ? $img : [];

// Logo
$config = $theme->get('logo', []);
$logo = $config['text'];

if ($config['image']) {
    $logo = $this->image($config['image'], ['alt' => $config['text'], 'class' => $img]);

    if ($config['image_inverse']) {
        $logo .= $this->image($config['image_inverse'], ['alt' => $config['text'], 'class' => array_merge((array) $img, ['uk-logo-inverse'])]);
    }
}
?>

<a href="<?= $theme->get('site_url') ?>"<?= $this->attrs(['class' => $class]) ?>>
    <?= $logo ?>
</a>
