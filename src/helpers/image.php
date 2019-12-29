<?php

function image(int $image_id = null, string $size = 'thumbnail', bool $icon = false)
{
    if (!$image_id)
        $image_id = \get_post_thumbnail_id();

    $image = \wp_get_attachment_image_src($image_id, $size, $icon);

    if( ! $image )
        return $image;

    $obj = new stdClass();
    $obj->src = $image[0];
    $obj->width = $image[1];
    $obj->height = $image[2];
    return $obj;
}

function image_src(int $image_id = null, string $size = 'thumbnail', bool $icon = false)
{
    $image = \image($image_id, $size, $icon);
    return $image->src;
}

function image_html(int $image_id = null, string $size = 'thumbnail', bool $icon = false, $attr = '')
{
    if (!$image_id)
        $image_id = \get_post_thumbnail_id();

    echo \wp_get_attachment_image($image_id, $size, $icon, $attr);
}