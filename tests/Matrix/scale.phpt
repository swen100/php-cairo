--TEST--
Cairo\Matrix->scale()
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

$matrix = new Matrix(1, 1, 1, 1, 1, 1);

$matrix->scale(2, 5);
var_dump($matrix);

/* Wrong number args */
try {
    $matrix->scale();
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $matrix->scale(1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $matrix->scale(1, 1, 1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $matrix->scale([], 1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $matrix->scale(1, []);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(2)
  ["yx"]=>
  float(2)
  ["xy"]=>
  float(5)
  ["yy"]=>
  float(5)
  ["x0"]=>
  float(1)
  ["y0"]=>
  float(1)
}
Cairo\Matrix::scale() expects exactly 2 arguments, 0 given
Cairo\Matrix::scale() expects exactly 2 arguments, 1 given
Cairo\Matrix::scale() expects exactly 2 arguments, 3 given
Cairo\Matrix::scale(): Argument #1 ($sx) must be of type float, array given
Cairo\Matrix::scale(): Argument #2 ($sy) must be of type float, array given