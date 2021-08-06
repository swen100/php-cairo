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
$matrix1 = new Cairo\Matrix(1);
$matrix2 = new Cairo\Matrix(1,1);
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
long(%d)
Cairo\ScaledFont::getType() expects exactly 0 parameters, 1 given
