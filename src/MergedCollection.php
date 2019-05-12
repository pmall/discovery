<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class MergedCollection implements \IteratorAggregate
{
    /**
     * The collections to merge.
     *
     * @var iterable[]
     */
    private $collections;

    /**
     * Constructor.
     *
     * @param iterable ...$collections
     */
    public function __construct(iterable ...$collections)
    {
        $this->collections = $collections;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->collections as $collection) {
            foreach ($collection as $value) {
                yield $value;
            }
        }
    }
}
