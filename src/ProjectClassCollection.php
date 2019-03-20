<?php declare(strict_types=1);

namespace Quanta\Collections;

final class ProjectClassCollection implements \IteratorAggregate
{
    /**
     * The vendor directory path.
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
        return new MergedCollection(
            new FilteredCollection(
                $this->classesFromClassmap(),
                ...$this->filters
            ),
            ...$this->psr4Namespaces()
        );
    }

    /**
     * Return an array of classes from the autoload_classmap.php file.
     *
     * @return string[]
     */
    private function classesFromClassmap(): array
    {
        $filepath = $this->path . '/composer/autoload_classmap.php';

        if (file_exists($filepath) && is_readable($filepath)) {
            if (is_array($map = require $filepath)) {
                return array_map('strval', array_keys($map));
            }
        }

        return [];
    }

    /**
     * Return an array of Psr4 namespace from the autoload_psr4.php file.
     *
     * @return \Quanta\Collections\Psr4Namespace[]
     */
    private function psr4Namespaces(): array
    {
        $namespaces = [];

        $filepath = $this->path . '/composer/autoload_psr4.php';

        if (file_exists($filepath) && is_readable($filepath)) {
            if (is_array($map = require $filepath)) {
                foreach ($map as $prefix => $paths) {
                    foreach ((array) $paths as $path) {
                        if (is_string($path)) {
                            $namespaces[] = new Psr4Namespace($prefix, $path, ...$this->filters);
                        }
                    }
                }
            }
        }

        return $namespaces;
    }
}
