--TEST--
Cairo\Context->clipPreserve() method
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

$context->clipPreserve();

try {
    $context->clipPreserve('foo');
} catch (ArgumentCountError $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
Cairo\Context::clipPreserve() expects exactly 0 arguments, 1 given