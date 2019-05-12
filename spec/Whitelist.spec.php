<?php

use Quanta\Discovery\Whitelist;

describe('Whitelist', function () {

    context('when there is no pattern',function () {

        describe('->__invoke()', function () {

            it('should return true', function () {

                $test = (new Whitelist)('subject');

                expect($test)->toBeTruthy();

            });

        });

    });

    context('when there is at least one pattern', function () {

        describe('->__invoke()', function () {

            beforeEach(function () {

                $this->predicate = new Whitelist(
                    '/^.+?\[pattern1\].+?$/',
                    '/^.+?\[pattern2\].+?$/',
                    '/^.+?\[pattern3\].+?$/'
                );

            });

            context('when preg_match does not fail', function () {

                context('when the given subject matches all the patterns', function () {

                    it('should return true', function () {

                        $test = ($this->predicate)('test[pattern1][pattern2][pattern3]test');

                        expect($test)->toBeTruthy();

                    });

                });

                context('when the given subject does not match at least one pattern', function () {

                    it('should return false', function () {

                        $test = ($this->predicate)('test[pattern]test');

                        expect($test)->toBeFalsy();

                    });

                });

            });

            context('when preg_match() fails', function () {

                it('should throw a LogicException', function () {

                    $test = function () {
                        (new Whitelist('/(?:\D+|<\d+>)*[!?]/'))('foobar foobar foobar');
                    };

                    expect($test)->toThrow(new LogicException);

                });

            });

        });

    });

});
