<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];
$attrs_cell_nav = [];
$connect_id = substr(uniqid(), -3);

// Nav Alignment
$attrs_grid['class'][] = 'uk-child-width-expand';
$attrs_grid['class'][] = $element['switcher_gutter'] ? "uk-grid-{$element['switcher_gutter']}" : '';
$attrs_grid['class'][] = $element['switcher_vertical_align'] ? 'uk-flex-middle' : '';
$attrs_grid['uk-grid'] = true;

$attrs_cell_nav['class'][] = "uk-width-{$element['switcher_grid_width']}@{$element['switcher_breakpoint']}";
$attrs_cell_nav['class'][] = $element['switcher_position'] == 'right' ? "uk-flex-last@{$element['switcher_breakpoint']}" : '';

// Content
$attrs_content['id'][] = $connect_id;
$attrs_content['class'][] = 'uk-switcher';
$attrs_content['uk-height-match'][] = $element['switcher_height'] ? 'row: false' : false;

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if (in_array($element['switcher_position'], ['left', 'right'])) : ?>

        <div<?= $this->attrs($attrs_grid) ?>>
            <div<?= $this->attrs($attrs_cell_nav) ?>>
                <?= $this->render('@builder/switcher/template-nav', compact('item', 'connect_id')) ?>
            </div>
            <div>

                <ul<?= $this->attrs($attrs_content) ?>>
                    <?php foreach ($element as $item) : ?>
                    <li><?= $this->render('@builder/switcher/template-item', compact('item')) ?></li>
                    <?php endforeach ?>
                </ul>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['switcher_position'] == 'top') : ?>
        <?= $this->render('@builder/switcher/template-nav', compact('item', 'connect_id')) ?>
        <?php endif ?>

        <ul<?= $this->attrs($attrs_content) ?>>
            <?php foreach ($element as $item) : ?>
            <li><?= $this->render('@builder/switcher/template-item', compact('item')) ?></li>
            <?php endforeach ?>
        </ul>

        <?php if ($element['switcher_position'] == 'bottom') : ?>
        <?= $this->render('@builder/switcher/template-nav', compact('item', 'connect_id')) ?>
        <?php endif ?>

    <?php endif ?>

</div>
