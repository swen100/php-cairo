--TEST--
new Cairo\Surface\Recording [inkExtents() method ]
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
var_dump($surface->inkExtents());

$extents = ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400];
$surface2 = new Cairo\Surface\Recording(\Cairo\Surface\Content::COLOR_ALPHA, $extents);
var_dump($surface2->inkExtents());

/* Wrong number args - 1 */
try {
    $surface2->inkExtents(1);
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Recording)#%d (0) {
}
array(4) {
  ["x"]=>
  float(0)
  ["y"]=>
  float(0)
  ["width"]=>
  float(0)
  ["height"]=>
  float(0)
}
array(4) {
  ["x"]=>
  float(0)
  ["y"]=>
  float(0)
  ["width"]=>
  float(0)
  ["height"]=>
  float(0)
}
Cairo\Surface\Recording::inkExtents() expects exactly 0 arguments, 1 given
