<?php

use Quanta\Collections\Blacklist;

describe('Blacklist::instance()', function () {

    it('should return a new Blacklist with the given pattern', function () {

        $test = Blacklist::instance('pattern');

        expect($test)->toEqual(new Blacklist('pattern'));

    });

});

describe('Blacklist', function () {

    beforeEach(function () {

        $this->filter = new Blacklist('/^.+?\[pattern\].+?$/');

    });

    describe('->__invoke()', function () {

        context('when the given string matches the pattern', function () {

            it('should return false', function () {

                $test = ($this->filter)('test[pattern]test');

                expect($test)->toBeFalsy();

            });

        });

        context('when the given string does not match the pattern', function () {

            it('should return true', function () {

                $test = ($this->filter)('test[otherpattern]test');

                expect($test)->toBeTruthy();

            });

        });

    });

});
