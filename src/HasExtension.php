<?php declare(strict_types=1);

namespace Quanta\Collections;

final class HasExtension
{
    /**
     * The extension the file must have.
     *
     * @var string
     */
    private $extension;

    /**
     * Constructor.
     *
     * @param string $extension
     */
    public function __construct(string $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Return whether the given file has the expected extension.
     *
     * @param \SplFileInfo $file
     * @return bool
     */
    public function __invoke(\SplFileInfo $file): bool
    {
        return $file->getExtension() == $this->extension;
    }
}
