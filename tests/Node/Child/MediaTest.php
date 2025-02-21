<?php

declare(strict_types=1);

namespace DH\Adf\Tests\Node\Child;

use DH\Adf\Node\Child\Media;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class MediaTest extends TestCase
{
    public function testInvalidArgument(): void
    {
        self::expectException(InvalidArgumentException::class);

        $doc = (new Media('wow', '6e7c7f2c-dd7a-499c-bceb-6f32bfbf30b5', 'my project files'))->toJson();
    }

    public function testMedia(): void
    {
        $block = new Media(Media::TYPE_FILE, '6e7c7f2c-dd7a-499c-bceb-6f32bfbf30b5', 'my project files', 100, 200, 'myOccurrenceKey');
        $doc = $block->toJson();

        self::assertJsonStringEqualsJsonString($doc, json_encode([
            'type' => 'media',
            'attrs' => [
                'id' => '6e7c7f2c-dd7a-499c-bceb-6f32bfbf30b5',
                'type' => 'file',
                'collection' => 'my project files',
                'width' => 100,
                'height' => 200,
                'occurrenceKey' => 'myOccurrenceKey',
            ],
        ]));
    }
}
