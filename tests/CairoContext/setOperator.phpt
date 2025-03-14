--TEST--
Cairo\Context->setOperator() method
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

$context->setOperator(new \Cairo\Operator(\Cairo\Operator::CLEAR));
var_dump($context->getOperator());


/* wrong params */
try {
	$context->setOperator();
	trigger_error('Cairo\Context->setOperator() expects 1 param');
} 
catch (TypeError $ex) {
	echo $ex->getMessage(), PHP_EOL;
}
try {
	$context->setOperator(new \Cairo\Operator(\Cairo\Operator::CLEAR), 1);
	trigger_error('Cairo\Context->setOperator() expects 1 param');
} 
catch (TypeError $ex) {
	echo $ex->getMessage(), PHP_EOL;
}

/* wrong type */
try {
	$context->setOperator(array());
	trigger_error('Cairo\Context->setOperator() expects 1 param');
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
object(Cairo\Operator)#%d (2) {
  ["__elements"]=>
  array(29) {
    ["CLEAR"]=>
    int(0)
    ["SOURCE"]=>
    int(1)
    ["OVER"]=>
    int(2)
    ["IN"]=>
    int(3)
    ["OUT"]=>
    int(4)
    ["ATOP"]=>
    int(5)
    ["DEST"]=>
    int(6)
    ["DEST_OVER"]=>
    int(7)
    ["DEST_IN"]=>
    int(8)
    ["DEST_OUT"]=>
    int(9)
    ["DEST_ATOP"]=>
    int(10)
    ["XOR"]=>
    int(11)
    ["ADD"]=>
    int(12)
    ["SATURATE"]=>
    int(13)
    ["MULTIPLY"]=>
    int(14)
    ["SCREEN"]=>
    int(15)
    ["OVERLAY"]=>
    int(16)
    ["DARKEN"]=>
    int(17)
    ["LIGHTEN"]=>
    int(18)
    ["COLOR_DODGE"]=>
    int(19)
    ["COLOR_BURN"]=>
    int(20)
    ["HARD_LIGHT"]=>
    int(21)
    ["SOFT_LIGHT"]=>
    int(22)
    ["DIFFERENCE"]=>
    int(23)
    ["EXCLUSION"]=>
    int(24)
    ["HSL_HUE"]=>
    int(25)
    ["HSL_SATURATION"]=>
    int(26)
    ["HSL_COLOR"]=>
    int(27)
    ["HSL_LUMINOSITY"]=>
    int(28)
  }
  ["__value"]=>
  int(0)
}
Cairo\Context::setOperator() expects exactly 1 argument, 0 given
Cairo\Context::setOperator() expects exactly 1 argument, 2 given
Cairo\Context::setOperator(): Argument #1 ($operator) must be of type int, array given