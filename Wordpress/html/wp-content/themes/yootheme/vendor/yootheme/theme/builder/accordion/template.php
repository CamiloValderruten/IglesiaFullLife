<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Accordion
$attrs['uk-accordion'] = $element->pick(['multiple', 'collapsible'])->json();

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php foreach ($element as $item) : ?>
    <div>

        <<?= $element['title_element']?> class="uk-accordion-title">
            <?= $item['title'] ?>
        </<?= $element['title_element'] ?>>

        <div class="uk-accordion-content">
            <?= $this->render('@builder/accordion/template-item', compact('item')) ?>
        </div>

    </div>
    <?php endforeach ?>

</div>
