--TEST--
Cairo\Context->setDash() method
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

$context->setDash(array(1,2,3));
var_dump($context->getDash());

/* Wrong number args - expects 1 or 2 */
try {
    $context->setDash();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - expects 1 or 2 */
try {
    $context->setDash(array(), 1, 1);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}


/* Wrong arg type, expects array of double, double offset */
try {
    $context->setDash(3);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setDash(array('foo'));
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    $context->setDash(array(1), 'foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
array(2) {
  ["dashes"]=>
  array(3) {
    [0]=>
    float(1)
    [1]=>
    float(2)
    [2]=>
    float(3)
  }
  ["offset"]=>
  float(0)
}
Cairo\Context::setDash() expects at least 1 argument, 0 given
Cairo\Context::setDash() expects at most 2 arguments, 3 given
Cairo\Context::setDash(): Argument #1 ($dashes) must be of type array, int given
invalid value for a dash setting
Cairo\Context::setDash(): Argument #2 ($offset) must be of type float, string given