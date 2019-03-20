<?php

use Quanta\Collections\Psr4Namespace;
use Quanta\Collections\MergedCollection;
use Quanta\Collections\FilteredCollection;
use Quanta\Collections\ComposerInstallation;

describe('ComposerInstallation', function () {

    beforeEach(function () {

        $this->path = __DIR__ . '/.test';

        $this->classmap = sprintf('<?php return %s;', var_export([
            'Foo\\Bar\\Baz\\SomeClass1' => 'src/Foo/Bar/Baz/SomeClass1.php',
            'Foo\\Bar\\Baz\\SomeClass2' => 'src/Foo/Bar/Baz/SomeClass2.php',
        ], true));

        $this->namespaces = sprintf('<?php return %s;', var_export([
            'Ns1\\Foo\\Bar\\Baz\\' => ['src/Ns11/Foo/Bar/Baz', 'src/Ns12/Foo/Bar/Baz'],
            'Ns2\\Foo\\Bar\\Baz\\' => 'src/Ns21/Foo/Bar/Baz',
        ], true));

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

    afterEach(function () {

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

    context('when there is no filter', function () {

        beforeEach(function () {

            $this->collection = new ComposerInstallation($this->path . '/vendor');

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            context('when the vendor directory does not exists', function () {

                it('should return an empty collection', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual([]);

                });

            });

            context('when the vendore directory exists', function () {

                beforeEach(function () {

                    mkdir($this->path . '/vendor');

                });

                context('when the vendor/composer directory does not exist', function () {

                    it('should return an empty collection', function () {

                        $test = $this->collection->getIterator();

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

                            it('should return a class collection with no filter', function () {

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([
                                        'Foo\\Bar\\Baz\\SomeClass1',
                                        'Foo\\Bar\\Baz\\SomeClass2',
                                    ])
                                ));

                            });

                        });

                        context('when there is a vendor/composer/autoload_psr4.php file', function () {

                            it('should return a class collection with no filter', function () {

                                file_put_contents(
                                    $this->path . '/vendor/composer/autoload_psr4.php',
                                    $this->namespaces
                                );

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([
                                        'Foo\\Bar\\Baz\\SomeClass1',
                                        'Foo\\Bar\\Baz\\SomeClass2',
                                    ]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns11/Foo/Bar/Baz'),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns12/Foo/Bar/Baz'),
                                    new Psr4Namespace('Ns2\\Foo\\Bar\\Baz\\', 'src/Ns21/Foo/Bar/Baz')
                                ));

                            });

                        });

                    });

                    context('when there is no vendor/composer/autoload_classmap.php file', function () {

                        context('when there is a vendor/composer/autoload_psr4.php file', function () {

                            it('should return a class collection with no filter', function () {

                                file_put_contents(
                                    $this->path . '/vendor/composer/autoload_psr4.php',
                                    $this->namespaces
                                );

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns11/Foo/Bar/Baz'),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns12/Foo/Bar/Baz'),
                                    new Psr4Namespace('Ns2\\Foo\\Bar\\Baz\\', 'src/Ns21/Foo/Bar/Baz')
                                ));

                            });

                        });

                        context('when there is no vendor/composer/autoload_psr4.php file', function () {

                            it('should return an empty collection', function () {

                                $test = $this->collection->getIterator();

                                expect(iterator_to_array($test))->toEqual([]);

                            });

                        });

                    });

                });

            });

        });

    });

    context('when there is filters', function () {

        beforeEach(function () {

            $this->collection = new ComposerInstallation($this->path . '/vendor', ...[
                $this->filter1 = function () {},
                $this->filter2 = function () {},
                $this->filter3 = function () {},
            ]);

        });

        it('should implement IteratorAggregate', function () {

            expect($this->collection)->toBeAnInstanceOf(IteratorAggregate::class);

        });

        describe('->getIterator()', function () {

            context('when the vendor directory does not exists', function () {

                it('should return an empty collection', function () {

                    $test = $this->collection->getIterator();

                    expect(iterator_to_array($test))->toEqual([]);

                });

            });

            context('when the vendore directory exists', function () {

                beforeEach(function () {

                    mkdir($this->path . '/vendor');

                });

                context('when the vendor/composer directory does not exist', function () {

                    it('should return an empty collection', function () {

                        $test = $this->collection->getIterator();

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

                            it('should return a class collection with no filter', function () {

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([
                                        'Foo\\Bar\\Baz\\SomeClass1',
                                        'Foo\\Bar\\Baz\\SomeClass2',
                                    ], ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ])
                                ));

                            });

                        });

                        context('when there is a vendor/composer/autoload_psr4.php file', function () {

                            it('should return a class collection with no filter', function () {

                                file_put_contents(
                                    $this->path . '/vendor/composer/autoload_psr4.php',
                                    $this->namespaces
                                );

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([
                                        'Foo\\Bar\\Baz\\SomeClass1',
                                        'Foo\\Bar\\Baz\\SomeClass2',
                                    ], ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns11/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns12/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns2\\Foo\\Bar\\Baz\\', 'src/Ns21/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ])
                                ));

                            });

                        });

                    });

                    context('when there is no vendor/composer/autoload_classmap.php file', function () {

                        context('when there is a vendor/composer/autoload_psr4.php file', function () {

                            it('should return a class collection with no filter', function () {

                                file_put_contents(
                                    $this->path . '/vendor/composer/autoload_psr4.php',
                                    $this->namespaces
                                );

                                $test = $this->collection->getIterator();

                                expect($test)->toEqual(new MergedCollection(
                                    new FilteredCollection([], ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns11/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns1\\Foo\\Bar\\Baz\\', 'src/Ns12/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ]),
                                    new Psr4Namespace('Ns2\\Foo\\Bar\\Baz\\', 'src/Ns21/Foo/Bar/Baz', ...[
                                        $this->filter1,
                                        $this->filter2,
                                        $this->filter3
                                    ])
                                ));

                            });

                        });

                        context('when there is no vendor/composer/autoload_psr4.php file', function () {

                            it('should return an empty collection', function () {

                                $test = $this->collection->getIterator();

                                expect(iterator_to_array($test))->toEqual([]);

                            });

                        });

                    });

                });

            });

        });

    });

});
