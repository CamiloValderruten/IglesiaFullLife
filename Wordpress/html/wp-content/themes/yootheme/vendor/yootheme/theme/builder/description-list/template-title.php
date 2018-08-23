<?php if ($element['title_style'] == 'strong') : ?>
    <strong><?= $item['title'] ?></strong>
<?php elseif ($element['title_style'] == 'muted') : ?>
    <span class="uk-text-muted"><?= $item['title'] ?></span>
<?php elseif (in_array($element['title_style'], ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])) : ?>
    <h3 class="uk-<?= $element['title_style'] ?>"><?= $item['title'] ?></h3>
<?php else : ?>
    <?= $item['title'] ?>
<?php endif ?>
