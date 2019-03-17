<?php

use function Eloquent\Phony\Kahlan\stub;

use Quanta\Collections\FilteredCollection;

describe('FilteredCollection', function () {

    context('when the iterable is an array', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(['value1', 'value2', 'value3']);

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

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(['value1', 'value2', 'value3'], ...[
                    $this->filter1 = stub(),
                    $this->filter2 = stub(),
                    $this->filter3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding the values passing all the filters', function () {

                    $this->filter1->with('value1')->returns(true);
                    $this->filter2->with('value1')->returns(true);
                    $this->filter3->with('value1')->returns(true);

                    $this->filter1->with('value2')->returns(true);
                    $this->filter2->with('value2')->returns(false);
                    $this->filter3->with('value2')->returns(true);

                    $this->filter1->with('value3')->returns(true);
                    $this->filter2->with('value3')->returns(true);
                    $this->filter3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

    context('when the iterable is an iterator', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(
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

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(
                    new ArrayIterator(['value1', 'value2', 'value3']), ...[
                        $this->filter1 = stub(),
                        $this->filter2 = stub(),
                        $this->filter3 = stub(),
                    ]
                );

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding the values passing all the filters', function () {

                    $this->filter1->with('value1')->returns(true);
                    $this->filter2->with('value1')->returns(true);
                    $this->filter3->with('value1')->returns(true);

                    $this->filter1->with('value2')->returns(true);
                    $this->filter2->with('value2')->returns(false);
                    $this->filter3->with('value2')->returns(true);

                    $this->filter1->with('value3')->returns(true);
                    $this->filter2->with('value3')->returns(true);
                    $this->filter3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

    context('when the iterable is a traversable', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(new class implements IteratorAggregate
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

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(new class implements IteratorAggregate
                {
                    public function getIterator()
                    {
                        return new ArrayIterator(['value1', 'value2', 'value3']);
                    }
                }, ...[
                    $this->filter1 = stub(),
                    $this->filter2 = stub(),
                    $this->filter3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a generator yielding the values passing all the filters', function () {

                    $this->filter1->with('value1')->returns(true);
                    $this->filter2->with('value1')->returns(true);
                    $this->filter3->with('value1')->returns(true);

                    $this->filter1->with('value2')->returns(true);
                    $this->filter2->with('value2')->returns(false);
                    $this->filter3->with('value2')->returns(true);

                    $this->filter1->with('value3')->returns(true);
                    $this->filter2->with('value3')->returns(true);
                    $this->filter3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect($test)->toBeAnInstanceOf(Generator::class);
                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

});
