<?php

declare(strict_types=1);

namespace DH\Adf\Node\Child;

use DH\Adf\Node\BlockNode;
use DH\Adf\Node\Node;
use InvalidArgumentException;

/**
 * @see https://developer.atlassian.com/cloud/jira/platform/apis/document/nodes/media
 */
class Media extends Node
{
    public const TYPE_FILE = 'file';
    public const TYPE_LINK = 'link';
    public const TYPE_EXTERNAL = 'external';

    protected string $type = 'media';
    private ?string $id;
    private string $mediaType;
    private ?string $collection;
    private ?string $occurrenceKey;
    private ?int $width;
    private ?int $height;
    private ?string $url;
    private ?string $alt;

    public function __construct(string $mediaType, ?string $id = null, ?string $collection = null, ?int $width = null, ?int $height = null, ?string $occurrenceKey = null, ?string $url= null, ?string $alt = null, ?BlockNode $parent = null)
    {
        if (!\in_array($mediaType, [self::TYPE_FILE, self::TYPE_LINK, self::TYPE_EXTERNAL], true)) {
            throw new InvalidArgumentException('Invalid media type');
        }

        parent::__construct($parent);
        $this->id = $id;
        $this->mediaType = $mediaType;
        $this->collection = $collection;
        $this->occurrenceKey = $occurrenceKey;
        $this->width = $width;
        $this->height = $height;
        $this->url = $url;
        $this->alt = $alt;
    }

    public static function load(array $data, ?BlockNode $parent = null): self
    {
        self::checkNodeData(static::class, $data, ['attrs']);
        self::checkRequiredKeys(['type'], $data['attrs']);

        $type = $data['attrs']['type'];
        if($type === self::TYPE_EXTERNAL) {
            self::checkRequiredKeys(['url'], $data['attrs']);
        }
        else {
            self::checkRequiredKeys(['id', 'collection'], $data['attrs']);
        }


        return new self(
            $data['attrs']['type'],
            $data['attrs']['id'] ?? null,
            $data['attrs']['collection'] ?? null,
            $data['attrs']['width'] ?? null,
            $data['attrs']['height'] ?? null,
            $data['attrs']['occurrenceKey'] ?? null,
            $data['attrs']['url'] ?? null,
            $data['attrs']['alt'] ?? null,
            $parent
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getCollection(): string
    {
        return $this->collection;
    }

    public function getOccurrenceKey(): ?string
    {
        return $this->occurrenceKey;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    protected function attrs(): array
    {
        $attrs = parent::attrs();

        if (null !== $this->id) {
            $attrs['id'] = $this->id;
        }

        $attrs['type'] = $this->mediaType;
        
        if (null !== $this->collection) {
            $attrs['collection'] = $this->collection;
        }

        if (null !== $this->occurrenceKey) {
            $attrs['occurrenceKey'] = $this->occurrenceKey;
        }

        if (null !== $this->width) {
            $attrs['width'] = $this->width;
        }

        if (null !== $this->height) {
            $attrs['height'] = $this->height;
        }

        if (null !== $this->url) {
            $attrs['url'] = $this->url;
        }

        if (null !== $this->alt) {
            $attrs['alt'] = $this->alt;
        }

        return $attrs;
    }
}
