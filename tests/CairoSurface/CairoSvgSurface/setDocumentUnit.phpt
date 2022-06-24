--TEST--
Cairo\Surface\Svg::setDocumentUnit() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('SVG', Cairo::availableSurfaces())) {
    die('skip - SVG surface not available');
}
if (!method_exists('Cairo\Surface\Svg', 'getDocumentUnit')) {
    die('skip - Cairo\Surface\Svg->setDocumentUnit not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Svg(NULL, 50, 50);

$surface->setDocumentUnit(6);
var_dump($surface->getDocumentUnit());


/* Wrong arg value */
try {
    $surface->setDocumentUnit(99);
} catch (ValueError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type */
try {
    $surface->setDocumentUnit('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args */
try {
    $surface->setDocumentUnit('foo', 'bar');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
int(6)
Cairo\Surface\Svg::setDocumentUnit(): Argument #1 ($unit) is not a valid Cairo\Surface\Svg\Unit constant.
Cairo\Surface\Svg::setDocumentUnit(): Argument #1 ($unit) must be of type int, string given
Cairo\Surface\Svg::setDocumentUnit() expects exactly 1 argument, 2 given