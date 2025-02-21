<?php

declare(strict_types=1);

namespace DH\Adf\Builder;

use DH\Adf\Node\Child\Media;

trait MediaBuilder
{
    use BuilderInterface;

    public function media(string $mediaType, ?string $id, ?string $collection, ?int $width = null, ?int $height = null, ?string $occurrenceKey = null, ?string $url = null, ?string $alt = null): Media
    {
        $block = new Media($mediaType, $id, $collection, $width, $height, $occurrenceKey, $url, $alt, $this);
        $this->append($block);

        return $block;
    }
}
