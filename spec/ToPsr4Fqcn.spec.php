<?php

use Quanta\Discovery\ToPsr4Fqcn;

describe('ToPsr4Fqcn', function () {

    context('when there the base namespace is empty', function () {

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $mapper = new ToPsr4Fqcn('');

                $test = $mapper('Baz/SomeClass.php');

                expect($test)->toEqual('Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace does not start or end with \\', function () {

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $mapper = new ToPsr4Fqcn('Foo\\Bar');

                $test = $mapper('Baz/SomeClass.php');

                expect($test)->toEqual('Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace starts with \\', function () {

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $mapper = new ToPsr4Fqcn('\\Foo\\Bar');

                $test = $mapper('Baz/SomeClass.php');

                expect($test)->toEqual('\\Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

    context('when the base namespace ends with \\', function () {

        describe('->__invoke()', function () {

            it('should return a fully qualified class name from the given relative file path name', function () {

                $mapper = new ToPsr4Fqcn('Foo\\Bar\\');

                $test = $mapper('Baz/SomeClass.php');

                expect($test)->toEqual('Foo\\Bar\\Baz\\SomeClass');

            });

        });

    });

});
