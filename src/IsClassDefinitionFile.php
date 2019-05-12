<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class IsClassDefinitionFile
{
    /**
     * Pattern matching a class name (from php manual)
     *
     * @var string
     * @see http://php.net/manual/en/language.oop5.basic.php
     */
    const PATTERN = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

    /**
     * Return whether the name of the given file could be a valid class name.
     *
     * @param \SplFileInfo $file
     * @return bool
     */
    public function __invoke(\SplFileInfo $file)
    {
        return $file->getExtension() == 'php'
            && preg_match(self::PATTERN, $file->getBasename('.php')) === 1;
    }
}
