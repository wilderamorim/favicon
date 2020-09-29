<?php


namespace ElePHPant\Favicon;


/**
 * Class Cropper
 *
 * Please report bugs on https://github.com/wilderamorim/favicon/issues
 *
 * @package ElePHPant\Favicon
 * @author Wilder Amorim <agencia@uebi.com.br>
 * @copyright Copyright (c) 2020, Uebi. All rights reserved
 * @license MIT License
 */
class Cropper extends Tags
{
    /** @var */
    protected $imageName;

    /** @var */
    protected $imageMime;

    /** @var string[] */
    private static $allowedExt = ['image/png', 'image/jpeg'];

    /** @var array */
    private $names = [];

    /**
     * @return string
     * @throws \Exception
     */
    public function create()
    {
        if (!file_exists($this->inputPath)) {
            return 'Image not found';
        }

        $this->imageMime = mime_content_type($this->inputPath);

        if (!in_array($this->imageMime, self::$allowedExt)) {
            return 'Not a valid JPG or PNG image';
        }

        if (!file_exists($this->outputPath) || !is_dir($this->outputPath)) {
            if (!mkdir($this->outputPath, 0755)) {
                throw new \Exception('Could not create cache folder');
            }
        }

        return $this->cropper();
    }

    /**
     * @return string
     */
    private function cropper(): string
    {
        $iteration = 0;

        foreach ($this->sizes as $size) {
            //width / height
            $resolutions = explode('x', $size);
            $width = $resolutions[0];
            $height = $resolutions[1];

            //name
            $this->imageName = "{$this->names()[$iteration++]}{$width}x{$height}";

            //create
            $thumb = imagecreatetruecolor($width, $height);
            $this->image($thumb, $width, $height);
        }

        return "{$this->outputPath}/{$this->imageName}";
    }

    /**
     * @param $thumb
     * @param int $width
     * @param int $height
     */
    private function image($thumb, int $width, int $height)
    {
        $source = ($this->imageMime == self::$allowedExt[1] ? imagecreatefromjpeg($this->inputPath) : imagecreatefrompng($this->inputPath));

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $this->resample($thumb, $source, $width, $height);
        imagepng($thumb, "{$this->outputPath}/{$this->imageName}.png", $this->quality);

        imagedestroy($thumb);
        imagedestroy($source);
    }

    /**
     * @param $thumb
     * @param $source
     * @param int $width
     * @param int $height
     * @return bool
     */
    private function resample($thumb, $source, int $width, int $height): bool
    {
        list($src_w, $src_h) = getimagesize($this->inputPath);
        $src_x = 0;
        $src_y = 0;

        $cmp_x = $src_w / $width;
        $cmp_y = $src_h / $height;

        if ($cmp_x > $cmp_y) {
            $src_w = round($src_w / $cmp_x * $cmp_y);
            $src_x = round(($src_w - ($src_w / $cmp_x * $cmp_y)));
        } elseif ($cmp_y > $cmp_x) {
            $src_h = round($src_h / $cmp_y * $cmp_x);
            $src_y = round(($src_h - ($src_h / $cmp_y * $cmp_x)));
        }

        $src_x = (int)$src_x;
        $src_h = (int)$src_h;
        $src_y = (int)$src_y;
        $src_y = (int)$src_y;

        return imagecopyresampled($thumb, $source, 0, 0, $src_x, $src_y, $width, $height, $src_w, $src_h);
    }

    /**
     * @return array
     */
    private function names(): array
    {
        foreach (self::APPLE_TOUCH_ICON_PRECOMPOSED as $item) {
            $this->names[] = 'apple-touch-icon-';
        }

        foreach (self::ICON as $item) {
            $this->names[] = 'favicon-';
        }

        $msApplication = $this->msApplication;
        array_shift($msApplication);
        foreach ($msApplication as $item) {
            $this->names[] = 'mstile-';
        }

        return $this->names;
    }
}