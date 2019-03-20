<?php

use Quanta\Collections\Directory;
use Quanta\Collections\ToPsr4Fqcn;
use Quanta\Collections\HasClassName;
use Quanta\Collections\Psr4Namespace;
use Quanta\Collections\MappedCollection;
use Quanta\Collections\ToRelativePathname;
use Quanta\Collections\FilteredCollection;

describe('Psr4Namespace', function () {

    context('when there is no filter', function () {

        beforeEach(function () {

            $this->collection = new Psr4Namespace('Test\\NS', __DIR__ . '/.test/directory');

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            it('should return a psr4 class iterator with no filter', function () {

                $test = $this->collection->getIterator();

                expect($test)->toEqual(new FilteredCollection(
                    new MappedCollection(
                        new Directory(__DIR__ . '/.test/directory', new HasClassName),
                        new ToRelativePathname(__DIR__ . '/.test/directory'),
                        new ToPsr4Fqcn('Test\\NS')
                    )
                ));

            });

        });

    });

    context('when there is filters', function () {

        beforeEach(function () {

            $this->collection = new Psr4Namespace('Test\\NS', __DIR__ . '/.test/directory', ...[
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
                    new MappedCollection(
                        new Directory(__DIR__ . '/.test/directory', new HasClassName),
                        new ToRelativePathname(__DIR__ . '/.test/directory'),
                        new ToPsr4Fqcn('Test\\NS')
                    ),
                    $this->filter1,
                    $this->filter2,
                    $this->filter3
                ));

            });

        });

    });

});
