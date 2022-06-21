--TEST--
Cairo\ScaledFont->extents() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
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

/* Wrong number args */
try {
    $scaled->getTextExtents();
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

try {
    var_dump($scaled->getTextExtents('foo'));
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
Cairo\ScaledFont::getTextExtents() expects exactly 1 argument, 0 given
array(6) {
  ["x_bearing"]=>
  float(%f)
  ["y_bearing"]=>
  float(%f)
  ["width"]=>
  float(%f)
  ["height"]=>
  float(%f)
  ["x_advance"]=>
  float(%f)
  ["y_advance"]=>
  float(%f)
}
