<?php

$class = [];
$badge = [];
$title = [];

// determine special positions
if ($position == 'debug' || $position == 'navbar' && $module->type == 'menu') {
    echo $module->content;
    return;
}

if ($position == 'navbar') {

    if (in_array($theme->get('header.layout'), ['toggle-offcanvas', 'toggle-modal'])) {
        $class[] = 'uk-margin';
    } else if ($theme->get('header.layout') == 'stacked-left-b' && $index == 1) {
        $class[] = 'uk-margin-auto-left uk-navbar-item';
    } else {
        $class[] = 'uk-navbar-item';
    }

} else if ($position == 'header' && in_array($theme->get('header.layout'), ['horizontal-left', 'horizontal-center', 'horizontal-right'])) {

    $class[] = 'uk-navbar-item';

} else if (in_array($position, ['header', 'mobile', 'toolbar-right', 'toolbar-left'])) {

    $class[] = 'uk-panel';

} else {

    $class[] = $module->config->get('style') ? "uk-card uk-card-body uk-{$module->config->get('style')}" : 'uk-panel';

}

// Class
if ($cls = (array) $module->config->get('class')) {
    $class = array_merge($class, $cls);
}

// Grid + sidebar positions
if (in_array($position, ['top', 'bottom', 'sidebar', 'mobile'])) {

    // Title?
    if ($module->config->get('showtitle')) {

        $title['class'] = [];

        $title_element = $module->config->get('title_tag', 'h3');

        // Style?
        $title['class'][] = $module->config->get('title_style') ? "uk-{$module->config->get('title_style')}" : '';
        $title['class'][] = $module->config->get('style') && !$module->config->get('title_style') ? "uk-card-title" : '';

        // Decoration?
        $title['class'][] = $module->config->get('title_decoration') ? "uk-heading-{$module->config->get('title_decoration')}" : '';

    }

    // Text alignment
    if ($module->config->get('text_align') && $module->config->get('text_align') != 'justify' && $module->config->get('text_align_breakpoint')) {
        $class[] = "uk-text-{$module->config->get('text_align')}@{$module->config->get('text_align_breakpoint')}";
        if ($module->config->get('text_align_fallback')) {
            $class[] = "uk-text-{$module->config->get('text_align_fallback')}";
        }
    } else if ($module->config->get('text_align')) {
        $class[] = "uk-text-{$module->config->get('text_align')}";
    }

    // List
    if ($module->config->get('is_list')) {
        $class[] = "tm-child-list";

        // List Style?
        if ($module->config->get('list_style')) {
            $class[] = "tm-child-list-{$module->config->get('list_style')}";
        }

        // Link Style?
        if ($module->config->get('link_style')) {
            $class[] = "uk-link-{$module->config->get('link_style')}";
        }
    }

}

// Grid positions
if (in_array($position, ['top', 'bottom'])) {

    // Max Width?
    if ($module->config->get('maxwidth')) {
        $class[] = "uk-width-{$module->config->get('maxwidth')}";

        // Center?
        if ($module->config->get('maxwidth_align')) {
            $class[] = 'uk-margin-auto';
        }

    }

}

?>

<div<?= $this->attrs(compact('class'), $module->attrs) ?>>

    <?php if ($title) : ?>
    <<?= $title_element ?><?= $this->attrs($title) ?>>
        <?php if ($module->config->get('title_decoration') == 'line') : ?>
            <span><?= $module->title ?></span>
        <?php else: ?>
            <?= $module->title ?>
        <?php endif ?>
    </<?= $title_element ?>>
    <?php endif ?>

    <?= $module->content ?>

</div>
