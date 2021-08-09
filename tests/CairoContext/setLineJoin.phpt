--TEST--
Cairo\Context->setLineJoin() method
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

$context->setLineJoin(Cairo\LineJoin::BEVEL);
var_dump($context->getLineJoin());

/* Wrong number args - 1 */
try {
    $context->setLineJoin();
    trigger_error('setLineJoin requires 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $context->setLineJoin(1, 1);
    trigger_error('setLineJoin requires only 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong args */
try {
    $context->setLineJoin(array());
    trigger_error('setLineJoin requires int');
} catch (TypeError $e) {
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
  int(2)
}
Cairo\Context::setLineJoin() expects exactly 1 argument, 0 given
Cairo\Context::setLineJoin() expects exactly 1 argument, 2 given
Cairo\Context::setLineJoin(): Argument #1 ($linejoin) must be of type int, array given