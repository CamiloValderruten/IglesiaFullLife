<?php

foreach ($items as $item) {

    $attrs = ['class' => []];
    $children = isset($item->children);
    $indention = str_pad("\n", $item->level + 1, "\t");
    $title = $item->title;

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

    // Header
    if ($item->type == 'header') {

        $title = $icon.$title;

        // Divider
        if ($item->divider && !$children) {
            $title = '';
            $attrs['class'][] = 'uk-nav-divider';
        } elseif ($params->get('accordion') && $children) {
            $title = "<a href=\"#\">{$title}</a>";
        } else {
            $attrs['class'][] = 'uk-nav-header';
        }

    // Link
    } else {

        $link = [];

        if (isset($item->url)) {
            $link['href'] = $item->url;
        }

        if (isset($item->target)) {
            $link['target'] = $item->target;
        }

        $title = "<a{$this->attrs($link)}>{$icon}{$title}</a>";
    }

    // Children?
    if ($children) {

        $attrs['class'][] = 'uk-parent';

        $children = ['class' => []];

        if ($item->level == 1) {
            $children['class'][] = 'uk-nav-sub';
        }

        $children = "{$indention}<ul{$this->attrs($children)}>\n" . $this->self(['items' => $item->children]) . "</ul>";
    }

    echo "{$indention}<li{$this->attrs($attrs)}>{$title}{$children}</li>";
}
