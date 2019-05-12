<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class IsImplementation
{
    /**
     * The interface name the class must implement.
     *
     * @var string
     */
    private $interface;

    /**
     * Constructor.
     *
     * @param string $interface
     */
    public function __construct(string $interface)
    {
        $this->interface = $interface;
    }

    /**
     * Return whether the given string is the name of a class implementing the
     * interface.
     *
     * @param string $class
     * @return bool
     */
    public function __invoke(string $class): bool
    {
        return is_subclass_of($class, $this->interface, true);
    }
}
