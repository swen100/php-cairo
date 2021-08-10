--TEST--
Cairo\FontOptions->getSubpixelOrder() method
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

var_dump($options->getSubpixelOrder());

/* Wrong number args */
try {
    $options->getSubpixelOrder('foo');
    trigger_error('getSubpixelOrder requires no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
object(Cairo\SubPixelOrder)#2 (2) {
  ["__elements"]=>
  array(5) {
    ["DEFAULT"]=>
    int(0)
    ["RGB"]=>
    int(1)
    ["BGR"]=>
    int(2)
    ["VRGB"]=>
    int(3)
    ["VBGR"]=>
    int(4)
  }
  ["__value"]=>
  int(0)
}
Cairo\FontOptions::getSubpixelOrder() expects exactly 0 arguments, 1 given