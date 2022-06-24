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
$options->setAntialias();

/* invalid args (out of range)*/
try {
    $options->setAntialias(99);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setAntialias(\Cairo\Antialias::SUBPIXEL, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type - needs int */
try {
    $options->setAntialias([]);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
Value 99 provided is not a const in enum Cairo\Antialias
Cairo\FontOptions::setAntialias() expects at most 1 argument, 2 given
Cairo\FontOptions::setAntialias(): Argument #1 ($antialias) must be of type int, array given