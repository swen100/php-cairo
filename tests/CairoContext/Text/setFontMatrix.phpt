--TEST--
Cairo\Context->setFontMatrix() method
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

$matrix = new Cairo\Matrix();
var_dump($matrix);

$context->setFontMatrix($matrix);
$matrix1 = $context->getFontMatrix();

var_dump($matrix === $matrix1);

$matrix2 = new Cairo\Matrix(5, 5);
$context->setFontMatrix($matrix2);
$matrix1 = $context->getFontMatrix();

var_dump($matrix2 === $matrix1);

try {
    $context->setFontMatrix();
    trigger_error('Set matrix requires one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setFontMatrix(1, 1);
    trigger_error('Set matrix requires only one arg');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setFontMatrix(1);
    trigger_error('Set matrix requires instanceof Cairomatrix');
} catch (Error $e) {
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
  float(0)
  ["xy"]=>
  float(0)
  ["x0"]=>
  float(0)
  ["yx"]=>
  float(0)
  ["yy"]=>
  float(0)
  ["y0"]=>
  float(0)
}
bool(true)
bool(true)
Cairo\Context::setFontMatrix() expects exactly 1 argument, 0 given
Cairo\Context::setFontMatrix() expects exactly 1 argument, 2 given
Cairo\Context::setFontMatrix(): Argument #1 ($matrix) must be of type Cairo\Matrix, int given