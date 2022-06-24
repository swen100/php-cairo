--TEST--
Cairo\Context->mask() function
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

$pattern = new Cairo\Pattern\Solid(0.3, 0.3, 0.3);
$context->mask($pattern);

/* wrong params */
try {
    $context->mask();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}
try {
    $context->mask($pattern, 1);
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
    $context->mask(array());
}
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
Cairo\Context::mask() expects exactly 1 argument, 0 given
Cairo\Context::mask() expects exactly 1 argument, 2 given
Cairo\Context::mask(): Argument #1 ($pattern) must be of type Cairo\Pattern, array given