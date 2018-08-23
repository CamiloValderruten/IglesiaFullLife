<?php

$id = $element['id'];
$class = $element['class'];
$style = [];
$attrs = [
    'uk-scrollspy' => $element['animation'] ? json_encode([
        'target' => '[uk-scrollspy-class]',
        'cls' => "uk-animation-{$element['animation']}",
        'delay' => $element['animation_delay'] ? 300 : false,
    ]) : false,
    'tm-header-transparent' => $element['header_transparent'] ? $element['header_transparent'] : false,
];
$attrs_overlay = [];
$attrs_container = [];
$attrs_viewport_height = [];
$attrs_image = [];
$attrs_video = [];
$attrs_section = [];

// Section
$class[] = "uk-section-{$element['style']}";
$class[] = $element['overlap'] ? 'uk-section-overlap' : '';
$attrs_section['class'][] = 'uk-section';

// Image
if ($element['image'] && $element['style'] != 'video') {

    if ($element['image_width'] || $element['image_height']) {
        $element['image'] = "{$element['image']}?thumbnail={$element['image_width']},{$element['image_height']}";
    }

    $attrs_image['style'][] = "background-image: url('{$app['image']->getUrl($element['image'])}');";

    // Settings
    $attrs_image['class'][] = 'uk-background-norepeat';
    $attrs_image['class'][] = $element['image_size'] ? "uk-background-{$element['image_size']}" : '';
    $attrs_image['class'][] = $element['image_position'] ? "uk-background-{$element['image_position']}" : '';
    $attrs_image['class'][] = $element['image_fixed'] ? "uk-background-fixed" : '';
    $attrs_image['class'][] = $element['image_visibility'] ? "uk-background-image@{$element['image_visibility']}" : '';
    $attrs_image['class'][] = $element['media_blend_mode'] ? "uk-background-blend-{$element['media_blend_mode']}" : '';
    $attrs_image['style'][] = $element['media_background'] ? "background-color: {$element['media_background']};" : '';

    // Overlay
    if ($element['media_overlay']) {
        $class[] = 'uk-position-relative';
        $attrs_overlay['style'] = "background-color: {$element['media_overlay']};";
    }

} else {
    $element['image'] = '';
}

// Video
if ($element['video'] && $element['style'] == 'video') {

    // Settings
    $style[] = $element['media_background'] ? "background-color: {$element['media_background']};" : '';
    $attrs_video['class'][] = $element['media_blend_mode'] ? "uk-blend-{$element['media_blend_mode']}" : '';

    // Cover
    $class[] = 'uk-cover-container';

    // Overlay
    $attrs_overlay['style'] = $element['media_overlay'] ? "background-color: {$element['media_overlay']};" : '';

    // Video
    $attrs_video['width'] = $element['video_width'];
    $attrs_video['height'] = $element['video_height'];

    if ($iframe = $this->iframeVideo($element['video'])) {

        $attrs_video['src'] = $iframe;
        $attrs_video['frameborder'] = '0';
        $attrs_video['allowfullscreen'] = true;
        $attrs_video['uk-cover'] = true;

        $element['video'] = "<iframe{$this->attrs($attrs_video)}></iframe>";

    } else if ($element['video']) {

        $attrs_video['src'] = $element['video'];
        $attrs_video['controls'] = false;
        $attrs_video['loop'] = true;
        $attrs_video['autoplay'] = true;
        $attrs_video['uk-cover'] = true;

        $element['video'] = "<video{$this->attrs($attrs_video)}></video>";
    }

} else {
    $element['video'] = '';
}

// Text color
if ($element['style'] == 'primary' || $element['style'] == 'secondary') {
    $class[] = $element['preserve_color'] ? 'uk-preserve-color' : '';
} elseif ($element['image'] || $element['video']) {
    $class[] = $element['text_color'] ? "uk-{$element['text_color']}" : '';
}

// Padding
switch ($element['padding']) {
    case '':
        break;
    case 'none':
        $attrs_section['class'][] = 'uk-padding-remove-vertical';
        break;
    default:
        $attrs_section['class'][] = "uk-section-{$element['padding']}";
}

if ($element['padding'] != 'none') {
    if ($element['padding_remove_top']) {
        $attrs_section['class'][] = 'uk-padding-remove-top';
    }
    if ($element['padding_remove_bottom']) {
        $attrs_section['class'][] = 'uk-padding-remove-bottom';
    }
}

// Height Viewport
if ($element['height']) {

    if ($element['height'] == 'expand') {
        $attrs_section['uk-height-viewport'] = 'expand: true';
    } else {

        // Needed if vertically centered
        $attrs_section['class'][] = 'uk-flex uk-flex-middle';
        $attrs_viewport_height['class'][] = 'uk-width-1-1';

        $options = ['offset-top: true'];
        switch ($element['height']) {
            case 'percent':
                $options[] = 'offset-bottom: 20';
                break;
            case 'section':
                $options[] = $element['image'] ? 'offset-bottom: ! +' : 'offset-bottom: true';
                break;
        }

        $attrs_section['uk-height-viewport'] = implode(';', array_filter($options));

    }

}

// Container and width
switch ($element['width']) {
    case 'default':
        $attrs_container['class'][] = 'uk-container';
        break;
    case 'small':
    case 'large':
    case 'expand':
        $attrs_container['class'][] = "uk-container uk-container-{$element['width']}";
        break;
    // Deprecated
    case 1:
        $attrs_container['class'][] = 'uk-container';
        break;
    case 2:
        $attrs_container['class'][] = 'uk-container uk-container-small';
        break;
    case 3:
        $attrs_container['class'][] = 'uk-container uk-container-expand';
}

// Make sure overlay and video is always below content
if ($attrs_overlay || $element['video']) {
    $attrs_container['class'][] = 'uk-position-relative';
}

// Visibility
$visible = 4;
$visibilities = ['xs', 's', 'm', 'l', 'xl'];

foreach ($element as $el) {
    $visible = min(array_search($el['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $class[] = "uk-visible@{$visibilities[$visible]}";
}

?>

<div<?= $this->attrs(compact('id', 'class', 'style'), $attrs, !$attrs_image ? $attrs_section : []) ?>>

    <?php if ($attrs_image) : ?>
    <div<?= $this->attrs($attrs_image, $attrs_section) ?>>
    <?php endif ?>

        <?= $element['video'] ?>

        <?php if ($attrs_overlay) : ?>
        <div class="uk-position-cover"<?= $this->attrs($attrs_overlay) ?>></div>
        <?php endif ?>

        <?php if ($attrs_viewport_height) : ?>
        <div<?= $this->attrs($attrs_viewport_height) ?>>
        <?php endif ?>

            <?php if ($attrs_container) : ?>
            <div<?= $this->attrs($attrs_container) ?>>
            <?php endif ?>

                <?= $element ?>

            <?php if ($attrs_container) : ?>
            </div>
            <?php endif ?>

        <?php if ($attrs_viewport_height) : ?>
        </div>
        <?php endif ?>

    <?php if ($attrs_image) : ?>
    </div>
    <?php endif ?>

</div>
