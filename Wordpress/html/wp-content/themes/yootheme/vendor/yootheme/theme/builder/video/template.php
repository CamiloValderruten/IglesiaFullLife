<?php

$id    = $element['id'];
$class = $element['class'];
$attrs = $element['attrs'];

// Video
$attrs_video['width'] = $element['video_width'];
$attrs_video['height'] = $element['video_height'];

if ($iframe = $this->iframeVideo($element['video'], $element['video_params'])) {

    $attrs_video['src'] = $iframe;
    $attrs_video['frameborder'] = 0;
    $attrs_video['allowfullscreen'] = true;
    $attrs_video['uk-responsive'] = true;

} else {

    $attrs_video['src'] = $element['video'];
    $attrs_video['controls'] = true;
    $attrs_video['poster'] = $element['video_poster'];
    $attrs_video['loop'] = $element['video_loop'];
    $attrs_video['autoplay'] = $element['video_autoplay'];
}

?>

<div<?= $this->attrs(compact('id', 'class'), $attrs) ?>>

    <?php if ($iframe) : ?>
        <iframe<?= $this->attrs($attrs_video) ?>></iframe>
    <?php else : ?>
        <video<?= $this->attrs($attrs_video) ?>></video>
    <?php endif ?>

</div>
