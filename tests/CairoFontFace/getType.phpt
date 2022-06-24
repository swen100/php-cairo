--TEST--
Cairo\FontFace->getType() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);

var_dump($fontface->getType());

try {
    $fontface->getType('foo');
} catch (TypeError $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\FontType)#%d (2) {
  ["__elements"]=>
  array(5) {
    ["TOY"]=>
    int(0)
    ["FT"]=>
    int(1)
    ["WIN32"]=>
    int(2)
    ["QUARTZ"]=>
    int(3)
    ["USER"]=>
    int(4)
  }
  ["__value"]=>
  int(0)
}
Cairo\FontFace::getType() expects exactly 0 arguments, 1 given