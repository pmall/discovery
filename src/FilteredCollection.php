<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class FilteredCollection implements \IteratorAggregate
{
    /**
     * The collection to filter.
     *
     * @var iterable
     */
    private $collection;

    /**
     * The the predicates the collection values must satisfy.
     *
     * @var callable[]
     */
    private $predicates;

    /**
     * Constructor.
     *
     * @param iterable $collection
     * @param callable ...$predicates
     */
    public function __construct(iterable $collection, callable ...$predicates)
    {
        $this->collection = $collection;
        $this->predicates = $predicates;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->collection as $value) {
            if ($this->filtered($value)) {
                yield $value;
            }
        }
    }

    /**
     * Return whether the given value is satisfying all the predicates.
     *
     * @param mixed $value
     * @return bool
     */
    private function filtered($value): bool
    {
        foreach ($this->predicates as $predicate) {
            if (! $predicate($value)) {
                return false;
            }
        }

        return true;
    }
}
