--TEST--
Cairo\ScaledFont->getTextExtents() method
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
$matrix1 = new Cairo\Matrix(1,1,1);
$matrix2 = new Cairo\Matrix(2,2,2);
$fontoptions = new Cairo\FontOptions();

$scaled = new Cairo\ScaledFont($fontface, $matrix1, $matrix2, $fontoptions);
var_dump($scaled);

var_dump($scaled->getTextExtents('foobar'));

/* Wrong number args 1 */
try {
    $scaled->getTextExtents();
    trigger_error('getTextExtents requires one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 1 */
try {
    $scaled->getTextExtents('foo', 1);
    trigger_error('getTextExtents requires only one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $scaled->getTextExtents([]);
    trigger_error('getTextExtents requires one arg');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
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
Cairo\ScaledFont::getTextExtents() expects exactly 1 argument, 0 given
Cairo\ScaledFont::getTextExtents() expects exactly 1 argument, 2 given
Cairo\ScaledFont::getTextExtents(): Argument #1 ($text) must be of type string, array given
