--TEST--
Cairo\Context->getLineCap() method
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

var_dump($context->getLineCap());

/* Wrong number args */
try {
    $context->getLineCap('foobar');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\LineCap)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["BUTT"]=>
    int(0)
    ["ROUND"]=>
    int(1)
    ["SQUARE"]=>
    int(2)
  }
  ["__value"]=>
  int(0)
}
Cairo\Context::getLineCap() expects exactly 0 arguments, 1 given