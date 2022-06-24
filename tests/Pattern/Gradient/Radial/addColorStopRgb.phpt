--TEST--
Cairo\Pattern\Gradient->addColorStopRgb() method
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

$pattern->addColorStopRgb(0.2, 0.8, 0.6, 0.5);
var_dump($pattern->getColorStopRgba(0));

/* Total number of args needed = 4 */
try {
    $pattern->addColorStopRgb();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* All 4 args must be double/float or castable to double/float */
try {
    $pattern->addColorStopRgb(array(), 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, array(), 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, 1, array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgb(1, 1, 1, array());
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
  float(1)
}
Cairo\Pattern\Gradient::addColorStopRgb() expects exactly 4 arguments, 0 given
Cairo\Pattern\Gradient::addColorStopRgb() expects exactly 4 arguments, 1 given
Cairo\Pattern\Gradient::addColorStopRgb() expects exactly 4 arguments, 2 given
Cairo\Pattern\Gradient::addColorStopRgb() expects exactly 4 arguments, 3 given
Cairo\Pattern\Gradient::addColorStopRgb() expects exactly 4 arguments, 5 given
Cairo\Pattern\Gradient::addColorStopRgb(): Argument #1 ($offset) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgb(): Argument #2 ($red) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgb(): Argument #3 ($green) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgb(): Argument #4 ($blue) must be of type float, array given