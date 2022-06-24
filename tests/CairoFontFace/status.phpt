--TEST--
Cairo\FontFace->status() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
include(dirname(__FILE__) . '/create_toyfont.inc');
var_dump($fontface);

$status = $fontface->getStatus();
var_dump($status);

var_dump($status == Cairo\Status::SUCCESS);

/* Wrong number args */
try {
    $fontface->getStatus('foo');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}
?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\Status)#%d (2) {
  ["__elements"]=>
  array(44) {
    ["SUCCESS"]=>
    int(0)
    ["NO_MEMORY"]=>
    int(1)
    ["INVALID_RESTORE"]=>
    int(2)
    ["INVALID_POP_GROUP"]=>
    int(3)
    ["NO_CURRENT_POINT"]=>
    int(4)
    ["INVALID_MATRIX"]=>
    int(5)
    ["INVALID_STATUS"]=>
    int(6)
    ["NULL_POINTER"]=>
    int(7)
    ["INVALID_STRING"]=>
    int(8)
    ["INVALID_PATH_DATA"]=>
    int(9)
    ["READ_ERROR"]=>
    int(10)
    ["WRITE_ERROR"]=>
    int(11)
    ["SURFACE_FINISHED"]=>
    int(12)
    ["SURFACE_TYPE_MISMATCH"]=>
    int(13)
    ["PATTERN_TYPE_MISMATCH"]=>
    int(14)
    ["INVALID_CONTENT"]=>
    int(15)
    ["INVALID_FORMAT"]=>
    int(16)
    ["INVALID_VISUAL"]=>
    int(17)
    ["FILE_NOT_FOUND"]=>
    int(18)
    ["INVALID_DASH"]=>
    int(19)
    ["INVALID_DSC_COMMENT"]=>
    int(20)
    ["INVALID_INDEX"]=>
    int(21)
    ["CLIP_NOT_REPRESENTABLE"]=>
    int(22)
    ["TEMP_FILE_ERROR"]=>
    int(23)
    ["INVALID_STRIDE"]=>
    int(24)
    ["FONT_TYPE_MISMATCH"]=>
    int(25)
    ["USER_FONT_IMMUTABLE"]=>
    int(26)
    ["USER_FONT_ERROR"]=>
    int(27)
    ["NEGATIVE_COUNT"]=>
    int(28)
    ["INVALID_CLUSTERS"]=>
    int(29)
    ["INVALID_SLANT"]=>
    int(30)
    ["INVALID_WEIGHT"]=>
    int(31)
    ["INVALID_SIZE"]=>
    int(32)
    ["USER_FONT_NOT_IMPLEMENTED"]=>
    int(33)
    ["DEVICE_TYPE_MISMATCH"]=>
    int(34)
    ["DEVICE_ERROR"]=>
    int(35)
    ["INVALID_MESH_CONSTRUCTION"]=>
    int(36)
    ["DEVICE_FINISHED"]=>
    int(37)
    ["LAST_STATUS"]=>
    int(43)
    ["JBIG2_GLOBAL_MISSING"]=>
    int(38)
    ["WIN32_GDI_ERROR"]=>
    int(41)
    ["FREETYPE_ERROR"]=>
    int(40)
    ["PNG_ERROR"]=>
    int(39)
    ["TAG_ERROR"]=>
    int(42)
  }
  ["__value"]=>
  int(0)
}
bool(true)
Cairo\FontFace::getStatus() expects exactly 0 arguments, 1 given