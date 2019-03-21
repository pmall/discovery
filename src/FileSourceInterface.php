<?php declare(strict_types=1);

namespace Quanta\Collections;

interface FileSourceInterface
{
    /**
     * Return a collection of SplFileInfo.
     *
     * @return iterable
     */
    public function files(): iterable;
}
