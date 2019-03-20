<?php

use Quanta\Collections\Whitelist;

describe('Whitelist::instance()', function () {

    it('should return a new Whitelist with the given pattern', function () {

        $test = Whitelist::instance('pattern');

        expect($test)->toEqual(new Whitelist('pattern'));

    });

});

describe('Whitelist', function () {

    beforeEach(function () {

        $this->filter = new Whitelist('/^.+?\[pattern\].+?$/');

    });

    describe('->__invoke()', function () {

        context('when the given string matches the pattern', function () {

            it('should return true', function () {

                $test = ($this->filter)('test[pattern]test');

                expect($test)->toBeTruthy();

            });

        });

        context('when the given string does not match the pattern', function () {

            it('should return false', function () {

                $test = ($this->filter)('test[otherpattern]test');

                expect($test)->toBeFalsy();

            });

        });

    });

});
