--TEST--
Cairo\FontOptions->getAntialias() method
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

var_dump($options->getAntialias());

/* Wrong number args */
try {
    $options->getAntialias('foo');
    trigger_error('getAntialias requires no args');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontOptions)#%d (0) {
}
object(Cairo\Antialias)#%d (2) {
  ["__elements"]=>
  array(7) {
    ["DEFAULT"]=>
    int(0)
    ["NONE"]=>
    int(1)
    ["GRAY"]=>
    int(2)
    ["SUBPIXEL"]=>
    int(3)
    ["FAST"]=>
    int(4)
    ["GOOD"]=>
    int(5)
    ["BEST"]=>
    int(6)
  }
  ["__value"]=>
  int(0)
}
Cairo\FontOptions::getAntialias() expects exactly 0 arguments, 1 given