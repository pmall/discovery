<?php declare(strict_types=1);

namespace Quanta\Collections;

final class VendorDirectory implements ClassSourceInterface
{
    /**
     * The vendor directory path.
     *
     * @var string
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function classes(): iterable
    {
        $path = (string) realpath($this->path);

        return new MergedCollection(
            $this->classesFromClassmap($path),
            ...$this->psr4Namespaces($path)
        );
    }

    /**
     * Return an array of class names from the autoload_classmap.php file of the
     * vendor directory located at the given absolute path.
     *
     * @param string $vendor
     * @return string[]
     */
    private function classesFromClassmap(string $vendor): array
    {
        $classes = [];

        $filepath = $vendor . '/composer/autoload_classmap.php';

        if (file_exists($filepath) && is_readable($filepath)) {
            if (is_array($map = require $filepath)) {
                foreach ($map as $class => $path) {
                    if (is_string($path) && stripos($path, $vendor) !== false) {
                        $classes[] = $class;
                    }
                }
            }
        }

        return $classes;
    }

    /**
     * Return an array of ClassCollection from the autoload_psr4.php file of the
     * vendor directory located at the given absolute path.
     *
     * @param string $vendor
     * @return \Quanta\Collections\ClassCollection[]
     */
    private function psr4Namespaces(string $vendor): array
    {
        $collections = [];

        $filepath = $vendor . '/composer/autoload_psr4.php';

        if (file_exists($filepath) && is_readable($filepath)) {
            if (is_array($map = require $filepath)) {
                foreach ($map as $prefix => $paths) {
                    foreach ((array) $paths as $path) {
                        if (is_string($path) && stripos($path, $vendor) !== false) {
                            $collections[] = new ClassCollection(
                                new Psr4Namespace($prefix, $path)
                            );
                        }
                    }
                }
            }
        }

        return $collections;
    }
}
