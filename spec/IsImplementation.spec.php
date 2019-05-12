<?php

use Quanta\Discovery\IsImplementation;

require_once __DIR__ . '/.test/classes.php';

describe('IsImplementation', function () {

    beforeEach(function () {

        $this->predicate = new IsImplementation(Test\TestInterface::class);

    });

    describe('->__invoke()', function () {

        context('when the string is the name of a class implementing the interface', function () {

            it('should return true', function () {

                $test = ($this->predicate)(Test\TestClass1::class);

                expect($test)->toBeTruthy();

            });

        });

        context('when the given string is not the name of a class implementing the interface', function () {

            it('should return false', function () {

                $test = ($this->predicate)(Test\TestClass2::class);

                expect($test)->toBeFalsy();

            });

        });

    });

});
