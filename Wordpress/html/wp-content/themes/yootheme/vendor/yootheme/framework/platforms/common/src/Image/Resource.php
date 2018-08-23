<?php

namespace YOOtheme\Image;

abstract class Resource
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $quality = 90;

    /**
     * @var array
     */
    protected static $colors = [
        'aqua' => 0x00ffff,
        'black' => 0x000000,
        'blue' => 0x0000ff,
        'fuchsia'=> 0xff00ff,
        'gray' => 0x808080,
        'green' => 0x008000,
        'lime' => 0x00ff00,
        'maroon' => 0x800000,
        'navy' => 0x000080,
        'olive' => 0x808000,
        'orange' => 0xffA500,
        'purple' => 0x800080,
        'red' => 0xff0000,
        'silver' => 0xc0c0c0,
        'teal' => 0x008080,
        'transparent' => 0x7fffffff,
        'white' => 0xffffff,
        'yellow' => 0xffff00,
    ];

    /**
     * Constructor.
     *
     * @param string $file
     * @param string $type
     */
    public function __construct($file, $type)
    {
        $this->file = $file;
        $this->type = $type;
    }

    /**
     * Set image quality.
     *
     * @param int $quality
     */
    public function quality($quality)
    {
        $this->quality = $quality;
    }

    /**
     * Save image to file.
     *
     * @param string $file
     * @param string $type
     */
    abstract public function save($file, $type = null);

    /**
     * Do the image crop.
     *
     * @param  int $width
     * @param  int $height
     * @param  int $x
     * @param  int $y
     * @return self
     */
    abstract public function doCrop($width, $height, $x, $y);

    /**
     * Do the image resize.
     *
     * @param  int    $width
     * @param  int    $height
     * @param  int    $dstWidth
     * @param  int    $dstHeight
     * @param  string $background
     * @return self
     */
    abstract public function doResize($width, $height, $dstWidth, $dstHeight, $background = 'transparent');

    /**
     * Parses a color to decimal value.
     *
     * @param  mixed $color
     * @return int
     */
    protected function parseColor($color)
    {
        if (!is_string($color) && is_numeric($color)) {
            return $color;
        }

        $color = strtolower(trim($color));

        if (isset(static::$colors[$color])) {
            return static::$colors[$color];
        }

        if (is_string($color) && preg_match('/^(#|0x|)([0-9a-f]{3,6})/i', $color, $matches)) {

            $col = $matches[2];

            if (strlen($col) == 6) {
                return hexdec($col);
            }

            if (strlen($col) == 3) {

                $r = '';

                for ($i = 0; $i < 3; ++$i) {
                    $r .= $col[$i].$col[$i];
                }

                return hexdec($r);
            }
        }

        if (is_string($color) && preg_match('/^rgb\(([0-9]+),([0-9]+),([0-9]+)\)/i', $color, $matches)) {

            list(, $r, $g, $b) = $matches;

            if ($r >= 0 && $r <= 0xff && $g >= 0 && $g <= 0xff && $b >= 0 && $b <= 0xff) {
                return ($r << 16) | ($g << 8) | ($b);
            }
        }

        throw new \InvalidArgumentException("Invalid color: {$color}");
    }
}
