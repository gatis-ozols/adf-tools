<?php

declare(strict_types=1);

namespace DH\Adf\Node\Child;

use DH\Adf\Node\BlockNode;
use DH\Adf\Node\Node;
use InvalidArgumentException;

class TaskItem extends BlockNode {
    public const STATE_TODO = 'TODO';
    public const STATE_DONE = 'DONE';

    protected string $type = 'taskItem';

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

        return new self(
            $data['attrs']['localId'],
            $data['attrs']['state'],
            $parent
        );
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