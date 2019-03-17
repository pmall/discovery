<?php

use function Eloquent\Phony\Kahlan\mock;

use Quanta\Collections\ToRelativePathname;

describe('ToRelativePathname', function () {

    context('when the base path does not end with /', function () {

        beforeEach(function () {

            $this->mapper = new ToRelativePathname('Foo/Bar');

        });

        describe('->__invoke()', function () {

            it('should return the path name of the given file without the base path', function () {

                $file = mock(SplFileInfo::class);

                $file->getPathname->returns('Foo/Bar/Baz/SomeClass.php');

                $test = ($this->mapper)($file->get());

                expect($test)->toEqual('Baz/SomeClass.php');

            });

        });

    });

    context('when the base path ends with /', function () {

        beforeEach(function () {

            $this->mapper = new ToRelativePathname('Foo/Bar/');

        });

        describe('->__invoke()', function () {

            it('should return the path name of the given file without the base path', function () {

                $file = mock(SplFileInfo::class);

                $file->getPathname->returns('Foo/Bar/Baz/SomeClass.php');

                $test = ($this->mapper)($file->get());

                expect($test)->toEqual('Baz/SomeClass.php');

            });

        });

    });

});
