<?php

use Quanta\Collections\Directory;
use Quanta\Collections\FilteredCollection;

describe('Directory', function () {

    beforeEach(function () {

        $this->options = FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS;

    });

    context('when the directory exists', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test/directory');

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a directory iterator with no filter', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new FilteredCollection(
                        new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator(__DIR__ . '/.test/directory', $this->options)
                        )
                    ));

                });

            });

            describe('->withFilter()', function () {

                it('should return a new Directory with the given filters', function () {

                    $test = $this->collection->withFilter(...[
                        $filter1 = function () {},
                        $filter2 = function () {},
                        $filter3 = function () {},
                    ]);

                    expect($test)->toEqual(new Directory(__DIR__ . '/.test/directory', ...[
                        $filter1,
                        $filter2,
                        $filter3,
                    ]));

                });

            });

        });

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test/directory', ...[
                    $this->filter1 = function () {},
                    $this->filter2 = function () {},
                    $this->filter3 = function () {},
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a directory iterator with the filters', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new FilteredCollection(
                        new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator(__DIR__ . '/.test/directory', $this->options)
                        ),
                        $this->filter1,
                        $this->filter2,
                        $this->filter3
                    ));

                });

            });

            describe('->withFilter()', function () {

                it('should return a new Directory with the given filters', function () {

                    $test = $this->collection->withFilter(...[
                        $filter4 = function () {},
                        $filter5 = function () {},
                        $filter6 = function () {},
                    ]);

                    expect($test)->toEqual(new Directory(__DIR__ . '/.test/directory', ...[
                        $this->filter1,
                        $this->filter2,
                        $this->filter3,
                        $filter4,
                        $filter5,
                        $filter6,
                    ]));

                });

            });

        });

    });

    context('when the directory does not exist', function () {

        context('when there is no filter', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test/notfound');

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return an empty ArrayIterator', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new ArrayIterator([]));

                });

            });

            describe('->withFilter()', function () {

                it('should return a new Directory with the given filters', function () {

                    $test = $this->collection->withFilter(...[
                        $filter1 = function () {},
                        $filter2 = function () {},
                        $filter3 = function () {},
                    ]);

                    expect($test)->toEqual(new Directory(__DIR__ . '/.test/notfound', ...[
                        $filter1,
                        $filter2,
                        $filter3,
                    ]));

                });

            });

        });

        context('when there is filters', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test/notfound', ...[
                    $this->filter1 = function () {},
                    $this->filter2 = function () {},
                    $this->filter3 = function () {},
                ]);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return an empty ArrayIterator', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new ArrayIterator([]));

                });

            });

            describe('->withFilter()', function () {

                it('should return a new Directory with the given filters', function () {

                    $test = $this->collection->withFilter(...[
                        $filter4 = function () {},
                        $filter5 = function () {},
                        $filter6 = function () {},
                    ]);

                    expect($test)->toEqual(new Directory(__DIR__ . '/.test/notfound', ...[
                        $this->filter1,
                        $this->filter2,
                        $this->filter3,
                        $filter4,
                        $filter5,
                        $filter6,
                    ]));

                });

            });

        });

    });

});
