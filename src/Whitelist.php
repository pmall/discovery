<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class Whitelist
{
    /**
     * The patterns the string must match.
     *
     * @var string[]
     */
    private $patterns;

    /**
     * Constructor.
     *
     * @param string ...$patterns
     */
    public function __construct(string ...$patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * Return whether the given string matches all the patterns.
     *
     * @param string $subject
     * @return bool
     */
    public function __invoke(string $subject): bool
    {
        foreach ($this->patterns as $pattern) {
            $result = preg_match($pattern, $subject);

            if ($result === 0) {
                return false;
            }

            if ($result === false) {
                throw new \LogicException(
                    sprintf('preg_match() failed with code %s', preg_last_error())
                );
            }
        }

        return true;
    }
}
