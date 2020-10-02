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
     * @param string $sourceImage
     * @param string $saveInPath
     * @param string $websiteUrl
     * @param string|null $websiteTitle
     * @param string|null $backgroundColor
     * @param string|null $rssFeedUrl
     * @param bool $cropper
     */
    public function __construct(
        string $sourceImage,
        string $saveInPath,
        string $websiteUrl,
        ?string $websiteTitle = null,
        ?string $backgroundColor = '#FFFFFF',
        ?string $rssFeedUrl = null,
        bool $cropper = true
    ) {
        parent::__construct($sourceImage, $saveInPath, $websiteUrl, $websiteTitle, $backgroundColor, $rssFeedUrl);

        if ($cropper) {
            try {
                (new Cropper($sourceImage, $saveInPath, $websiteUrl, $websiteTitle, $backgroundColor, $rssFeedUrl))
                    ->create();
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
        $this->applicationName($this->websiteTitle);
        $this->msApplication();
        $this->msApplicationNotification($this->rssFeedUrl);

        return $this;
    }

    /**
     * @return Favicon
     */
    private function appleTouchIconPrecomposed(): Favicon
    {
        foreach (self::APPLE_TOUCH_ICON_PRECOMPOSED as $item) {
            $this->buildLink('apple-touch-icon-precomposed', "{$this->websiteUrl}/apple-touch-icon-{$item}.png", $item);
        }

        return $this;
    }

    /**
     * @return Favicon
     */
    private function icon(): Favicon
    {
        foreach (self::ICON as $item) {
            $this->buildLink('icon', "{$this->websiteUrl}/favicon-{$item}.png", $item, 'image/png');
        }

        return $this;
    }

    /**
     * @param string|null $name
     * @return Favicon
     */
    private function applicationName(?string $name = '&nbsp;'): Favicon
    {
        $this->buildMeta('name', ['application-name' => $name]);
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
                $this->buildMeta('name', ["msapplication-{$key}" => "{$this->websiteUrl}/{$value}"]);
            }
        }

        return $this;
    }

    /**
     * @param string|null $rss
     * @return Favicon|null
     */
    private function msApplicationNotification(?string $rss = null): ?Favicon
    {
        if (!$rss) {
            return null;
        }

        $content = "frequency=30;polling-uri=https://notifications.buildmypinnedsite.com/?feed={$rss}&id=1;polling-uri2=https://notifications.buildmypinnedsite.com/?feed={$rss}&id=2;polling-uri3=https://notifications.buildmypinnedsite.com/?feed={$rss}&id=3;polling-uri4=https://notifications.buildmypinnedsite.com/?feed={$rss}&id=4;polling-uri5=https://notifications.buildmypinnedsite.com/?feed={$rss}&id=5;cycle=1";
        $this->buildMeta('name', ['msapplication-notification' => $content]);

        return $this;
    }
}