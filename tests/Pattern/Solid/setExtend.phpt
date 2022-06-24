--TEST--
Cairo\Pattern->setExtend() method [using Solid]
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Pattern\Solid;

$pattern = new Solid(1, 1, 1);

$pattern->setExtend(Cairo\Extend::PAD);

$extend = $pattern->getExtend();
var_dump($extend == Cairo\Extend::PAD);

$pattern->setExtend(new Cairo\Extend('PAD'));
$extend = $pattern->getExtend();
var_dump($extend == Cairo\Extend::PAD);

/* Total number of args needed = 1 */
try {
    $pattern->setExtend();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setExtend(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->setExtend(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* int must be in enum */
try {
    $pattern->setExtend(999);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
bool(true)
bool(true)
Cairo\Pattern::setExtend() expects exactly 1 argument, 0 given
Cairo\Pattern::setExtend() expects exactly 1 argument, 2 given
Cairo\Pattern::setExtend(): Argument #1 ($extend) must be of type int, array given
Value 999 provided is not a const in enum Cairo\Extend