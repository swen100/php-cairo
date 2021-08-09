--TEST--
Cairo\Context->curveTo() method
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

function trig_err()
{
	trigger_error('Cairo\Context::curveTo() expects 5 parameters!');
}

$context->curveTo(0, 0, 1, 0, 1, 1);

/* wrong params */
try {
    $context->curveTo();
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,1,1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong types */
try {
    $context->curveTo(array(),1,1,1,1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,array(),1,1,1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,array(),1,1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,array(),1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,1,array(),1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->curveTo(1,1,1,1,1,array());
    trig_err();
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
Cairo\Context::curveTo() expects exactly 6 arguments, 0 given
Cairo\Context::curveTo() expects exactly 6 arguments, 1 given
Cairo\Context::curveTo() expects exactly 6 arguments, 2 given
Cairo\Context::curveTo() expects exactly 6 arguments, 3 given
Cairo\Context::curveTo() expects exactly 6 arguments, 4 given
Cairo\Context::curveTo() expects exactly 6 arguments, 5 given
Cairo\Context::curveTo() expects exactly 6 arguments, 7 given
Cairo\Context::curveTo(): Argument #1 ($x1) must be of type float, array given
Cairo\Context::curveTo(): Argument #2 ($y1) must be of type float, array given
Cairo\Context::curveTo(): Argument #3 ($x2) must be of type float, array given
Cairo\Context::curveTo(): Argument #4 ($y2) must be of type float, array given
Cairo\Context::curveTo(): Argument #5 ($x3) must be of type float, array given
Cairo\Context::curveTo(): Argument #6 ($y3) must be of type float, array given