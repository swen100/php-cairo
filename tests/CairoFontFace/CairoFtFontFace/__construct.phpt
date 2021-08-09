--TEST--
CairoFtFontFace::__construct()
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
if(!class_exists('\\Cairo\FontFace\\Ft')) die('skip - \\Cairo\FontFace\\ not available');
?>
--FILE--
<?php
$fontFile = dirname(__FILE__) . "/Vera.ttf";

// Test with 1 param
$c = new Cairo\FontFace\Ft($fontFile);
var_dump($c);

// test with 2 params
$c = new Cairo\FontFace\Ft($fontFile, 0);
var_dump($c);

// We shouldn't accept 0 args
try {
    $c = new Cairo\FontFace\Ft();
} catch (TypeError $e) {
    var_dump($e->getMessage());
}
var_dump($c);

// Test with 1 param
try {
    $c = new Cairo\FontFace\Ft("NotARealFont");
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c);

// Test with a silly param
try {
    $c = new Cairo\FontFace\Ft(array());
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c); 

// Test with a broken font
try {
    $c = new Cairo\FontFace\Ft(dirname(__FILE__) . '/broken.ttf');
} catch (Cairo\Exception $e) {
    var_dump($e->getMessage());
}
var_dump($c);
?>
--EXPECTF--
object(Cairo\FontFace\Ft)#1 (0) {
}
object(Cairo\FontFace\Ft)#2 (0) {
}
string(69) "Cairo\FontFace\Ft::__construct() expects at least 1 argument, 0 given"
object(Cairo\FontFace\Ft)#2 (0) {
}

Warning: Cairo\FontFace\Ft::__construct(NotARealFont): Failed to open stream: No such file or directory in %s__construct.php on line %s
object(Cairo\FontFace\Ft)#1 (0) {
}
string(88) "Cairo\FontFace\Ft::__construct() expects parameter 1 to be a string or a stream resource"
object(Cairo\FontFace\Ft)#1 (0) {
}
string(89) "Cairo\FontFace\Ft::__construct(): An error occurred opening the file cannot open resource"
object(Cairo\FontFace\Ft)#1 (0) {
}
