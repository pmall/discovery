<?php

use Quanta\Collections\Directory;
use Quanta\Collections\FilteredCollection;

describe('Directory', function () {

    beforeEach(function () {

        $this->options = FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS;

    });

    context('when the directory does not exist', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/notfound');

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return an empty collection', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual([]);

                });

            });

        });

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/notfound', ...[
                    $this->filter1 = function () {},
                    $this->filter2 = function () {},
                    $this->filter3 = function () {},
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return an empty collection', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual([]);

                });

            });

        });

    });

    context('when the directory exists', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test');

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a file collection with no filter', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new FilteredCollection(
                        new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator(__DIR__ . '/.test', $this->options)
                        )
                    ));

                });

            });

        });

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test', ...[
                    $this->filter1 = function () {},
                    $this->filter2 = function () {},
                    $this->filter3 = function () {},
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a file collection with the filters', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new FilteredCollection(
                        new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator(__DIR__ . '/.test', $this->options)
                        ),
                        $this->filter1,
                        $this->filter2,
                        $this->filter3
                    ));

                });

            });

        });

    });

});
