<?php

use Quanta\Collections\Directory;
use Quanta\Collections\ToPsr4Fqcn;
use Quanta\Collections\Psr4Namespace;
use Quanta\Collections\FileCollection;
use Quanta\Collections\MappedCollection;
use Quanta\Collections\ToRelativePathname;
use Quanta\Collections\FilteredCollection;
use Quanta\Collections\ClassSourceInterface;
use Quanta\Collections\IsClassDefinitionFile;

describe('Psr4Namespace', function () {

    beforeEach(function () {

        $this->namespace = new Psr4Namespace('NS\\Foo\\Bar\\Baz', __DIR__ . '/Foo/Bar/Baz');

    });

    it('should implement ClassSourceInterface', function () {

        expect($this->namespace)->toBeAnInstanceOf(ClassSourceInterface::class);

    });

    describe('->classes()', function () {

        it('should return a class collection', function () {

            $test = $this->namespace->classes();

            expect($test)->toEqual(new MappedCollection(
                new FilteredCollection(
                    new FileCollection(
                        new Directory(__DIR__ . '/Foo/Bar/Baz')
                    ),
                    new IsClassDefinitionFile
                ),
                new ToRelativePathname(__DIR__ . '/Foo/Bar/Baz'),
                new ToPsr4Fqcn('NS\\Foo\\Bar\\Baz')
            ));

        });

    });

});
