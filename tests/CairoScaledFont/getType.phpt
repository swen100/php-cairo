--TEST--
Cairo\ScaledFont->getType() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);
$matrix1 = new Cairo\Matrix(1, 0, 1, 1);
$matrix2 = new Cairo\Matrix(2, 0, 2, 2);
$fontoptions = new Cairo\FontOptions();

$scaled = new Cairo\ScaledFont($fontface, $matrix1, $matrix2, $fontoptions);
var_dump($scaled);

var_dump($scaled->getType());

try {
    $scaled->getType('foo');
    trigger_error('Cairo\ScaledFont->getType requires no arguments');
} catch (TypeError $e) {
    echo $e->getMessage();
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
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
  int(1)
}
Cairo\ScaledFont::getType() expects exactly 0 arguments, 1 given
