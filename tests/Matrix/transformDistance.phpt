--TEST--
Cairo\Matrix->transformDistance()
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

$matrix = new Matrix(1, 2, 3, 1);
var_dump($matrix);

var_dump($matrix->transformDistance(1.0, 1.0));

/* Wrong number args */
try {
    $matrix->transformDistance();
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $matrix->transformDistance(1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $matrix->transformDistance(1, 1, 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $matrix->transformDistance(array(), 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $matrix->transformDistance(1, array());
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
  float(2)
  ["xy"]=>
  float(3)
  ["yy"]=>
  float(1)
  ["x0"]=>
  float(0)
  ["y0"]=>
  float(0)
}
array(2) {
  ["x"]=>
  float(4)
  ["y"]=>
  float(3)
}
Cairo\Matrix::transformDistance() expects exactly 2 arguments, 0 given
Cairo\Matrix::transformDistance() expects exactly 2 arguments, 1 given
Cairo\Matrix::transformDistance() expects exactly 2 arguments, 3 given
Cairo\Matrix::transformDistance(): Argument #1 ($dx) must be of type float, array given
Cairo\Matrix::transformDistance(): Argument #2 ($dy) must be of type float, array given