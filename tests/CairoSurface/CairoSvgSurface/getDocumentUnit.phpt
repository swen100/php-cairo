--TEST--
Cairo\Surface\Svg::getDocumentUnit() method
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('SVG', Cairo::availableSurfaces())) {
    die('skip - SVG surface not available');
}
if (!method_exists('Cairo\Surface\Svg', 'getDocumentUnit')) {
    die('skip - Cairo\Surface\Svg->getDocumentUnit not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Svg(NULL, 50, 50);
var_dump($surface->getDocumentUnit());


/* Wrong number args */
try {
    $surface->getDocumentUnit('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
int(7)
Cairo\Surface\Svg::getDocumentUnit() expects exactly 0 arguments, 1 given