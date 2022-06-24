--TEST--
Cairo\FontOptions->setSubpixelOrder() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

$options->setSubpixelOrder(Cairo\SubPixelOrder::RGB);
$options->setSubpixelOrder();

/* Invalid arg (99) */
try {
    $options->setSubpixelOrder(99);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setSubpixelOrder(Cairo\SubPixelOrder::RGB, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setSubpixelOrder(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
Value 99 provided is not a const in enum Cairo\SubPixelOrder
Cairo\FontOptions::setSubpixelOrder() expects at most 1 argument, 2 given
Cairo\FontOptions::setSubpixelOrder(): Argument #1 ($subpixel_order) must be of type int, array given