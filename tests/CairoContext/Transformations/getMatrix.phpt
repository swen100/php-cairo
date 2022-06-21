--TEST--
Cairo\Context->getMatrix() method
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

var_dump($orig_matrix = $context->getMatrix());

$matrix = new Cairo\Matrix(5, 0, 1, 5);
var_dump($matrix);
var_dump($orig_matrix === $matrix);

$context->setMatrix($matrix);
var_dump($matrix1 = $context->getMatrix());
var_dump($matrix1 === $matrix);
var_dump($orig_matrix === $matrix);

try {
    $context->getMatrix('foo');
} catch (ArgumentCountError $e) {
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
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(5)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(1)
  ["yy"]=>
  float(5)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
bool(false)
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(5)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(1)
  ["yy"]=>
  float(5)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
bool(true)
bool(false)
Cairo\Context::getMatrix() expects exactly 0 arguments, 1 given