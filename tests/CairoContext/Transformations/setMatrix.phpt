--TEST--
Cairo\Context->setMatrix() method
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

$matrix = new Cairo\Matrix(1, 0, 0, 1, 1);
var_dump($matrix);

$context->setMatrix($matrix);
$matrix1 = $context->getMatrix();

var_dump($matrix === $matrix1);

$matrix2 = new Cairo\Matrix(5, 0, 1, 5);
$context->setMatrix($matrix2);
$matrix1 = $context->getMatrix();

var_dump($matrix2 === $matrix1);

try {
    $context->setMatrix();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setMatrix(1, 1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setMatrix(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

die; // DO NOT REMOVE THIS - fixes issue in 5.3 with GC giving bogus memleak reports
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
  float(1)
  ["y0"]=>
  float(0)
}
bool(true)
bool(true)
Cairo\Context::setMatrix() expects exactly 1 argument, 0 given
Cairo\Context::setMatrix() expects exactly 1 argument, 3 given
Cairo\Context::setMatrix(): Argument #1 ($matrix) must be of type Cairo\Matrix, int given