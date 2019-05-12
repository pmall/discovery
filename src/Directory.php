<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class Directory implements \IteratorAggregate
{
    /**
     * The default FilesystemIterator options.
     *
     * @var int
     */
    const DEFAULT_OPTIONS = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS;

    /**
     * The path of the directory containing the files.
     *
     * @var string
     */
    private $path;

    /**
     * The FilesystemIterator options to use.
     *
     * @var int
     */
    private $options;

    /**
     * Constructor.
     *
     * @param string    $path
     * @param int       $options
     */
    public function __construct(string $path, int $options = self::DEFAULT_OPTIONS)
    {
        $this->path = $path;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        try {
            return new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->path, $this->options)
            );
        }

        catch (\Throwable $e) {
            return new \ArrayIterator([]);
        }
    }
}
