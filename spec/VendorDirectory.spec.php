<?php

use Quanta\Collections\Psr4Namespace;
use Quanta\Collections\VendorDirectory;
use Quanta\Collections\ClassCollection;
use Quanta\Collections\MergedCollection;
use Quanta\Collections\ClassSourceInterface;

describe('VendorDirectory', function () {

    beforeEach(function () {

        $this->path = __DIR__ . '/.test';

        $this->vendordir = new VendorDirectory($this->path . '/vendor');

        if (file_exists($this->path . '/vendor/composer/autoload_classmap.php')) {
            unlink($this->path . '/vendor/composer/autoload_classmap.php');
        }

        if (file_exists($this->path . '/vendor/composer/autoload_psr4.php')) {
            unlink($this->path . '/vendor/composer/autoload_psr4.php');
        }

        if (file_exists($this->path . '/vendor/composer')) {
            rmdir($this->path . '/vendor/composer');
        }

        if (file_exists($this->path . '/vendor')) {
            rmdir($this->path . '/vendor');
        }

    });

    it('should implement ClassSourceInterface', function () {

        expect($this->vendordir)->toBeAnInstanceOf(ClassSourceInterface::class);

    });

    describe('->classes()', function () {

        beforeEach(function () {

            $this->classmap = sprintf('<?php return %s;', var_export([
                'Foo\\Bar\\Baz\\SomeClass1' => realpath($this->path) . '/vendor/src/Foo/Bar/Baz/SomeClass1.php',
                'Foo\\Bar\\Baz\\SomeClass2' => realpath($this->path) . '/vendor/src/Foo/Bar/Baz/SomeClass2.php',
                'Foo\\Bar\\Baz\\SomeClass3' => realpath($this->path) . '/src/Foo/Bar/Baz/SomeClass3.php',
            ], true));

            $this->namespaces = sprintf('<?php return %s;', var_export([
                'Ns1\\Foo\\Bar\\Baz\\' => [
                    realpath($this->path) . '/vendor/src/Ns11/Foo/Bar/Baz',
                    realpath($this->path) . '/vendor/src/Ns12/Foo/Bar/Baz',
                ],
                'Ns2\\Foo\\Bar\\Baz\\' => realpath($this->path) . '/vendor/src/Ns21/Foo/Bar/Baz',
                'Ns3\\Foo\\Bar\\Baz\\' => realpath($this->path) . '/src/Ns31/Foo/Bar/Baz',
            ], true));

        });

        $cleanup = function () {

            if (file_exists($this->path . '/vendor/composer/autoload_classmap.php')) {
                unlink($this->path . '/vendor/composer/autoload_classmap.php');
            }

            if (file_exists($this->path . '/vendor/composer/autoload_psr4.php')) {
                unlink($this->path . '/vendor/composer/autoload_psr4.php');
            }

            if (file_exists($this->path . '/vendor/composer')) {
                rmdir($this->path . '/vendor/composer');
            }

            if (file_exists($this->path . '/vendor')) {
                rmdir($this->path . '/vendor');
            }

        };

        beforeEach($cleanup);

        afterEach($cleanup);

        context('when the vendor directory does not exists', function () {

            it('should return an empty collection', function () {

                $test = $this->vendordir->classes();

                expect(iterator_to_array($test))->toEqual([]);

            });

        });

        context('when the vendor directory exists', function () {

            beforeEach(function () {

                mkdir($this->path . '/vendor');

            });

            context('when the vendor/composer directory does not exist', function () {

                it('should return an empty collection', function () {

                    $test = $this->vendordir->classes();

                    expect(iterator_to_array($test))->toEqual([]);

                });

            });

            context('when the vendor/composer directory exists', function () {

                beforeEach(function () {

                    mkdir($this->path . '/vendor/composer');

                });

                context('when there is a vendor/composer/autoload_classmap.php file', function () {

                    beforeEach(function () {

                        file_put_contents(
                            $this->path . '/vendor/composer/autoload_classmap.php',
                            $this->classmap
                        );

                    });

                    context('when there is no vendor/composer/autoload_psr4.php file', function () {

                        it('should return a class collection', function () {

                            $test = $this->vendordir->classes();

                            expect($test)->toEqual(new MergedCollection([
                                'Foo\\Bar\\Baz\\SomeClass1',
                                'Foo\\Bar\\Baz\\SomeClass2',
                            ]));

                        });

                    });

                    context('when there is a vendor/composer/autoload_psr4.php file', function () {

                        it('should return a class collection', function () {

                            file_put_contents(
                                $this->path . '/vendor/composer/autoload_psr4.php',
                                $this->namespaces
                            );

                            $test = $this->vendordir->classes();

                            expect($test)->toEqual(new MergedCollection(
                                [
                                    'Foo\\Bar\\Baz\\SomeClass1',
                                    'Foo\\Bar\\Baz\\SomeClass2',
                                ],
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns1\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns11/Foo/Bar/Baz'
                                    )
                                ),
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns1\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns12/Foo/Bar/Baz'
                                    )
                                ),
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns2\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns21/Foo/Bar/Baz'
                                    )
                                )
                            ));

                        });

                    });

                });

                context('when there is no vendor/composer/autoload_classmap.php file', function () {

                    context('when there is a vendor/composer/autoload_psr4.php file', function () {

                        it('should return a class collection', function () {

                            file_put_contents(
                                $this->path . '/vendor/composer/autoload_psr4.php',
                                $this->namespaces
                            );

                            $test = $this->vendordir->classes();

                            expect($test)->toEqual(new MergedCollection(
                                [],
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns1\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns11/Foo/Bar/Baz'
                                    )
                                ),
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns1\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns12/Foo/Bar/Baz'
                                    )
                                ),
                                new ClassCollection(
                                    new Psr4Namespace(
                                        'Ns2\\Foo\\Bar\\Baz\\',
                                        realpath($this->path) . '/vendor/src/Ns21/Foo/Bar/Baz'
                                    )
                                )
                            ));

                        });

                    });

                    context('when there is no vendor/composer/autoload_psr4.php file', function () {

                        it('should return an empty collection', function () {

                            $test = $this->vendordir->classes();

                            expect(iterator_to_array($test))->toEqual([]);

                        });

                    });

                });

            });

        });

    });

});
