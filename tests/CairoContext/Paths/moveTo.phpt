--TEST--
Cairo\Context->moveTo() method
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
	trigger_error('Cairo\Context::moveTo() expects 2 parameters!');
}

$context->moveTo(1, 1);

/* wrong params */
try {
    $context->moveTo();
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->moveTo(1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->moveTo(1,1, 1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong types */
try {
    $context->moveTo(array(),1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->moveTo(1,array());
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
Cairo\Context::moveTo() expects exactly 2 arguments, 0 given
Cairo\Context::moveTo() expects exactly 2 arguments, 1 given
Cairo\Context::moveTo() expects exactly 2 arguments, 3 given
Cairo\Context::moveTo(): Argument #1 ($x) must be of type float, array given
Cairo\Context::moveTo(): Argument #2 ($y) must be of type float, array given