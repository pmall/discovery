<?php

use Quanta\Collections\ToFqcn;

describe('ToFqcn', function () {

    context('when there the base namespace is empty', function () {

        beforeEach(function () {

            $this->mapper = new ToFqcn('');

        });

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $test = ($this->mapper)('Baz/SomeClass.php');

                expect($test)->toEqual('Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace does not start or end with \\', function () {

        beforeEach(function () {

            $this->mapper = new ToFqcn('Foo\\Bar');

        });

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $test = ($this->mapper)('Baz/SomeClass.php');

                expect($test)->toEqual('Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace starts with \\', function () {

        beforeEach(function () {

            $this->mapper = new ToFqcn('\\Foo\\Bar');

        });

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $test = ($this->mapper)('Baz/SomeClass.php');

                expect($test)->toEqual('\\Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace ends with \\', function () {

        beforeEach(function () {

            $this->mapper = new ToFqcn('Foo\\Bar\\');

        });

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $test = ($this->mapper)('Baz/SomeClass.php');

                expect($test)->toEqual('Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

});
