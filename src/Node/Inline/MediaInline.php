<?php

declare(strict_types=1);

namespace DH\Adf\Node\Inline;

use DH\Adf\Node\InlineNode;

class MediaInline extends InlineNode
{
    public const TYPE_LINK = 'link';
    public const TYPE_FILE = 'file';
    public const TYPE_IMAGE = 'image';

    protected string $type = 'mediaInline';
    private string $id;
    private string $collection;
    private ?string $type;
    private ?string $alt;
    private ?string $occurrenceKey;
    private ?float $width;
    private ?float $height;

    public function __construct(string $id, string $collection, ?string $type = null, ?string $alt = null, ?string $occurrenceKey = null, ?float $width = null, ?float $height = null, ?BlockNode $parent = null)
    {
        if ($type !== null && !\in_array($type, [
            self::TYPE_LINK,
            self::TYPE_FILE,
            self::TYPE_IMAGE,
        ], true)) {
            throw new InvalidArgumentException(sprintf('Invalid type "%s"', $type));
        }

        parent::__construct($parent);

        $this->id = $id;
        $this->collection = $collection;
        $this->type = $type;
        $this->alt = $alt;
        $this->occurrenceKey = $occurrenceKey;
        $this->width = $width;
        $this->height = $height;
    }

    public static function load(array $data, ?BlockNode $parent = null): self
    {
        self::checkNodeData(static::class, $data);
        self::checkRequiredKeys(['id', 'collection'], $data['attrs']);

        return new self(
            $data['attrs']['id'],
            $data['attrs']['collection'],
            $data['attrs']['type'] ?? null,
            $data['attrs']['alt'] ?? null,
            $data['attrs']['occurrenceKey'] ?? null,
            $data['attrs']['width'] ?? null,
            $data['attrs']['height'] ?? null,
            $parent
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCollection(): string
    {
        return $this->collection;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function getOccurrenceKey(): ?string
    {
        return $this->occurrenceKey;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    protected function attrs(): array
    {
        $attrs = parent::attrs();
        
        $attrs['id'] = $this->id;
        $attrs['collection'] = $this->collection;
        $attrs['type'] = $this->type;
        $attrs['alt'] = $this->alt;
        $attrs['occurrenceKey'] = $this->occurrenceKey;
        $attrs['width'] = $this->width;
        $attrs['height'] = $this->height;

        return $attrs;
    }
}
