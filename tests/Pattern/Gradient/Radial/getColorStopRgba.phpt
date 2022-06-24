--TEST--
Cairo\Pattern\Gradient->getColorStopRgba() method
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Pattern\Gradient\Radial;

$pattern = new Radial(0.5, 0.5, 0.25, 0.5, 0.5, 0.5);

$pattern->addColorStopRgba(0.2, 0.8, 0.6, 0.5, 0.2);
var_dump($pattern->getColorStopRgba(0));

/* Total number of args needed = 1 */
try {
    $pattern->getColorStopRgba();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->getColorStopRgba(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* arg must be int or castable to int */
try {
    $pattern->getColorStopRgba(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECT--
array(4) {
  ["red"]=>
  float(0.8)
  ["green"]=>
  float(0.6)
  ["blue"]=>
  float(0.5)
  ["alpha"]=>
  float(0.2)
}
Cairo\Pattern\Gradient::getColorStopRgba() expects exactly 1 argument, 0 given
Cairo\Pattern\Gradient::getColorStopRgba() expects exactly 1 argument, 2 given
Cairo\Pattern\Gradient::getColorStopRgba(): Argument #1 ($index) must be of type int, array given