<?php


namespace ElePHPant\Favicon;


/**
 * Class Tags
 *
 * Please report bugs on https://github.com/wilderamorim/favicon/issues
 *
 * @package ElePHPant\Favicon
 * @author Wilder Amorim <agencia@uebi.com.br>
 * @copyright Copyright (c) 2020, Uebi. All rights reserved
 * @license MIT License
 */
abstract class Tags
{
    /** @var string */
    protected $sourceImage;

    /** @var string */
    protected $saveInPath;

    /** @var string */
    protected $websiteUrl;

    /** @var string */
    protected $websiteTitle;

    /** @var null */
    protected $rssFeedUrl = null;

    /** @var int */
    protected $quality;

    /** @var \SimpleXMLIterator */
    private $meta;

    /** @var \SimpleXMLIterator */
    private $link;

    /**
     * Sizes
     */
    protected const APPLE_TOUCH_ICON_PRECOMPOSED = [
        '57x57',    // Standard iOS home screen (iPod Touch, iPhone first generation to 3G)
        '114x114',  // iPhone retina touch icon (iOS6 or prior)
        '72x72',    // iPad touch icon (non-retina - iOS6 or prior)
        '144x144',  // iPad retina (iOS6 or prior)
        '60x60',    // iPhone touch icon (non-retina - iOS7)
        '120x120',  // iPhone retina touch icon (iOS7)
        '76x76',    // iPad touch icon (non-retina - iOS7)
        '152x152',  // iPad retina touch icon (iOS7)
    ];

    protected const ICON = [
        '196x196',  // Android Chrome (M31+)
        '96x96',    // GoogleTV icon
        '32x32',    // New tab page in IE, taskbar button in Win 7+, Safari Reading List sidebar
        '16x16',    // The interweb standard for (almost) every browser
        '128x128',  // Chrome Web Store app icon &amp; Android icon (lo-res)
    ];

    /** @var string[] */
    protected $msApplication = [
        'TileColor' => '#FFFFFF',
        'TileImage' => 'mstile-144x144.png',            // IE10 Metro tile for pinned site
        'square70x70logo' => 'mstile-70x70.png',        // Win 8.1 Metro tile image (small)
        'square150x150logo' => 'mstile-150x150.png',    // Win 8.1 Metro tile image (square)
        'wide310x150logo' => 'mstile-310x150.png',      // Win 8.1 Metro tile image (wide)
        'square310x310logo' => 'mstile-310x310.png',    // Win 8.1 Metro tile image (large)
    ];

    /** @var array */
    protected $sizes = [];

    /**
     * Tags constructor.
     * @param string $sourceImage
     * @param string $saveInPath
     * @param string $websiteUrl
     * @param string|null $websiteTitle
     * @param string|null $backgroundColor
     * @param string|null $rssFeedUrl
     */
    public function __construct(
        string $sourceImage,
        string $saveInPath,
        string $websiteUrl,
        ?string $websiteTitle,
        ?string $backgroundColor,
        ?string $rssFeedUrl
    ) {
        $this->sourceImage = $sourceImage;
        $this->saveInPath = $saveInPath;
        $this->websiteUrl = $websiteUrl . '/' . str_replace('../', null, $this->saveInPath);
        $this->websiteTitle = $websiteTitle;
        $this->msApplication['TileColor'] = $backgroundColor;
        $this->rssFeedUrl = $rssFeedUrl;
        $this->quality = 5;

        $this->meta = new \SimpleXMLIterator('<meta/>');
        $this->link = new \SimpleXMLIterator('<link/>');

        $merge = array_merge(self::APPLE_TOUCH_ICON_PRECOMPOSED, self::ICON);
        $this->sizes = array_merge($merge, self::msSizes());
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $render = null;
        for ($this->meta->rewind(); $this->meta->valid(); $this->meta->next()) {
            $render .= $this->meta->current()->asXML();
        }

        return urldecode($render);
    }

    /**
     * @param string $meta
     * @param array $attributes
     */
    protected function buildMeta(string $meta, array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            $add = $this->meta->addChild('meta');
            $add->addAttribute($meta, $name);
            $add->addAttribute('content', $value);
        }
    }

    /**
     * @param string $rel
     * @param string $href
     * @param string $sizes
     * @param string|null $type
     */
    protected function buildLink(string $rel, string $href, string $sizes, ?string $type = null): void
    {
        $add = $this->meta->addChild('link');
        $add->addAttribute('rel', $rel);
        $add->addAttribute('href', $href);
        $add->addAttribute('sizes', $sizes);

        if ($type) {
            $add->addAttribute('type', $type);
        }
    }

    /**
     * @return array
     */
    protected function msSizes(): array
    {
        $msApplication = $this->msApplication;
        array_shift($msApplication);

        $msSizes = null;
        foreach ($msApplication as $item) {
            $msSizes[] = str_replace(['mstile-', '.png'], [null], $item);
        }

        return $msSizes;
    }
}