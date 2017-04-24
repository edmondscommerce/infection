<?php

declare(strict_types=1);


namespace Infection\Mutator\Boolean;


use Infection\Mutator\Mutator;
use PhpParser\Node;

class FalseValue implements Mutator
{
    public function mutate(Node $node)
    {
        return new Node\Expr\ConstFetch(new Node\Name('true'));
    }

    public function shouldMutate(Node $node): bool
    {
        if (!($node instanceof Node\Expr\ConstFetch)) {
            return false;
        }

        return $node->name->getFirst() === 'false';
    }
}