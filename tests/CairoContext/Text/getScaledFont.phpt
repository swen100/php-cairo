--TEST--
Cairo\Context->setScaledFont() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

$context = new Cairo\Context($surface);
var_dump($context);

var_dump($context->getScaledFont());

/* create scaled font with new font face, font options, matrix */
include(dirname(__FILE__) . '/create_toyfont.inc');
$matrix1 = new Cairo\Matrix(1,1,0,1);
$matrix2 = new Cairo\Matrix(2,2,0,2);
$fontoptions = new Cairo\FontOptions();

$scaled = new Cairo\ScaledFont($fontface, $matrix1, $matrix2, $fontoptions);

$context->setScaledFont($scaled);
var_dump($scaled1 = $context->getScaledFont());

var_dump($scaled === $scaled1);

try {
    $context->getScaledFont('foo');
} catch (Error $e) {
    echo $e->getMessage(), PHP_EOL;
}

die; // DO NOT REMOVE THIS - fixes issue in 5.3 with GC giving bogus memleak reports
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Context)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
bool(true)
Cairo\Context::getScaledFont() expects exactly 0 arguments, 1 given