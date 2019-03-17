<?php declare(strict_types=1);

namespace Quanta\Collections;

final class IsPsr4ClassDefinitionFile
{
    /**
     * Return whether the name of the given file is a Psr4 class file.
     *
     * It must start with an uppercased letter, contains only letters an numbers
     * and have .php as extension.
     *
     * It actually also matches interfaces and traits and should be filtered out
     * by `class_exists()`.
     *
     * @param \SplFileInfo $file
     * @return bool
     */
    public function __invoke(\SplFileInfo $file)
    {
        return preg_match('/[A-Z][A-Za-z0-9]+\.php$/', $file->getFilename()) === 1;
    }
}
