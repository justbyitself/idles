<?php

namespace Idles;

function ifElse(...$args)
{
    return curryN(
        3,
        fn (callable $predicate, callable $onTrue, callable $onFalse) => 
            fn (...$args) => $predicate(...$args) ? $onTrue(...$args) : $onFalse(...$args)
    )(...$args);
}