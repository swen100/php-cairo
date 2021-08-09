--TEST--
Cairo\Context->arc() method
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
	trigger_error('Cairo\Context::arc() expects 5 parameters!');
}

$context->arc(0, 0, 1, 0, 2 * M_PI);

/* wrong params */
try {
    $context->arc();
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,1,1,1,1);
    trig_err();
} 
catch (ArgumentCountError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

/* wrong types */
try {
    $context->arc(array(),1,1,1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,array(),1,1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,array(),1,1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,1,array(),1);
    trig_err();
} 
catch (TypeError $ex) {
    echo $ex->getMessage(), PHP_EOL;
}

try {
    $context->arc(1,1,1,1,array());
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
Cairo\Context::arc() expects exactly 5 %s, 0 given
Cairo\Context::arc() expects exactly 5 %s, 1 given
Cairo\Context::arc() expects exactly 5 %s, 2 given
Cairo\Context::arc() expects exactly 5 %s, 3 given
Cairo\Context::arc() expects exactly 5 %s, 4 given
Cairo\Context::arc() expects exactly 5 %s, 6 given
Cairo\Context::arc(): Argument #1 ($x) must be of type float, array given
Cairo\Context::arc(): Argument #2 ($y) must be of type float, array given
Cairo\Context::arc(): Argument #3 ($radius) must be of type float, array given
Cairo\Context::arc(): Argument #4 ($angle1) must be of type float, array given
Cairo\Context::arc(): Argument #5 ($angle2) must be of type float, array given