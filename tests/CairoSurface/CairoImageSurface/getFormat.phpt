--TEST--
Cairo\Surface\Image->getFormat() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getFormat());

/* Wrong number args */
try {
    $surface->getFormat('foo');
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\ImageFormat)#%d (2) {
  ["__elements"]=>
  array(%d) {
    ["ARGB32"]=>
    int(0)
    ["RGB24"]=>
    int(1)
    ["A8"]=>
    int(2)
    ["A1"]=>
    int(3)
    ["RGB16_565"]=>
    int(4)
    ["RGB30"]=>
    int(5)%A
  }
  ["__value"]=>
  int(0)
}
Cairo\Surface\Image::getFormat() expects exactly 0 arguments, 1 given