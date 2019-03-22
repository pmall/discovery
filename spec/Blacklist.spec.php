<?php

use Quanta\Collections\Blacklist;

describe('Blacklist', function () {

    context('when there is no pattern',function () {

        describe('->__invoke()', function () {

            it('should return true', function () {

                $test = (new Blacklist)('subject');

                expect($test)->toBeTruthy();

            });

        });

    });

    context('when there is at least one pattern', function () {

        describe('->__invoke()', function () {

            beforeEach(function () {

                $this->filter = new Blacklist(
                    '/^.+?\[pattern1\].+?$/',
                    '/^.+?\[pattern2\].+?$/',
                    '/^.+?\[pattern3\].+?$/'
                );

            });

            context('when preg_match does not fail', function () {

                context('when the given subject does not match any pattern', function () {

                    it('should return true', function () {

                        $test = ($this->filter)('test[pattern]test');

                        expect($test)->toBeTruthy();

                    });

                });

                context('when the given subject matches at least one pattern', function () {

                    it('should return false', function () {

                        $test = ($this->filter)('test[pattern2]test');

                        expect($test)->toBeFalsy();

                    });

                });

            });

            context('when preg_match() fails', function () {

                it('should throw a LogicException', function () {

                    $filter = new Blacklist('/(?:\D+|<\d+>)*[!?]/');

                    $test = function () use ($filter) {
                        $filter('foobar foobar foobar');
                    };

                    expect($test)->toThrow(new LogicException);

                });

            });

        });

    });

});
