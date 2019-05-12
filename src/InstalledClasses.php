<?php declare(strict_types=1);

namespace Quanta\Discovery;

final class InstalledClasses implements \IteratorAggregate
{
    /**
     * The interface the classes must implement.
     *
     * @var string
     */
    private $interface;

    /**
     * The vendor directory path.
     *
     * @var string
     */
    private $path;

    /**
     * The the predicates the class names must satisfy.
     *
     * @var callable[]
     */
    private $predicates;

    /**
     * Constructor.
     *
     * @param string    $interface
     * @param string    $path
     * @param callable  ...$predicates
     */
    public function __construct(string $interface, string $path, callable ...$predicates)
    {
        $this->interface = $interface;
        $this->path = $path;
        $this->predicates = $predicates;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new FilteredCollection(
            new VendorDirectory($this->path),
            ...array_merge($this->predicates, [
                'class_exists',
                new IsImplementation($this->interface),
            ])
        );
    }
}
