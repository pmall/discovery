<?php declare(strict_types=1);

namespace Quanta\Collections;

final class FilteredCollection implements \IteratorAggregate
{
    /**
     * The elements to loop over.
     *
     * @var iterable
     */
    private $elements;

    /**
     * The filters to apply on the iterable elements.
     *
     * @var callable[]
     */
    private $filters;

    /**
     * Constructor.
     *
     * @param iterable $elements
     * @param callable ...$filters
     */
    public function __construct(iterable $elements, callable ...$filters)
    {
        $this->elements = $elements;
        $this->filters = $filters;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->elements as $element) {
            if ($this->filtered($element)) {
                yield $element;
            }
        }
    }

    /**
     * Return whether the given element is passing all the filters.
     *
     * @param mixed $element
     * @return bool
     */
    private function filtered($element): bool
    {
        foreach ($this->filters as $filter) {
            if (! $filter($element)) {
                return false;
            }
        }

        return true;
    }
}
