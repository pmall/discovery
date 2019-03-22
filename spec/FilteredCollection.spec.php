<?php

use function Eloquent\Phony\Kahlan\stub;

use Quanta\Collections\FilteredCollection;

describe('FilteredCollection', function () {

    context('when the collection is an array', function () {

        context('when there is no predicate', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(['value1', 'value2', 'value3']);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a collection containing all the values', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is at least one predicate', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(['value1', 'value2', 'value3'], ...[
                    $this->predicate1 = stub(),
                    $this->predicate2 = stub(),
                    $this->predicate3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a collection containing the values satisfying all the predicates', function () {

                    $this->predicate1->with('value1')->returns(true);
                    $this->predicate2->with('value1')->returns(true);
                    $this->predicate3->with('value1')->returns(true);

                    $this->predicate1->with('value2')->returns(true);
                    $this->predicate2->with('value2')->returns(false);
                    $this->predicate3->with('value2')->returns(true);

                    $this->predicate1->with('value3')->returns(true);
                    $this->predicate2->with('value3')->returns(true);
                    $this->predicate3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

    context('when the collection is an iterator', function () {

        context('when there is no predicate', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(
                    new ArrayIterator(['value1', 'value2', 'value3'])
                );

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a collection containing all the values', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is at least one predicate', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(
                    new ArrayIterator(['value1', 'value2', 'value3']), ...[
                        $this->predicate1 = stub(),
                        $this->predicate2 = stub(),
                        $this->predicate3 = stub(),
                    ]
                );

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a collection containing the values satisfying all the predicates', function () {

                    $this->predicate1->with('value1')->returns(true);
                    $this->predicate2->with('value1')->returns(true);
                    $this->predicate3->with('value1')->returns(true);

                    $this->predicate1->with('value2')->returns(true);
                    $this->predicate2->with('value2')->returns(false);
                    $this->predicate3->with('value2')->returns(true);

                    $this->predicate1->with('value3')->returns(true);
                    $this->predicate2->with('value3')->returns(true);
                    $this->predicate3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

    context('when the collection is a traversable', function () {

        context('when there is no predicate', function () {

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

                it('should return a collection containing all the values', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value2', 'value3']);

                });

            });

        });

        context('when there is at least one predicate', function () {

            beforeEach(function () {

                $this->collection = new FilteredCollection(new class implements IteratorAggregate
                {
                    public function getIterator()
                    {
                        return new ArrayIterator(['value1', 'value2', 'value3']);
                    }
                }, ...[
                    $this->predicate1 = stub(),
                    $this->predicate2 = stub(),
                    $this->predicate3 = stub(),
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a collection containing the values satisfying all the predicates', function () {

                    $this->predicate1->with('value1')->returns(true);
                    $this->predicate2->with('value1')->returns(true);
                    $this->predicate3->with('value1')->returns(true);

                    $this->predicate1->with('value2')->returns(true);
                    $this->predicate2->with('value2')->returns(false);
                    $this->predicate3->with('value2')->returns(true);

                    $this->predicate1->with('value3')->returns(true);
                    $this->predicate2->with('value3')->returns(true);
                    $this->predicate3->with('value3')->returns(true);

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual(['value1', 'value3']);

                });

            });

        });

    });

});
