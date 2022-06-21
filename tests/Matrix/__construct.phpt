--TEST--
Cairo\Matrix->__construct()
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

$matrix = new Matrix();
var_dump($matrix);

/* Wrong number args - can only have too many, any number between 0 and 6 is fine */
try {
    new Matrix(1, 1, 1, 1, 1, 1, 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Matrix(array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Matrix(1, array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Matrix(1, 1, array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    new Matrix(1, 1, 1, array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 5 */
try {
    new Matrix(1, 1, 1, 1, array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 6 */
try {
    new Matrix(1, 1, 1, 1, 1, array());
    trigger_error('We should bomb here');
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
Cairo\Matrix::__construct() expects at most 6 arguments, 7 given
Cairo\Matrix::__construct(): Argument #1 ($xx) must be of type float, array given
Cairo\Matrix::__construct(): Argument #2 ($yx) must be of type float, array given
Cairo\Matrix::__construct(): Argument #3 ($xy) must be of type float, array given
Cairo\Matrix::__construct(): Argument #4 ($yy) must be of type float, array given
Cairo\Matrix::__construct(): Argument #5 ($x0) must be of type float, array given
Cairo\Matrix::__construct(): Argument #6 ($y0) must be of type float, array given
