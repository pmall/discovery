<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class ToPsr4Fqcn
{
    /**
     * The namespace prefix to prepend.
     *
     * @var string
     */
    private $prefix;

    /**
     * Constructor.
     *
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Return a Psr4 fully qualified class name from the path name of the given
     * php file.
     *
     * @param string $pathname
     * @return string
     */
    public function __invoke(string $pathname): string
    {
        $fqcn = str_replace('/', '\\', substr(ltrim($pathname, '/'), 0, -4));

        return $this->prefix != ''
            ? sprintf('%s\\%s', rtrim($this->prefix, '\\'), $fqcn)
            : $fqcn;
    }
}
