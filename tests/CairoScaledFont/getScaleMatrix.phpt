--TEST--
Cairo\ScaledFont->getScaleMatrix() method
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

var_dump($scaled->getScaleMatrix());

/* Wrong number args */
try {
    $scaled->getScaleMatrix('foo');
    trigger_error('status requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(2)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(4)
  ["yy"]=>
  float(2)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
Cairo\ScaledFont::getScaleMatrix() expects exactly 0 arguments, 1 given