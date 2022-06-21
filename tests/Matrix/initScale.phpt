--TEST--
Cairo\Matrix::initScale()
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

$matrix = Matrix::initScale(0.1, 0.1);
var_dump($matrix);

/* Wrong number args */
try {
    Matrix::initScale();
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    Matrix::initScale(1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    Matrix::initScale(1, 1, 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    Matrix::initScale(array(), 1);
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    Matrix::initScale(1, array());
    trigger_error('We should bomb here');
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Matrix)#%d (6) {
  ["xx"]=>
  float(0.1)
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
Cairo\Matrix::initScale() expects exactly 2 arguments, 0 given
Cairo\Matrix::initScale() expects exactly 2 arguments, 1 given
Cairo\Matrix::initScale() expects exactly 2 arguments, 3 given
Cairo\Matrix::initScale(): Argument #1 ($sx) must be of type float, array given
Cairo\Matrix::initScale(): Argument #2 ($sy) must be of type float, array given