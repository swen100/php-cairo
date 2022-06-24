--TEST--
Cairo\Context->setLineCap() method
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

$context->setLineCap(Cairo\LineCap::SQUARE);
var_dump($context->getLineCap());

/* Wrong number args - 1 */
try {
    $context->setLineCap();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $context->setLineCap(1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong args */
try {
    $context->setLineCap(array());
} catch (TypeError $e) {
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
  int(2)
}
Cairo\Context::setLineCap() expects exactly 1 argument, 0 given
Cairo\Context::setLineCap() expects exactly 1 argument, 2 given
Cairo\Context::setLineCap(): Argument #1 ($linecap) must be of type int, array given