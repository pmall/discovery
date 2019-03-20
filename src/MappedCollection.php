<?php declare(strict_types=1);

namespace Quanta\Collections;

final class MappedCollection implements \IteratorAggregate
{
    /**
     * The collection to map.
     *
     * @var iterable
     */
    private $collection;

    /**
     * The mappers to apply on the collection values.
     *
     * @var callable[]
     */
    private $mappers;

    /**
     * Constructor.
     *
     * @param iterable $collection
     * @param callable ...$mappers
     */
    public function __construct(iterable $collection, callable ...$mappers)
    {
        $this->collection = $collection;
        $this->mappers = $mappers;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->collection as $value) {
            yield array_reduce($this->mappers, [$this, 'reduced'], $value);
        }
    }

    /**
     * Apply the given mapper to the given value.
     *
     * @param mixed     $value
     * @param callable  $mapper
     * @return mixed
     */
    private function reduced($value, callable $mapper)
    {
        return $mapper($value);
    }
}
