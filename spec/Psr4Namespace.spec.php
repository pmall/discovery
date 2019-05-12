<?php

use Quanta\Discovery\Directory;
use Quanta\Discovery\ToPsr4Fqcn;
use Quanta\Discovery\Psr4Namespace;
use Quanta\Discovery\MappedCollection;
use Quanta\Discovery\ToRelativePathname;
use Quanta\Discovery\FilteredCollection;
use Quanta\Discovery\IsClassDefinitionFile;

describe('Psr4Namespace', function () {

    beforeEach(function () {

        $this->collection = new Psr4Namespace('NS\\Foo\\Bar\\Baz', __DIR__ . '/Foo/Bar/Baz');

    });

    it('should implement IteratorAggregate', function () {

        expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

    });

    describe('->getIterator()', function () {

        it('should return a class collection', function () {

            $test = $this->collection->getIterator();

            expect($test)->toEqual(new MappedCollection(
                new FilteredCollection(
                    new Directory(__DIR__ . '/Foo/Bar/Baz'),
                    new IsClassDefinitionFile
                ),
                new ToRelativePathname(__DIR__ . '/Foo/Bar/Baz'),
                new ToPsr4Fqcn('NS\\Foo\\Bar\\Baz')
            ));

        });

    });

});
