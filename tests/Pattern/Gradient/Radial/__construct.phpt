--TEST--
Cairo\Pattern\Gradient\Radial->__construct()
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/../../../skipif.inc';
?>
--FILE--
<?php
use Cairo\Pattern\Gradient\Radial;

$pattern = new Radial(0.5, 0.5, 0.25, 0.5, 0.5, 0.5);
var_dump($pattern);

/* Wrong number args - requires 6 */
try {
    new Radial();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1, 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 6 */
try {
    new Radial(1, 1, 1, 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    new Radial(array(), 1, 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    new Radial(1, array(), 1, 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    new Radial(1, 1, array(), 1, 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    new Radial(1, 1, 1, array(), 1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 5 */
try {
    new Radial(1, 1, 1, 1, array(), 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 6 */
try {
    new Radial(1, 1, 1, 1, 1, array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Pattern\Gradient\Radial)#%d (0) {
}
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 0 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 1 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 2 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 3 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 4 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 5 given
Cairo\Pattern\Gradient\Radial::__construct() expects exactly 6 arguments, 7 given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #1 ($x0) must be of type float, array given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #2 ($y0) must be of type float, array given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #3 ($r0) must be of type float, array given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #4 ($x1) must be of type float, array given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #5 ($y1) must be of type float, array given
Cairo\Pattern\Gradient\Radial::__construct(): Argument #6 ($r1) must be of type float, array given