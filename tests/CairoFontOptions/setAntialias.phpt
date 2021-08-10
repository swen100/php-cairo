--TEST--
Cairo\FontOptions->setAntialias() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

$options->setAntialias(\Cairo\Antialias::SUBPIXEL);

/* Wrong number args 1*/
try {
    $options->setAntialias();
    trigger_error('setAntialias requires 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setAntialias(\Cairo\Antialias::SUBPIXEL, 1);
    trigger_error('setAntialias requires only 1 arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setAntialias([]);
    trigger_error('setAntialias requires int');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}

Notice: setAntialias requires 1 arg in %s
Cairo\FontOptions::setAntialias() expects at most 1 argument, 2 given
Cairo\FontOptions::setAntialias(): Argument #1 ($antialias) must be of type int, array given