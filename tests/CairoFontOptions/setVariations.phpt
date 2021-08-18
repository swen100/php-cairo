--TEST--
Cairo\FontOptions->setVariations() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!method_exists('Cairo\FontOptions', 'setVariations')) {
    die('skip - Cairo\FontOptions->setVariations not available');
}
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

// values are from offical documentation
$options->setVariations("wght=200,wdth=140.5");
$options->setVariations("wght 200 , wdth 140.5");

var_dump($options);

/* Wrong arg types */
try {
    $options->setVariations([]);
    trigger_error('setVariations: wrong arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args  */
try {
    $options->setVariations();
    trigger_error('setVariations: no arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $options->setVariations('', []);
    trigger_error('setVariations: wrong number of args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
object(Cairo\FontOptions)#%d (0) {
}
Cairo\FontOptions::setVariations(): Argument #1 ($variations) must be of type string, array given
Cairo\FontOptions::setVariations() expects exactly 1 argument, 0 given
Cairo\FontOptions::setVariations() expects exactly 1 argument, 2 given