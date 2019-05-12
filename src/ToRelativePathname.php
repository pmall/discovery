<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class ToRelativePathname
{
    /**
     * The base path to remove from the file path name.
     *
     * @var string
     */
    private $basepath;

    /**
     * Constructor.
     *
     * @param string $basepath
     */
    public function __construct(string $basepath)
    {
        $this->basepath = $basepath;
    }

    /**
     * Return the relative path name of the given file.
     *
     * @param \SplFileInfo $file
     * @return string
     */
    public function __invoke(\SplFileInfo $file): string
    {
        return substr($file->getPathname(), strlen(rtrim($this->basepath, '/')) + 1);
    }
}
