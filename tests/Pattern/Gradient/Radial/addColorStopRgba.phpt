--TEST--
Cairo\Pattern\Gradient->addColorStopRgba() method
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

/* Total number of args needed = 5 */
try {
    $pattern->addColorStopRgba();
    trigger_error('addColorStopRgba with no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1);
    trigger_error('addColorStopRgba with 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1);
    trigger_error('addColorStopRgba with 2 args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, 1);
    trigger_error('addColorStopRgba with 3 args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, 1, 1);
    trigger_error('addColorStopRgba with 4 args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, 1, 1, 1, 1);
    trigger_error('addColorStopRgba with too many args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* All 5 args must be double/float or castable to double/float */
try {
    $pattern->addColorStopRgba(array(), 1, 1, 1, 1);
    trigger_error('Arg 1 must be double');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, array(), 1, 1, 1);
    trigger_error('Arg 2 must be double');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, array(), 1, 1);
    trigger_error('Arg 3 must be double');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, 1, array(), 1);
    trigger_error('Arg 4 must be double');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $pattern->addColorStopRgba(1, 1, 1, 1, array());
    trigger_error('Arg 5 must be double');
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
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 0 given
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 1 given
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 2 given
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 3 given
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 4 given
Cairo\Pattern\Gradient::addColorStopRgba() expects exactly 5 arguments, 6 given
Cairo\Pattern\Gradient::addColorStopRgba(): Argument #1 ($offset) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgba(): Argument #2 ($red) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgba(): Argument #3 ($green) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgba(): Argument #4 ($blue) must be of type float, array given
Cairo\Pattern\Gradient::addColorStopRgba(): Argument #5 ($alpha) must be of type float, array given