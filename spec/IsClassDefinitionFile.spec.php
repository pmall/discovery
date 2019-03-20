<?php

use Quanta\Collections\IsClassDefinitionFile;

describe('IsClassDefinitionFile', function () {

    beforeEach(function () {

        $this->filter = new IsClassDefinitionFile;

    });

    describe('->__invoke()', function () {

        context('when the name of the given file is a valid class name', function () {

            it('should return true', function () {

                $file = new SplFileInfo('Foo/Bar/Baz/SomeClass.php');

                $test = ($this->filter)($file);

                expect($test)->toBeTruthy();

            });

        });

        context('when the name of the given file is not a valid class name', function () {

            it('should return false', function () {

                $file = new SplFileInfo('Foo/Bar/Baz/somefile');

                $test = ($this->filter)($file);

                expect($test)->toBeFalsy();

            });

        });

    });

});
