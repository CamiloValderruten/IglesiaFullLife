<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];
$attrs_cell = [];
$attrs_content = [];

// Style
$class[] = $element['list_style'] ? "uk-list uk-list-{$element['list_style']}" : 'uk-list';

// Size
$class[] = $element['list_size'] ? 'uk-list-large' : '';

// Deprecated
if ($element['gutter'] === null) {
    $element['gutter'] = 'small';
}

// Layout
$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';

$attrs_grid['uk-grid'] = true;

switch ($element['layout']) {
    case 'width-small':
    case 'width-medium':
        $attrs_cell['class'][] = 'uk-text-break';
        $attrs_grid['class'][] = $element['breakpoint'] ? "uk-child-width-expand@{$element['breakpoint']}" : 'uk-child-width-expand';
        $attrs_cell['class'][] = $element['breakpoint'] ? "uk-{$element['layout']}@{$element['breakpoint']}" : "uk-{$element['layout']}";
        break;
    case 'space-between':
        $attrs_grid['class'][] = "uk-flex-between";
        $attrs_grid['class'][] = $element['breakpoint'] ? "uk-child-width-auto@{$element['breakpoint']}" : 'uk-child-width-auto';
        break;
    case 'stacked':
        $attrs_cell['class'][] = "uk-width-1-1";
        break;
    default:
        $attrs_grid['class'][] = $element['breakpoint'] ? "uk-child-width-expand@{$element['breakpoint']}" : 'uk-child-width-expand';
        $attrs_cell['class'][] = $element['breakpoint'] ? "uk-width-auto@{$element['breakpoint']}" : 'uk-width-auto';
}

// Content
$attrs_content['class'][] = $element['content_style'] ? "uk-text-{$element['content_style']}" : '';

?>

<ul<?= $this->attrs(compact('id', 'class'), $attrs) ?>>
    <?php foreach ($element as $item) :

        // Display
        if (!$element['show_link']) { $item['link'] = ''; }

        // Title
        $item['title'] .= $item['title'] && $element['title_colon'] ? ':' : '';

        ?>
        <li>

            <?php if ($element['layout'] == 'stacked') : ?>

                <?= $this->render('@builder/description-list/template-title', compact('item')) ?>

                <div<?= $this->attrs($attrs_content) ?>>
                    <?= $this->render('@builder/description-list/template-content', compact('item')) ?>
                </div>

            <?php else : ?>

            <div<?= $this->attrs($attrs_grid) ?>>
                <div<?= $this->attrs($attrs_cell) ?>>
                    <?= $this->render('@builder/description-list/template-title', compact('item')) ?>
                </div>
                <div<?= $this->attrs($attrs_content) ?>>
                    <?= $this->render('@builder/description-list/template-content', compact('item')) ?>
                </div>
            </div>

            <?php endif ?>

        </li>
    <?php endforeach ?>
</ul>
