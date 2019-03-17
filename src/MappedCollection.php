<?php declare(strict_types=1);

namespace Quanta\Collections;

final class MappedCollection implements \IteratorAggregate
{
    /**
     * The elements to loop over.
     *
     * @var iterable
     */
    private $elements;

    /**
     * The mappers to apply on the iterable elements.
     *
     * @var callable[]
     */
    private $mappers;

    /**
     * Constructor.
     *
     * @param iterable $elements
     * @param callable ...$mappers
     */
    public function __construct(iterable $elements, callable ...$mappers)
    {
        $this->elements = $elements;
        $this->mappers = $mappers;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->elements as $element) {
            yield array_reduce($this->mappers, [$this, 'reduced'], $element);
        }
    }

    /**
     * Apply the given mapper to the given element.
     *
     * @param mixed     $element
     * @param callable  $mapper
     * @return mixed
     */
    private function reduced($element, callable $mapper)
    {
        return $mapper($element);
    }
}
