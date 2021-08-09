--TEST--
Cairo\Context->setTolerance() method
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

$context->setTolerance(1);
var_dump($context->getTolerance());


/* wrong params */
try {
	$context->setTolerance();
	trigger_error('Cairo\Context->setTolerance() expects 1 param');
} 
catch (TypeError $ex) {
	echo $ex->getMessage(), PHP_EOL;
}
try {
	$context->setTolerance(1, 1);
	trigger_error('Cairo\Context->setTolerance() expects 1 param');
} 
catch (TypeError $ex) {
	echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
	$context->setTolerance(array());
	trigger_error('Cairo\Context->setTolerance() expects param 1 to be float');
} 
catch (TypeError $ex) {
	echo $ex->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Image)#1 (0) {
}
object(Cairo\Context)#2 (0) {
}
float(1)
Cairo\Context::setTolerance() expects exactly 1 argument, 0 given
Cairo\Context::setTolerance() expects exactly 1 argument, 2 given
Cairo\Context::setTolerance(): Argument #1 ($tolerance) must be of type float, array given