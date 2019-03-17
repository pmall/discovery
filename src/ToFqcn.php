<?php declare(strict_types=1);

namespace Quanta\Collections;

final class ToFqcn
{
    /**
     * The root namespace to prepend.
     *
     * @var string
     */
    private $root;

    /**
     * Constructor.
     *
     * @param string $root
     */
    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * Return a fully qualified class name from the given php file path name.
     *
     * @param string $pathname
     * @return string
     */
    public function __invoke(string $pathname): string
    {
        $fqcn = str_replace('/', '\\', substr(ltrim($pathname, '/'), 0, -4));

        return $this->root != ''
            ? sprintf('%s\\%s', rtrim($this->root, '\\'), $fqcn)
            : $fqcn;
    }
}
