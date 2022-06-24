--TEST--
Cairo\Surface->getContent() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getContent());

/* Wrong number args */
try {
    $surface->getContent('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Content)#%d (2) {
  ["__elements"]=>
  array(3) {
    ["COLOR"]=>
    int(4096)
    ["ALPHA"]=>
    int(8192)
    ["COLOR_ALPHA"]=>
    int(12288)
  }
  ["__value"]=>
  int(12288)
}
Cairo\Surface::getContent() expects exactly 0 arguments, 1 given