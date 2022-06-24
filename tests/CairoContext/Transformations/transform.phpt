--TEST--
Cairo\Context->transform() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

$matrix = new Cairo\Matrix(1, 0, 0, 1);
var_dump($matrix);

$context->transform($matrix);

/* Wrong number args - expects 1 */
try {
    $context->transform();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - expects 1 */
try {
    $context->transform($matrix, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type, wants matrix object */
try {
    $context->transform(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(1)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(0)
  ["yy"]=>
  float(1)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
Cairo\Context::transform() expects exactly 1 argument, 0 given
Cairo\Context::transform() expects exactly 1 argument, 2 given
Cairo\Context::transform(): Argument #1 ($matrix) must be of type Cairo\Matrix, int given