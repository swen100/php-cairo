--TEST--
Cairo\Surface\Pdf->restrictToVersion() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('PDF', Cairo::availableSurfaces())) {
    die('skip - PDF surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Pdf(NULL, 50, 50);
var_dump($surface);

$surface->restrictToVersion(Cairo\Surface\Pdf\Version::VERSION_1_5);

/* invalid arg */
try {
    $surface->restrictToVersion(999);
} catch (ValueError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $surface->restrictToVersion();
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->restrictToVersion(1, 1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->restrictToVersion(array());
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
Cairo\Surface\Pdf::restrictToVersion(): Argument #1 ($version) is not a valid Cairo\Surface\Pdf\Version constant.
Cairo\Surface\Pdf::restrictToVersion() expects exactly 1 argument, 0 given
Cairo\Surface\Pdf::restrictToVersion() expects exactly 1 argument, 2 given
Cairo\Surface\Pdf::restrictToVersion(): Argument #1 ($version) must be of type int, array given