--TEST--
Cairo\Surface->getType() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$surface = new Cairo\Surface\Image(Cairo\Surface\ImageFormat::ARGB32, 50, 50);
var_dump($surface);

var_dump($surface->getType());

/* Wrong number args */
try {
    $surface->getType('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\Surface\Image)#%d (0) {
}
object(Cairo\Surface\Type)#%d (2) {
  ["__elements"]=>
  array(25) {
    ["IMAGE"]=>
    int(0)
    ["PDF"]=>
    int(1)
    ["PS"]=>
    int(2)
    ["XLIB"]=>
    int(3)
    ["XCB"]=>
    int(4)
    ["GLITZ"]=>
    int(5)
    ["QUARTZ"]=>
    int(6)
    ["WIN32"]=>
    int(7)
    ["BEOS"]=>
    int(8)
    ["DIRECTFB"]=>
    int(9)
    ["SVG"]=>
    int(10)
    ["OS2"]=>
    int(11)
    ["WIN32_PRINTING"]=>
    int(12)
    ["QUARTZ_IMAGE"]=>
    int(13)
    ["SCRIPT"]=>
    int(14)
    ["QT"]=>
    int(15)
    ["RECORDING"]=>
    int(16)
    ["VG"]=>
    int(17)
    ["GL"]=>
    int(18)
    ["DRM"]=>
    int(19)
    ["TEE"]=>
    int(20)
    ["XML"]=>
    int(21)
    ["SKIA"]=>
    int(22)
    ["SUBSURFACE"]=>
    int(23)
    ["COGL"]=>
    int(24)
  }
  ["__value"]=>
  int(0)
}
Cairo\Surface::getType() expects exactly 0 arguments, 1 given