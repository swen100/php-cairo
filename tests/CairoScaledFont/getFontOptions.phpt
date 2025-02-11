--TEST--
Cairo\ScaledFont->getFontOptions() method
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

$options2 = $scaled->getFontOptions();
var_dump($options2);

var_dump($options2 == $fontoptions);

/* Wrong number args */
try {
    $scaled->getFontOptions('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
object(Cairo\FontOptions)#%d (0) {
}
bool(true)
Cairo\ScaledFont::getFontOptions() expects exactly 0 %s, 1 given