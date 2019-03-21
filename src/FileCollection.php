<?php declare(strict_types=1);

namespace Quanta\Collections;

final class FileCollection implements \IteratorAggregate
{
    /**
     * The source of SplFileInfo.
     *
     * @var \Quanta\Collections\FileSourceInterface
     */
    private $source;

    /**
     * Constructor.
     *
     * @param \Quanta\Collections\FileSourceInterface $source
     */
    public function __construct(FileSourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->source->files();
    }
}
