<?php

use Quanta\Discovery\Directory;

describe('Directory', function () {

    context('when the directory does not exist', function () {

        context('when there is no options', function () {

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

        context('when there is options', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/notfound', FilesystemIterator::SKIP_DOTS);

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

        context('when there is no options', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test');

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a file collection with the default options', function () {

                    $options = FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS;

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator(__DIR__ . '/.test', $options)
                    ));

                });

            });

        });

        context('when there is options', function () {

            beforeEach(function () {

                $this->collection = new Directory(__DIR__ . '/.test', FilesystemIterator::SKIP_DOTS);

            });

            it('should implement IteratorAggregate', function () {

                expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

            });

            describe('->getIterator()', function () {

                it('should return a file collection with the options', function () {

                    $test = $this->collection->getIterator();

                    expect($test)->toEqual(new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator(__DIR__ . '/.test', FilesystemIterator::SKIP_DOTS)
                    ));

                });

            });

        });

    });

});
