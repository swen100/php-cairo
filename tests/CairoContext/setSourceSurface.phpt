--TEST--
Cairo\Context->setSurface() method
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
var_dump($pattern);

$context->setPattern($pattern);

$surface2 = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface2);

$context->setSurface($surface2, 5, 5);
var_dump($context);

/* Wrong number args */
try {
    $context->setSurface();
    trigger_error('setSurface requires at leastone arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $context->setSurface($surface2, 1, 1, 1);
    trigger_error('setSurface requires no more than 3 args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->setSurface(array());
    trigger_error('setSurface expects instanceof CairoPattern');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->setSurface($surface2, array());
    trigger_error('setSurface expects instanceof CairoPattern');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $context->setSurface($surface2, 1, array());
    trigger_error('setSurface expects double');
} catch (TypeError $e) {
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
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
Cairo\Context::setSurface() expects at least 1 argument, 0 given
Cairo\Context::setSurface() expects at most 3 arguments, 4 given
Cairo\Context::setSurface(): Argument #1 ($surface) must be of type Cairo\Surface, array given
Cairo\Context::setSurface(): Argument #2 ($x) must be of type float, array given
Cairo\Context::setSurface(): Argument #3 ($y) must be of type float, array given
