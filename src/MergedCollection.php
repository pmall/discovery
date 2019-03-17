<?php declare(strict_types=1);

namespace Quanta\Collections;

final class MergedCollection implements \IteratorAggregate
{
    /**
     * The iterables to merge.
     *
     * @var iterable[]
     */
    private $iterables;

    /**
     * Constructor.
     *
     * @param iterable ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        $this->iterables = $iterables;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->iterables as $iterable) {
            foreach ($iterable as $element) {
                yield $element;
            }
        }
    }
}
