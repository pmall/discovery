<?php

use function Eloquent\Phony\Kahlan\mock;

use Quanta\Collections\ClassCollection;
use Quanta\Collections\ClassSourceInterface;

describe('ClassCollection', function () {

    beforeEach(function () {

        $this->source = mock(ClassSourceInterface::class);

        $this->collection = new ClassCollection($this->source->get());

    });

    it('should implement IteratorAggregate', function () {

        expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

    });

    describe('->getIterator()', function () {

        it('should return the collection provided by the class source ->classes() method', function () {

            $collection = new ArrayIterator;

            $this->source->classes->returns($collection);

            $test = $this->collection->getIterator();

            expect($test)->toBe($collection);

        });

    });

});
