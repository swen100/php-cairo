--TEST--
Cairo\Matrix->transformPoint()
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

$matrix = new Matrix(1, 0, 0, 1);
var_dump($matrix);

var_dump($matrix->transformPoint(1.0, 1.0));

/* Wrong number args */
try {
    $matrix->transformPoint();
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $matrix->transformPoint(1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $matrix->transformPoint(1, 1, 1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $matrix->transformPoint([], 1);
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $matrix->transformPoint(1, []);
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
array(2) {
  ["x"]=>
  float(1)
  ["y"]=>
  float(1)
}
Cairo\Matrix::transformPoint() expects exactly 2 arguments, 0 given
Cairo\Matrix::transformPoint() expects exactly 2 arguments, 1 given
Cairo\Matrix::transformPoint() expects exactly 2 arguments, 3 given
Cairo\Matrix::transformPoint(): Argument #1 ($dx) must be of type float, array given
Cairo\Matrix::transformPoint(): Argument #2 ($dy) must be of type float, array given