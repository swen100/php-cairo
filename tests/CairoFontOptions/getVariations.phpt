--TEST--
Cairo\FontOptions->getVariations() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!method_exists('Cairo\FontOptions', 'getVariations')) {
    die('skip - Cairo\FontOptions->getVariations not available');
}
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

// values are from offical documentation
$options->setVariations("wght=200,wdth=140.5");
var_dump($options->getVariations());

$options->setVariations("wght 200 , wdth 140.5");
var_dump($options->getVariations());


/* Wrong number args 1 */
try {
    $options->getVariations([]);
    trigger_error('setVariations: wrong number of args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
string(19) "wght=200,wdth=140.5"
string(21) "wght 200 , wdth 140.5"
Cairo\FontOptions::getVariations() expects exactly 0 arguments, 1 given