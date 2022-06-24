--TEST--
Cairo\Context->userToDevice() method
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

var_dump($context->userToDevice(5, 5));

/* Wrong number args - 1 */
try {
    $context->userToDevice();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    $context->userToDevice(10);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    $context->userToDevice(10, 10, 10);
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $context->userToDevice(array(), 10);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $context->userToDevice(10, array());
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
  [0]=>
  float(5)
  [1]=>
  float(5)
}
Cairo\Context::userToDevice() expects exactly 2 arguments, 0 given
Cairo\Context::userToDevice() expects exactly 2 arguments, 1 given
Cairo\Context::userToDevice() expects exactly 2 arguments, 3 given
Cairo\Context::userToDevice(): Argument #1 ($x) must be of type float, array given
Cairo\Context::userToDevice(): Argument #2 ($y) must be of type float, array given