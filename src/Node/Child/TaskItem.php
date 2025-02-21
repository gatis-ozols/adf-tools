<?php

declare(strict_types=1);

namespace DH\Adf\Node\Child;

use DH\Adf\Node\BlockNode;
use DH\Adf\Node\Node;
use DH\Adf\Node\InlineNode;
use InvalidArgumentException;

class TaskItem extends BlockNode {
    public const STATE_TODO = 'TODO';
    public const STATE_DONE = 'DONE';

    protected string $type = 'taskItem';
    protected array $allowedContentTypes = [
        InlineNode::class,
    ];

    private string $localId;
    private string $state;

    public function __construct(string $localId, string $state, ?BlockNode $parent = null)
    {
        if (!\in_array($state, [self::STATE_TODO, self::STATE_DONE], true)) {
            throw new InvalidArgumentException('Invalid state: '.$state);
        }

        parent::__construct($parent);
        $this->localId = $localId;
        $this->state = $state;
    }

    public static function load(array $data, ?BlockNode $parent = null): self
    {
        self::checkNodeData(static::class, $data, ['attrs']);
        self::checkRequiredKeys(['localId', 'state'], $data['attrs']);

        $node = new self(
            $data['attrs']['localId'],
            $data['attrs']['state'],
            $parent
        );

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

    public function getState(): string
    {
        return $this->state;
    }

    protected function attrs(): array
    {
        $attrs = parent::attrs();
        
        $attrs['localId'] = $this->localId;
        $attrs['state'] = $this->state;

        return $attrs;
    }
}