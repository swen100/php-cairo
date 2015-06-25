--TEST--
Cairo\Matrix object clone handler;
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
use Cairo\Matrix;

$matrix = new Matrix(5);
$copy = clone $matrix;
$copy->xx = 9;

var_dump($matrix->xx);
var_dump($copy->xx);

class testing extends Matrix {}

$testing = new testing(6);
$copy = clone $testing;
var_dump(get_class($copy));
var_dump($copy->xx);

?>
--EXPECT--
float(5)
float(9)
string(7) "testing"
float(6)