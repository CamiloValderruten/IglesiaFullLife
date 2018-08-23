<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];
$attrs_grid = [];

// Grid
$attrs_grid['class'][] = 'uk-flex-middle';
$attrs_grid['class'][] = $element['fullwidth'] ? 'uk-child-width-1-1' : 'uk-child-width-auto uk-flex-inline';
$attrs_grid['class'][] = $element['gutter'] ? "uk-grid-{$element['gutter']}" : '';
$attrs_grid['uk-grid'] = true;

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if (count($element) > 1) : ?>
    <div<?= $this->attrs($attrs_grid) ?>>
    <?php endif ?>

    <?php foreach ($element as $item) :

        $attrs_button = [];

        // Fullwidth
        $attrs_button['class'][] = $element['fullwidth'] ? 'uk-width-1-1' : '';

        // Style
        switch ($item['button_style']) {
            case '':
                break;
            case 'muted':
                $attrs_button['class'][] = 'uk-link-muted';
                break;
            default:
                $attrs_button['class'][] = "uk-button uk-button-{$item['button_style']}";
        }

        // Size
        $attrs_button['class'][] = $element['button_size'] && !in_array($item['button_style'], ['text', 'link']) ? "uk-button-{$element['button_size']}" : '';

        // Link
        $attrs_button['href'] = $item['link'];
        $attrs_button['target'] = $item['link_target'] ? '_blank' : '';
        $attrs_button['title'] = $item['link_title'];
        $attrs_button['uk-scroll'] = strpos($item['link'], '#') === 0;

        ?>

        <?php if (count($element) > 1) : ?>
        <div>
        <?php endif ?>

            <a<?= $this->attrs($attrs_button) ?>>

                <?php if ($item['icon']) : ?>

                    <?php if ($item['icon_align'] == 'left') : ?>
                    <span uk-icon="icon: <?= $item['icon'] ?>"></span>
                    <?php endif ?>

                    <span class="uk-text-middle"><?= $item ?></span>

                    <?php if ($item['icon_align'] == 'right') : ?>
                    <span uk-icon="icon: <?= $item['icon'] ?>"></span>
                    <?php endif ?>

                <?php else : ?>
                <?= $item ?>
                <?php endif ?>

            </a>

        <?php if (count($element) > 1) : ?>
        </div>
        <?php endif ?>

    <?php endforeach ?>

    <?php if (count($element) > 1) : ?>
    </div>
    <?php endif ?>

</div>
