<?php

namespace Idles;

use \Idles\Iterators\{
    FlattenIteratorIterator,
    MapRecursiveIterator,
    MapRecursiveArrayIterator,
    ValuesIterator
};


function _flatMapDepth(?iterable $collection, callable $iteratee, int $depth): iterable
{
    $collection ??= [];

    if (\is_array($collection)) {
        $it = new FlattenIteratorIterator(new MapRecursiveArrayIterator($collection, $iteratee));
        $it->setMaxDepth($depth);
        return \iterator_to_array(new ValuesIterator($it), false);
    }
    $it = new FlattenIteratorIterator(new MapRecursiveIterator($collection, $iteratee));
    $it->setMaxDepth($depth);
    return new ValuesIterator($it);
}

function flatMap(...$args)
{
    return curryN(2, 
        fn (callable $iteratee, ?iterable $collection) => _flatMapDepth($collection, $iteratee, 1)
    )(...$args);
}

function chain(...$args)
{
    return flatMap(...$args);
}

function flatMapDeep(...$args)
{
    return curryN(2, 
        fn (callable $iteratee, ?iterable $collection) => _flatMapDepth($collection, $iteratee, \PHP_INT_MAX)
    )(...$args);
}

function flatMapDepth(...$args)
{
    return curryN(3, 
        fn (callable $iteratee, int $depth, ?iterable $collection) => _flatMapDepth($collection, $iteratee, $depth)
    )(...$args);
}
