--TEST--
Cairo\Matrix::multiply()
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

$matrix1 = new Matrix(0.1, 0, 0, 0.1);
$matrix2 = new Matrix(0.1);

var_dump(Matrix::multiply($matrix1, $matrix2));

/* Wrong number args */
try {
    Matrix::multiply();
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2*/
try {
    Matrix::multiply(1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3*/
try {
    Matrix::multiply(1, 1, 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1*/
try {
    Matrix::multiply(1, $matrix2);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2*/
try {
    Matrix::multiply($matrix1, 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(%f)
  ["yx"]=>
  float(0)
  ["xy"]=>
  float(0)
  ["yy"]=>
  float(0.1)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
Cairo\Matrix::multiply() expects exactly 2 arguments, 0 given
Cairo\Matrix::multiply() expects exactly 2 arguments, 1 given
Cairo\Matrix::multiply() expects exactly 2 arguments, 3 given
Cairo\Matrix::multiply(): Argument #1 ($matrix1) must be of type Cairo\Matrix, int given
Cairo\Matrix::multiply(): Argument #2 ($matrix2) must be of type Cairo\Matrix, int given