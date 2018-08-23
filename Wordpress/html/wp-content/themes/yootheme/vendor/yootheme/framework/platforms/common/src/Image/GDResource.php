<?php

namespace YOOtheme\Image;

class GDResource extends Resource
{
    /**
     * @var resource
     */
    protected $image;

    /**
     * {@inheritdoc}
     */
    public function save($file, $type = null)
    {
        switch (strtolower($type ?: $this->type)) {

            case 'gif':
                imagegif($this->image, $file);
                break;

            case 'png':
                imagealphablending($this->image, false);
                imagesavealpha($this->image, true);
                imagepng($this->image, $file, round($this->quality * 0.09));
                break;

            case 'jpeg':
                imagejpeg($this->image, $file, round($this->quality));
                break;

            default:
                throw new \RuntimeException('Image type is not supported');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function doCrop($width, $height, $x, $y)
    {
        $image = $this->createImage($width, $height);

        imagecopy($image, $this->image, 0, 0, intval($x), intval($y), imagesx($this->image), imagesy($this->image));
        imagedestroy($this->image);

        $this->image = $image;
    }

    /**
     * {@inheritdoc}
     */
    public function doResize($width, $height, $dstWidth, $dstHeight, $background = 'transparent')
    {
        $image = $this->createImage($width, $height, $background);

        imagecopyresampled($image, $this->image, ($width - $dstWidth) / 2, ($height - $dstHeight) / 2, 0, 0, $dstWidth, $dstHeight, imagesx($this->image), imagesy($this->image));
        imagedestroy($this->image);

        $this->image = $image;
    }

    /**
     * Creates an image resource.
     *
     * @param  int   $width
     * @param  int   $height
     * @param  mixed $color
     * @return resource
     */
    protected function createImage($width, $height, $color = 'transparent')
    {
        if (!$this->image) {

            switch ($this->type) {

                case 'gif':
                    $this->image = imagecreatefromgif($this->file);
                    break;

                case 'png':
                    $this->image = imagecreatefrompng($this->file);
                    break;

                case 'jpeg':
                    $this->image = imagecreatefromjpeg($this->file);
                    break;

                default:
                    throw new \RuntimeException('Image type is not supported');
            }
        }

        $rgba = $this->parseColor($color);
        $image = imagecreatetruecolor($width, $height);

        imagefill($image, 0, 0, $rgba);

        if ($color == 'transparent') {
            imagecolortransparent($image, $rgba);
        }

        return $image;
    }
}
