--TEST--
cairo extension class listing
--EXTENSIONS--
eos_datastructures
--SKIPIF--
<?php
include __DIR__ . '/skipif.inc';
?>
--FILE--
<?php
$ext = new ReflectionExtension('cairo');
var_dump($ext->getClassNames());
?>
--EXPECT--
array(53) {
  [0]=>
  string(5) "Cairo"
  [1]=>
  string(13) "Cairo\Pattern"
  [2]=>
  string(19) "Cairo\Pattern\Solid"
  [3]=>
  string(22) "Cairo\Pattern\Gradient"
  [4]=>
  string(29) "Cairo\Pattern\Gradient\Radial"
  [5]=>
  string(29) "Cairo\Pattern\Gradient\Linear"
  [6]=>
  string(21) "Cairo\Pattern\Surface"
  [7]=>
  string(18) "Cairo\Pattern\Mesh"
  [8]=>
  string(26) "Cairo\Pattern\RasterSource"
  [9]=>
  string(18) "Cairo\Pattern\Type"
  [10]=>
  string(12) "Cairo\Extend"
  [11]=>
  string(12) "Cairo\Filter"
  [12]=>
  string(15) "Cairo\Rectangle"
  [13]=>
  string(12) "Cairo\Matrix"
  [14]=>
  string(15) "Cairo\Exception"
  [15]=>
  string(12) "Cairo\Status"
  [16]=>
  string(12) "Cairo\Region"
  [17]=>
  string(20) "Cairo\Region\Overlap"
  [18]=>
  string(14) "Cairo\FontFace"
  [19]=>
  string(14) "Cairo\FontType"
  [20]=>
  string(18) "Cairo\FontFace\Toy"
  [21]=>
  string(15) "Cairo\FontSlant"
  [22]=>
  string(16) "Cairo\FontWeight"
  [23]=>
  string(17) "Cairo\FontOptions"
  [24]=>
  string(15) "Cairo\Antialias"
  [25]=>
  string(19) "Cairo\SubPixelOrder"
  [26]=>
  string(15) "Cairo\HintStyle"
  [27]=>
  string(17) "Cairo\HintMetrics"
  [28]=>
  string(16) "Cairo\ScaledFont"
  [29]=>
  string(17) "Cairo\FontFace\Ft"
  [30]=>
  string(13) "Cairo\Surface"
  [31]=>
  string(21) "Cairo\Surface\Content"
  [32]=>
  string(18) "Cairo\Surface\Type"
  [33]=>
  string(19) "Cairo\Surface\Image"
  [34]=>
  string(25) "Cairo\Surface\ImageFormat"
  [35]=>
  string(24) "Cairo\Surface\SubSurface"
  [36]=>
  string(23) "Cairo\Surface\Recording"
  [37]=>
  string(17) "Cairo\Surface\Pdf"
  [38]=>
  string(25) "Cairo\Surface\Pdf\Version"
  [39]=>
  string(25) "Cairo\Surface\Pdf\Outline"
  [40]=>
  string(30) "Cairo\Surface\Pdf\OutlineFlags"
  [41]=>
  string(26) "Cairo\Surface\Pdf\Metadata"
  [42]=>
  string(17) "Cairo\Surface\Svg"
  [43]=>
  string(25) "Cairo\Surface\Svg\Version"
  [44]=>
  string(22) "Cairo\Surface\Svg\Unit"
  [45]=>
  string(16) "Cairo\Surface\Ps"
  [46]=>
  string(22) "Cairo\Surface\Ps\Level"
  [47]=>
  string(10) "Cairo\Path"
  [48]=>
  string(13) "Cairo\Context"
  [49]=>
  string(14) "Cairo\FillRule"
  [50]=>
  string(13) "Cairo\LineCap"
  [51]=>
  string(14) "Cairo\LineJoin"
  [52]=>
  string(14) "Cairo\Operator"
}