<?php

declare(strict_types=1);

namespace DH\Adf\Node\Block;

use DH\Adf\Node\BlockNode;
use DH\Adf\Node\Node;
use DH\Adf\Node\Child\TaskItem;

class TaskList extends BlockNode
{
    protected string $type = 'taskList';

    private string $localId;

    public function __construct(string $localId, ?BlockNode $parent = null) {
        parent::__construct($parent);
    }

    public static function load(array $data, ?BlockNode $parent = null): self
    {
        self::checkNodeData(static::class, $data, ['attrs']);
        self::checkRequiredKeys(['localId'], $data['attrs']);

        $node = new self($data['attrs']['localId'],$parent);

        // set content if defined
        if (\array_key_exists('content', $data)) {
            foreach ($data['content'] as $nodeData) {
                $class = Node::NODE_MAPPING[$nodeData['type']];
                $child = $class::load($nodeData, $node);

                $node->append($child);
            }
        }

        return $node;
    }

    public function getLocalId(): string
    {
        return $this->localId;
    }

    protected function attrs(): array
    {
        $attrs = parent::attrs();
        
        $attrs['localId'] = $this->localId;

        return $attrs;
    }
}
