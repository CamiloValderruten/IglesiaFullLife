<?php

foreach ($items as $item) {

    if ($item->type == 'header') {
        continue;
    }

    $attrs = ['class' => []];
    $title = $item->title;

    // Parent?
    if (isset($item->children)) {
        $attrs['class'][] = 'uk-parent';
    }

    // Active?
    if ($item->active) {
        $attrs['class'][] = 'uk-active';
    }

    // Icon
    $icon = $item->config->get('icon', '');
    if (preg_match('/\.(gif|png|jpg|svg)$/i', $icon)) {
        $icon = "<img class=\"uk-responsive-height\" src=\"{$icon}\" alt=\"{$item->title}\">";
    } elseif ($icon) {
        $icon = "<span class=\"uk-margin-small-right\" uk-icon=\"icon: {$icon}\"></span>";
    }

    // Show Icon only
    if ($icon && $item->config->get('icon-only')) {
        $title = '';
    }

    // Additional Class
    if ($item->class) {
        $attrs['class'][] = $item->class;
    }

    $link = [];

    if (isset($item->url)) {
        $link['href'] = $item->url;
    }

    if (isset($item->target)) {
        $link['target'] = $item->target;
    }

    if ($subtitle = $item->config->get('subtitle')) {
        $subtitle = "<div>{$subtitle}</div>";
    }

    echo "<li{$this->attrs($attrs)}><a{$this->attrs($link)}>{$icon}{$title}{$subtitle}</a></li>";
}
