--TEST--
Cairo\FontOptions->getHintStyle() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = new Cairo\FontOptions();
var_dump($options);

var_dump($options->getHintStyle());

/* Wrong number args */
try {
    $options->getHintStyle('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
object(Cairo\HintStyle)#%d (2) {
  ["__elements"]=>
  array(5) {
    ["DEFAULT"]=>
    int(0)
    ["NONE"]=>
    int(1)
    ["SLIGHT"]=>
    int(2)
    ["MEDIUM"]=>
    int(3)
    ["FULL"]=>
    int(4)
  }
  ["__value"]=>
  int(0)
}
Cairo\FontOptions::getHintStyle() expects exactly 0 arguments, 1 given