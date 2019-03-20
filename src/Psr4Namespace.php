<?php declare(strict_types=1);

namespace Quanta\Collections;

final class Psr4Namespace implements \IteratorAggregate
{
    /**
     * The namespace prefix to prepend.
     *
     * @var string
     */
    private $prefix;

    /**
     * The path of the directory containing the class definition files.
     *
     * @var string
     */
    private $path;

    /**
     * The filters used to filter out fully qualified class names.
     *
     * @var callable[]
     */
    private $filters;

    /**
     * Constructor.
     *
     * @param string    $prefix
     * @param string    $path
     * @param callable  ...$filters
     */
    public function __construct(string $prefix, string $path, callable ...$filters)
    {
        $this->prefix = $prefix;
        $this->path = $path;
        $this->filters = $filters;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new FilteredCollection(
            new MappedCollection(
                new Directory($this->path, new HasClassName),
                new ToRelativePathname($this->path),
                new ToPsr4Fqcn($this->prefix)
            ),
            ...$this->filters
        );
    }
}
