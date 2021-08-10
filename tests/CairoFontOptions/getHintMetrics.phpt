--TEST--
Cairo\FontOptions->getHintMetrics() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

var_dump($options->getHintMetrics());

/* Wrong number args */
try {
    $options->getHintMetrics('foo');
    trigger_error('getHintMetrics requires no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
object(Cairo\HintMetrics)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["DEFAULT"]=>
    int(0)
    ["OFF"]=>
    int(1)
    ["ON"]=>
    int(2)
  }
  ["__value"]=>
  int(0)
}
Cairo\FontOptions::getHintMetrics() expects exactly 0 arguments, 1 given