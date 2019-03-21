<?php

use function Eloquent\Phony\Kahlan\mock;

use Quanta\Collections\FileCollection;
use Quanta\Collections\FileSourceInterface;

describe('FileCollection', function () {

    beforeEach(function () {

        $this->source = mock(FileSourceInterface::class);

        $this->collection = new FileCollection($this->source->get());

    });

    it('should implement IteratorAggregate', function () {

        expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

    });

    describe('->getIterator()', function () {

        it('should return the collection provided by the file source ->files() method', function () {

            $collection = new ArrayIterator;

            $this->source->files->returns($collection);

            $test = $this->collection->getIterator();

            expect($test)->toBe($collection);

        });

    });

});
