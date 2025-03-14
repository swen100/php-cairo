--TEST--
Cairo\Context->getSource() method
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

$pattern = $context->getPattern();
var_dump($pattern);

/* Wrong number args */
try {
    $context->getPattern('foobar');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\Pattern\Solid)#%d (0) {
}
Cairo\Context::getPattern() expects exactly 0 arguments, 1 given