--TEST--
Cairo\Matrix->rotate()
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../skipif.inc';
?>
--FILE--
<?php
use Cairo\Matrix;
use TypeError as Exception;

$matrix = new Matrix(1, 0, 0 , 1);
var_dump($matrix);

$matrix->rotate(0.1);

/* Wrong number args */
try {
    $matrix->rotate();
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $matrix->rotate(1, 1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $matrix->rotate(array());
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(1)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(0)
  ["yy"]=>
  float(1)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
Cairo\Matrix::rotate() expects exactly 1 argument, 0 given
Cairo\Matrix::rotate() expects exactly 1 argument, 2 given
Cairo\Matrix::rotate(): Argument #1 ($radians) must be of type float, array given