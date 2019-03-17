<?php

use function Eloquent\Phony\Kahlan\mock;

use Quanta\Collections\IsPsr4ClassDefinitionFile;

describe('IsPsr4ClassDefinitionFile', function () {

    beforeEach(function () {

        $this->filter = new IsPsr4ClassDefinitionFile;

    });

    describe('->__invoke()', function () {

        beforeEach(function () {

            $this->file = mock(SplFileInfo::class);

        });

        context('when the given file is a psr4 class definition file', function () {

            it('should return true', function () {

                $this->file->getFilename->returns('SomeClass.php');

                $test = ($this->filter)($this->file->get());

                expect($test)->toBeTruthy();

            });

        });

        context('when the given file is not a psr4 class definition file', function () {

            it('should return false', function () {

                $this->file->getFilename->returns('somefile');

                $test = ($this->filter)($this->file->get());

                expect($test)->toBeFalsy();

            });

        });

    });

});
