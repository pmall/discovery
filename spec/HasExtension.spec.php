<?php

use Quanta\Collections\HasExtension;

describe('HasExtension', function () {

    beforeEach(function () {

        $this->filter = new HasExtension('php');

    });

    describe('->__invoke()', function () {

        context('when the given file has the expected extension', function () {

            it('should return true', function () {

                $file = new SplFileInfo('Foo/Bar/Baz/SomeClass.php');

                $test = ($this->filter)($file);

                expect($test)->toBeTruthy();

            });

        });

        context('when the given file does not have the expected extension', function () {

            it('should return false', function () {

                $file = new SplFileInfo('Foo/Bar/Baz/somefile.json');

                $test = ($this->filter)($file);

                expect($test)->toBeFalsy();

            });

        });

    });

});
