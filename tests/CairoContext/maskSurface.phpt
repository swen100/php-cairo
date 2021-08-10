--TEST--
Cairo\Context->maskSurface() function
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

$surface2 = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface2);

$context->maskSurface($surface2, 5, 1);

/* wrong params */
try {
    $context->maskSurface();
    trigger_error('maskSurface expects at least 1 param');
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
    $context->maskSurface(new stdClass());
    trigger_error('maskSurface arg 1 expects double');
}
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->maskSurface($surface2, 1, 1, 1);
    trigger_error('maskSurface expects at most 3 params');
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
    $context->maskSurface(array());
    trigger_error('maskSurface arg 1 expects Cairo\Surface');
}
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
    $context->maskSurface($surface2, array());
    trigger_error('maskSurface arg 2 expects double');
}
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
    $context->maskSurface($surface2, 1, array());
    trigger_error('maskSurface arg 1 expects double');
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
object(Cairo\Surface\Image)#%d (0) {
}
Cairo\Context::maskSurface() expects at least 1 argument, 0 given
Cairo\Context::maskSurface(): Argument #1 ($surface) must be of type Cairo\Surface, stdClass given
Cairo\Context::maskSurface() expects at most 3 arguments, 4 given
Cairo\Context::maskSurface(): Argument #1 ($surface) must be of type Cairo\Surface, array given
Cairo\Context::maskSurface(): Argument #2 ($x) must be of type float, array given
Cairo\Context::maskSurface(): Argument #3 ($y) must be of type float, array given