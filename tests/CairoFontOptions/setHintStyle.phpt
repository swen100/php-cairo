--TEST--
Cairo\FontOptions->setHintStyle() method
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

$options->setHintStyle(Cairo\HintStyle::FULL);
$options->setHintStyle();

/* Invalid arg (99) */
try {
    $options->setHintStyle(99);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setHintStyle(Cairo\HintStyle::FULL, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setHintStyle(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
Value 99 provided is not a const in enum Cairo\HintStyle
Cairo\FontOptions::setHintStyle() expects at most 1 argument, 2 given
Cairo\FontOptions::setHintStyle(): Argument #1 ($hint_style) must be of type int, array given