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

/* Wrong number args 1 */
try {
    $options->setSubpixelOrder();
    trigger_error('setSubpixelOrder requires 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setSubpixelOrder(Cairo\SubPixelOrder::RGB, 1);
    trigger_error('setSubpixelOrder requires only 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setSubpixelOrder(array());
    trigger_error('setSubpixelOrder requires int');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}

Notice: setSubpixelOrder requires 1 arg in %s
Cairo\FontOptions::setSubpixelOrder() expects at most 1 argument, 2 given
Cairo\FontOptions::setSubpixelOrder(): Argument #1 ($subpixel_order) must be of type int, array given