<?php declare(strict_types=1);

namespace Quanta\Collections;

final class Whitelist
{
    /**
     * The pattern the string must match.
     *
     * @var string
     */
    private $pattern;

    /**
     * Return a new Whitelist from the given pattern.
     *
     * @param string $pattern
     * @return \Quanta\Collections\Whitelist
     */
    public static function instance(string $pattern): self
    {
        return new self($pattern);
    }

    /**
     * Constructor.
     *
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * Return whether the given string matches the pattern.
     *
     * @param string $subject
     * @return bool
     */
    public function __invoke(string $subject): bool
    {
        return preg_match($this->pattern, $subject) === 1;
    }
}
