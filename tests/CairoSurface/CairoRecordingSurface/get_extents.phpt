--TEST--
new Cairo\Surface\Recording [getExtents() method ]
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
if (!in_array('RECORDING', Cairo::availableSurfaces())) {
    die('skip - RECORDING surface not available');
}
?>
--FILE--
<?php
$surface = new Cairo\Surface\Recording(\Cairo\Surface\Content::COLOR_ALPHA);
var_dump($surface);
var_dump($surface->getExtents());

$extents = ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400];
$surface2 = new Cairo\Surface\Recording(\Cairo\Surface\Content::COLOR_ALPHA, $extents);
var_dump($surface2->getExtents());

/* Wrong number args - 1 */
try {
    $surface2->getExtents(1);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Recording)#%d (0) {
}
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(0)
  ["y"]=>
  int(0)
  ["width"]=>
  int(0)
  ["height"]=>
  int(0)
}
object(Cairo\Rectangle)#%d (4) {
  ["x"]=>
  int(0)
  ["y"]=>
  int(0)
  ["width"]=>
  int(400)
  ["height"]=>
  int(400)
}
Cairo\Surface\Recording::getExtents() expects exactly 0 arguments, 1 given
