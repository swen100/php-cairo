--TEST--
Cairo\Surface->getDeviceOffset() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getDeviceOffset());

/* Wrong number args */
try {
    $surface->getDeviceOffset('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
array(2) {
  [0]=>
  float(0)
  [1]=>
  float(0)
}
Cairo\Surface::getDeviceOffset() expects exactly 0 %s, 1 given
