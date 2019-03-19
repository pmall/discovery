<?php declare(strict_types=1);

namespace Quanta\Collections;

final class Psr4Namespace implements \IteratorAggregate
{
    /**
     * The root namespace of the classes.
     *
     * @var string
     */
    private $root;

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
     * @param string    $root
     * @param string    $path
     * @param callable  ...$filters
     */
    public function __construct(string $root, string $path, callable ...$filters)
    {
        $this->root = $root;
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
                new Directory($this->path, new IsPsr4ClassDefinitionFile),
                new ToRelativePathname($this->path),
                new ToFqcn($this->root)
            ),
            ...array_merge($this->filters, ['class_exists'])
        );
    }
}
