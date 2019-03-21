<?php declare(strict_types=1);

namespace Quanta\Collections;

final class ClassCollection implements \IteratorAggregate
{
    /**
     * The source of class names.
     *
     * @var \Quanta\Collections\ClassSourceInterface
     */
    private $source;

    /**
     * Constructor.
     *
     * @param \Quanta\Collections\ClassSourceInterface $source
     */
    public function __construct(ClassSourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->source->classes();
    }
}
