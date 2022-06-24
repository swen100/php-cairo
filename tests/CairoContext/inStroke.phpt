--TEST--
Cairo\Context->inStroke() method
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

var_dump($context->inStroke(1, 1));

/* Wrong number args */
try {
    $context->inStroke();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $context->inStroke(1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $context->inStroke(1, 1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type*/
try {
    $context->inStroke(array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type*/
try {
    $context->inStroke(1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
bool(false)
Cairo\Context::inStroke() expects exactly 2 arguments, 0 given
Cairo\Context::inStroke() expects exactly 2 arguments, 1 given
Cairo\Context::inStroke() expects exactly 2 arguments, 3 given
Cairo\Context::inStroke(): Argument #1 ($x) must be of type float, array given
Cairo\Context::inStroke(): Argument #2 ($y) must be of type float, array given