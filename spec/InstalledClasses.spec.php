<?php

use Quanta\Discovery\VendorDirectory;
use Quanta\Discovery\InstalledClasses;
use Quanta\Discovery\IsImplementation;
use Quanta\Discovery\FilteredCollection;

describe('InstalledClasses', function () {

    context('when there is no predicate', function () {

        beforeEach(function () {

            $this->collection = new InstalledClasses(Test\TestInterface::class, './test/vendor');

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            it('should return a class name collection with no predicate', function () {

                $test = $this->collection->getIterator();

                expect($test)->toEqual(new FilteredCollection(
                    new VendorDirectory('./test/vendor'),
                    'class_exists',
                    new IsImplementation(Test\TestInterface::class)
                ));

            });

        });

    });

    context('when there is no predicates', function () {

        beforeEach(function () {

            $this->collection = new InstalledClasses(Test\TestInterface::class, './test/vendor', ...[
                $this->predicate1 = function () {},
                $this->predicate2 = function () {},
                $this->predicate3 = function () {},
            ]);

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            it('should return a class name collection with the predicates', function () {

                $test = $this->collection->getIterator();

                expect($test)->toEqual(new FilteredCollection(
                    new VendorDirectory('./test/vendor'),
                    $this->predicate1,
                    $this->predicate2,
                    $this->predicate3,
                    'class_exists',
                    new IsImplementation(Test\TestInterface::class)
                ));

            });

        });

    });

});
