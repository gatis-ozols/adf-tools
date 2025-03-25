<?php

declare(strict_types=1);

namespace DH\Adf\Builder;

use DH\Adf\Node\Block\CodeBlock;

trait CodeblockBuilder
{
    use BuilderInterface;

    public function codeblock(?string $language = null, ?string $uniqueId = null): CodeBlock
    {
        $block = new CodeBlock($language, $uniqueId, $this);
        $this->append($block);

        return $block;
    }
}
