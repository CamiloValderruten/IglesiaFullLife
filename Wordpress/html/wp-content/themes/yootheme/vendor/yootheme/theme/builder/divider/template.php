<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Style
$class[] = $element['divider_style'] ? "uk-divider-{$element['divider_style']}" : '';
$class[] = !$element['divider_style'] && $element['divider_element'] == 'div' ? 'uk-hr' : '';

// Alignment
if ($element['divider_style'] == 'small') {
    if ($element['divider_align'] && $element['divider_align'] != 'justify' && $element['divider_align_breakpoint']) {
        $class[] = "uk-text-{$element['divider_align']}@{$element['divider_align_breakpoint']}";
        if ($element['divider_align_fallback']) {
            $class[] = "uk-text-{$element['divider_align_fallback']}";
        }
    } else if ($element['divider_align']) {
        $class[] = "uk-text-{$element['divider_align']}";
    }
}

?>

<?php if ($element['divider_style'] == 'div') : ?>
<div <?= $this->attrs(compact('id', 'class'), $attrs) ?>></div>
<?php else : ?>
<hr <?= $this->attrs(compact('id', 'class'), $attrs) ?>>
<?php endif ?>