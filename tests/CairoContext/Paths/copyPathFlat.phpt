--TEST--
Cairo\Context->copyPathFlat() method
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

var_dump($context->copyPathFlat());

/* Wrong number args - expects 0 */
try {
    $context->copyPathFlat('foo');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Path)#%d (0) {
}
Cairo\Context::copyPathFlat() expects exactly 0 arguments, 1 given