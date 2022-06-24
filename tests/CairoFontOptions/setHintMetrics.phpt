--TEST--
Cairo\FontOptions->setHintMetrics() method
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

$options->setHintMetrics(Cairo\HintMetrics::ON);
$options->setHintMetrics();

/* Invalid arg (99) */
try {
    $options->setHintMetrics(99);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setHintMetrics(Cairo\HintMetrics::ON, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setHintMetrics(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
Value 99 provided is not a const in enum Cairo\HintMetrics
Cairo\FontOptions::setHintMetrics() expects at most 1 argument, 2 given
Cairo\FontOptions::setHintMetrics(): Argument #1 ($hint_metrics) must be of type int, array given