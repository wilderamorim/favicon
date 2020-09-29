<?php


namespace ElePHPant\Favicon;


/**
 * Class Favicon
 *
 * Please report bugs on https://github.com/wilderamorim/favicon/issues
 *
 * @package ElePHPant\Favicon
 * @author Wilder Amorim <agencia@uebi.com.br>
 * @copyright Copyright (c) 2020, Uebi. All rights reserved
 * @license MIT License
 */
class Favicon extends Tags
{
    /**
     * Favicon constructor.
     * @param string $inputPath
     * @param string $outputPath
     * @param string $url
     * @param int $quality
     * @param bool $cropper
     */
    public function __construct(string $inputPath, string $outputPath, string $url, int $quality = 5, bool $cropper = true)
    {
        parent::__construct($inputPath, $outputPath, $url, $quality);

        if ($cropper) {
            try {
                (new Cropper($inputPath, $outputPath, $url, $quality))->create();
            } catch (\Exception $e) {
                //
            }
        }
    }

    /**
     * @return $this
     */
    public function favicon(): Favicon
    {
        $this->appleTouchIconPrecomposed();
        $this->icon();
        $this->applicationName();
        $this->msApplication();

        return $this;
    }

    /**
     * @return Favicon
     */
    private function appleTouchIconPrecomposed(): Favicon
    {
        foreach (self::APPLE_TOUCH_ICON_PRECOMPOSED as $item) {
            $this->buildLink('apple-touch-icon-precomposed', "{$this->url}/apple-touch-icon-{$item}.png", $item);
        }

        return $this;
    }

    /**
     * @return Favicon
     */
    private function icon(): Favicon
    {
        foreach (self::ICON as $item) {
            $this->buildLink('icon', "{$this->url}/favicon-{$item}.png", $item, 'image/png');
        }

        return $this;
    }

    /**
     * @return Favicon
     */
    private function applicationName(): Favicon
    {
        $this->buildMeta('name', ['application-name' => '&nbsp;']);
        return $this;
    }

    /**
     * @return Favicon
     */
    private function msApplication(): Favicon
    {
        $tileColor = $this->msApplication['TileColor'];

        foreach ($this->msApplication as $key => $value) {
            if ($value == $tileColor) {
                $this->buildMeta('name', ["msapplication-{$key}" => $value]);
            } else {
                $this->buildMeta('name', ["msapplication-{$key}" => "{$this->url}/{$value}"]);
            }
        }

        return $this;
    }
}