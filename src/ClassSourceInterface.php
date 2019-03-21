<?php declare(strict_types=1);

namespace Quanta\Collections;

interface ClassSourceInterface
{
    /**
     * Return a collection of class names.
     *
     * @return iterable
     */
    public function classes(): iterable;
}
