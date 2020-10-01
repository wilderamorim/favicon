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
    protected $inputPath;

    /** @var string */
    protected $outputPath;

    /** @var string */
    protected $url;

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
        '57x57',
        '114x114',
        '72x72',
        '144x144',
        '60x60',
        '120x120',
        '76x76',
        '152x152',
    ];

    protected const ICON = [
        '196x196',
        '96x96',
        '32x32',
        '16x16',
        '128x128',
    ];

    /** @var string[] */
    protected $msApplication = [
        'TileColor' => '#FFFFFF',
        'TileImage' => 'mstile-144x144.png',
        'square70x70logo' => 'mstile-70x70.png',
        'square150x150logo' => 'mstile-150x150.png',
        'wide310x150logo' => 'mstile-310x150.png',
        'square310x310logo' => 'mstile-310x310.png',
    ];

    /** @var array */
    protected $sizes = [];

    /**
     * Tags constructor.
     * @param string $inputPath
     * @param string $outputPath
     * @param string $url
     * @param int $quality
     */
    public function __construct(string $inputPath, string $outputPath, string $url, int $quality)
    {
        $this->inputPath = $inputPath;
        $this->outputPath = $outputPath;
        $this->url = str_replace('../', null, $url) . '/' . $this->outputPath;
        $this->quality = $quality;

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