<?php declare(strict_types=1);

namespace Quanta\Collections;

final class FilteredCollection implements \IteratorAggregate
{
    /**
     * The collection to filter.
     *
     * @var iterable
     */
    private $collection;

    /**
     * The filters to apply on the collection values.
     *
     * @var callable[]
     */
    private $filters;

    /**
     * Constructor.
     *
     * @param iterable $collection
     * @param callable ...$filters
     */
    public function __construct(iterable $collection, callable ...$filters)
    {
        $this->collection = $collection;
        $this->filters = $filters;
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
     * Return whether the given value is passing all the filters.
     *
     * @param mixed $value
     * @return bool
     */
    private function filtered($value): bool
    {
        foreach ($this->filters as $filter) {
            if (! $filter($value)) {
                return false;
            }
        }

        return true;
    }
}
