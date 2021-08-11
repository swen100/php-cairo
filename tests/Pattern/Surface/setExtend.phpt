--TEST--
Cairo\Pattern->setExtend() method [using Surface]
--SKIPIF--
<?php
include __DIR__ . '/../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Surface\Image;
use Cairo\Pattern\Surface;

$surface = new Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$pattern = new Surface($surface);
var_dump($pattern);

$pattern->setExtend(Cairo\Extend::PAD);
$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::PAD);

$pattern->setExtend(1);
$extend = $pattern->getExtend();
var_dump($extend);
var_dump($extend == Cairo\Extend::REPEAT);

/* Total number of args needed = 1 */
try {
    $pattern->setExtend();
    trigger_error('setExtend with no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setExtend(1, 1);
    trigger_error('setExtend with too many args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->setExtend([]);
    trigger_error('Arg 1 must be int or enum');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->setExtend($surface);
    #trigger_error('Arg 1 must be int or enum');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Pattern\Surface)#%d (0) {
}
object(Cairo\Extend)#3 (2) {
  ["__elements"]=>
  array(4) {
    ["NONE"]=>
    int(0)
    ["REPEAT"]=>
    int(1)
    ["REFLECT"]=>
    int(2)
    ["PAD"]=>
    int(3)
  }
  ["__value"]=>
  int(3)
}
bool(true)
object(Cairo\Extend)#%d (2) {
  ["__elements"]=>
  array(4) {
    ["NONE"]=>
    int(0)
    ["REPEAT"]=>
    int(1)
    ["REFLECT"]=>
    int(2)
    ["PAD"]=>
    int(3)
  }
  ["__value"]=>
  int(1)
}
bool(true)
Cairo\Pattern::setExtend() expects exactly 1 argument, 0 given
Cairo\Pattern::setExtend() expects exactly 1 argument, 2 given
Cairo\Pattern::setExtend(): Argument #1 ($extend) must be of type int, array given
Cairo\Pattern::setExtend(): Argument #1 ($extend) must be of type int, Cairo\Surface\Image given