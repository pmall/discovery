<?php

use function Eloquent\Phony\Kahlan\stub;

use Quanta\Collections\MappedCollection;

describe('MappedCollection', function () {

    context('when the iterable is an array', function () {

        context('when there is no mapper', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(['value1', 'value2', 'value3']);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is mappers', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(['value1', 'value2', 'value3'], ...[
                    $this->mapper1 = stub(),
                    $this->mapper2 = stub(),
                    $this->mapper3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values mapped by all the mappers', function () {

                    $this->mapper1->with('value1')->returns('m1:value1');
                    $this->mapper2->with('m1:value1')->returns('m2:value1');
                    $this->mapper3->with('m2:value1')->returns('m3:value1');

                    $this->mapper1->with('value2')->returns('m1:value2');
                    $this->mapper2->with('m1:value2')->returns('m2:value2');
                    $this->mapper3->with('m2:value2')->returns('m3:value2');

                    $this->mapper1->with('value3')->returns('m1:value3');
                    $this->mapper2->with('m1:value3')->returns('m2:value3');
                    $this->mapper3->with('m2:value3')->returns('m3:value3');

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['m3:value1', 'm3:value2', 'm3:value3']);

                });

            });

        });

    });

    context('when the iterable is an iterator', function () {

        context('when there is no mapper', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(
                    new ArrayIterator(['value1', 'value2', 'value3'])
                );

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is mappers', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(
                    new ArrayIterator(['value1', 'value2', 'value3']), ...[
                        $this->mapper1 = stub(),
                        $this->mapper2 = stub(),
                        $this->mapper3 = stub(),
                    ]
                );

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values mapped by all the mappers', function () {

                    $this->mapper1->with('value1')->returns('m1:value1');
                    $this->mapper2->with('m1:value1')->returns('m2:value1');
                    $this->mapper3->with('m2:value1')->returns('m3:value1');

                    $this->mapper1->with('value2')->returns('m1:value2');
                    $this->mapper2->with('m1:value2')->returns('m2:value2');
                    $this->mapper3->with('m2:value2')->returns('m3:value2');

                    $this->mapper1->with('value3')->returns('m1:value3');
                    $this->mapper2->with('m1:value3')->returns('m2:value3');
                    $this->mapper3->with('m2:value3')->returns('m3:value3');

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['m3:value1', 'm3:value2', 'm3:value3']);

                });

            });

        });

    });

    context('when the iterable is a traversable', function () {

        context('when there is no mapper', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(new class implements IteratorAggregate
                {
                    public function getIterator()
                    {
                        return new ArrayIterator(['value1', 'value2', 'value3']);
                    }
                });

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is mappers', function () {

            beforeEach(function () {

                $this->collection = new MappedCollection(new class implements IteratorAggregate
                {
                    public function getIterator()
                    {
                        return new ArrayIterator(['value1', 'value2', 'value3']);
                    }
                }, ...[
                    $this->mapper1 = stub(),
                    $this->mapper2 = stub(),
                    $this->mapper3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding all the values mapped by all the mappers', function () {

                    $this->mapper1->with('value1')->returns('m1:value1');
                    $this->mapper2->with('m1:value1')->returns('m2:value1');
                    $this->mapper3->with('m2:value1')->returns('m3:value1');

                    $this->mapper1->with('value2')->returns('m1:value2');
                    $this->mapper2->with('m1:value2')->returns('m2:value2');
                    $this->mapper3->with('m2:value2')->returns('m3:value2');

                    $this->mapper1->with('value3')->returns('m1:value3');
                    $this->mapper2->with('m1:value3')->returns('m2:value3');
                    $this->mapper3->with('m2:value3')->returns('m3:value3');

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['m3:value1', 'm3:value2', 'm3:value3']);

                });

            });

        });

    });

});
