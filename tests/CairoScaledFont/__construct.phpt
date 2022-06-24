--TEST--
new Cairo\ScaledFont [ __construct() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);
$matrix1 = new Cairo\Matrix(1, 0, 1, 1);
$matrix2 = new Cairo\Matrix(2, 0, 2, 2);
$fontoptions = new Cairo\FontOptions();

$scaled = new Cairo\ScaledFont($fontface, $matrix1, $matrix2, $fontoptions);
var_dump($scaled);

/* Wrong number args - 1 */
try {
    new Cairo\ScaledFont();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 2 */
try {
    new Cairo\ScaledFont($fontface);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 3 */
try {
    new Cairo\ScaledFont($fontface, $matrix1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 4 */
try {
    new Cairo\ScaledFont($fontface, $matrix1, $matrix2);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args - 5 */
try {
    new Cairo\ScaledFont($fontface, $matrix1, $matrix2, $fontoptions, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong Arg type 1 */
try {
    new Cairo\ScaledFont(array(), $matrix1, $matrix2, $fontoptions);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong Arg type 2 */
try {
    new Cairo\ScaledFont($fontface, [], $matrix2, $fontoptions);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong Arg type 3 */
try {
    new Cairo\ScaledFont($fontface, $matrix1, [], $fontoptions);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong Arg type 4 */
try {
    new Cairo\ScaledFont($fontface, $matrix1, $matrix2, []);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\ScaledFont)#%d (0) {
}
Cairo\ScaledFont::__construct() expects exactly 4 arguments, 0 given
Cairo\ScaledFont::__construct() expects exactly 4 arguments, 1 given
Cairo\ScaledFont::__construct() expects exactly 4 arguments, 2 given
Cairo\ScaledFont::__construct() expects exactly 4 arguments, 3 given
Cairo\ScaledFont::__construct() expects exactly 4 arguments, 5 given
Cairo\ScaledFont::__construct(): Argument #1 ($font_face) must be of type Cairo\FontFace, array given
Cairo\ScaledFont::__construct(): Argument #2 ($matrix) must be of type Cairo\Matrix, array given
Cairo\ScaledFont::__construct(): Argument #3 ($ctm) must be of type Cairo\Matrix, array given
Cairo\ScaledFont::__construct(): Argument #4 ($options) must be of type Cairo\FontOptions, array given