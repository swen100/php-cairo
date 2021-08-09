--TEST--
Cairo\Context->getLineJoin() method
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

var_dump($context->getLineJoin());

/* Wrong number args */
try {
    $context->getLineJoin('foobar');
    trigger_error('getLineJoin requires no args');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\LineJoin)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["MITER"]=>
    int(0)
    ["ROUND"]=>
    int(1)
    ["BEVEL"]=>
    int(2)
  }
  ["__value"]=>
  int(0)
}
Cairo\Context::getLineJoin() expects exactly 0 arguments, 1 given