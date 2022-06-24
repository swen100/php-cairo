--TEST--
Cairo\FontOptions->merge() method
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

$options2 = new Cairo\FontOptions();
$options->merge($options2);

/* Wrong number args 1 */
try {
    $options->merge();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->merge($options2, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs \Cairo\FontOptions */
try {
    $options->merge(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
try {
    $dummy = new stdClass();
    $options->merge($dummy);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
Cairo\FontOptions::merge() expects exactly 1 argument, 0 given
Cairo\FontOptions::merge() expects exactly 1 argument, 2 given
Cairo\FontOptions::merge(): Argument #1 ($other) must be of type Cairo\FontOptions, int given
Cairo\FontOptions::merge(): Argument #1 ($other) must be of type Cairo\FontOptions, stdClass given