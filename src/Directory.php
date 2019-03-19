<?php declare(strict_types=1);

namespace Quanta\Collections;

final class Directory implements \IteratorAggregate
{
    /**
     * The path of the directory containing the files.
     *
     * @var string
     */
    private $path;

    /**
     * The filters used to filter out the files.
     *
     * @var callable[]
     */
    private $filters;

    /**
     * Constructor.
     *
     * @param string    $path
     * @param callable  ...$filters
     */
    public function __construct(string $path, callable ...$filters)
    {
        $this->path = $path;
        $this->filters = $filters;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        $options = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS;

        try {
            return new FilteredCollection(
                new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($this->path, $options)
                ),
                ...$this->filters
            );
        }

        catch (\Throwable $e) {
            return new \ArrayIterator([]);
        }
    }
}
