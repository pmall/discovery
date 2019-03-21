<?php declare(strict_types=1);

namespace Quanta\Collections;

final class Psr4Namespace implements ClassSourceInterface
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
     * Constructor.
     *
     * @param string $prefix
     * @param string $path
     */
    public function __construct(string $prefix, string $path)
    {
        $this->prefix = $prefix;
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function classes(): iterable
    {
        return new MappedCollection(
            new FilteredCollection(
                new FileCollection(
                    new Directory($this->path)
                ),
                new IsClassDefinitionFile
            ),
            new ToRelativePathname($this->path),
            new ToPsr4Fqcn($this->prefix)
        );
    }
}
