<?php

use Quanta\Discovery\ToRelativePathname;

describe('ToRelativePathname', function () {

    beforeEach(function () {

        $this->file = new SplFileInfo('Foo/Bar/Baz/SomeClass.php');

    });

    context('when the base path does not end with /', function () {

        describe('->__invoke()', function () {

            it('should return the path name of the given file without the base path', function () {

                $mapper = new ToRelativePathname('Foo/Bar');

                $test = $mapper($this->file);

                expect($test)->toEqual('Baz/SomeClass.php');

            });

        });

    });

    context('when the base path ends with /', function () {

        describe('->__invoke()', function () {

            it('should return the path name of the given file without the base path', function () {

                $mapper = new ToRelativePathname('Foo/Bar/');

                $test = $mapper($this->file);

                expect($test)->toEqual('Baz/SomeClass.php');

            });

        });

    });

});
