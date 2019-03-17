<?php

use Quanta\Collections\MergedCollection;

describe('MergedCollection', function () {

    context('when there is no iterable', function () {

        beforeEach(function () {

            $this->collection = new MergedCollection;

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            it('should return a generator yielding no value', function () {

                $test = $this->collection->getIterator();

                expect($test)->toBeAnInstanceOf(Generator::class);
                expect(iterator_to_array($test))->toEqual([]);

            });

        });

    });

    context('when there is iterables', function () {

        beforeEach(function () {

            $this->collection = new MergedCollection(...[
                ['value1', 'value2', 'value3'],
                new ArrayIterator(['value4', 'value5', 'value6']),
                new class implements IteratorAggregate
                {
                    public function getIterator()
                    {
                        return new ArrayIterator(['value7', 'value8', 'value9']);
                    }
                }
            ]);

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            it('should return a generator yielding all the values of all iterables', function () {

                $test = $this->collection->getIterator();

                expect($test)->toBeAnInstanceOf(Generator::class);
                expect(iterator_to_array($test))->toEqual([
                    'value1',
                    'value2',
                    'value3',
                    'value4',
                    'value5',
                    'value6',
                    'value7',
                    'value8',
                    'value9',
                ]);

            });

        });

    });

});
