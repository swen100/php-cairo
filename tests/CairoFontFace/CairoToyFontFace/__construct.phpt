--TEST--
Cairo\FontFace\Toy::__construct() method
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
// Test with all parameters
$c = new Cairo\FontFace\Toy("sans-serif", Cairo\FontSlant::NORMAL, Cairo\FontWeight::NORMAL);
var_dump($c);

// Test with 1 param
$c = new Cairo\FontFace\Toy("sans-serif");
var_dump($c);

// test with 2 params
$c = new Cairo\FontFace\Toy("sans-serif", Cairo\FontSlant::NORMAL);
var_dump($c);

// test with 3 params, 1 null
$c = new Cairo\FontFace\Toy("sans-serif", null, Cairo\FontWeight::NORMAL);
var_dump($c);

// We shouldn't accept 0 args
try {
    $c = new Cairo\FontFace\Toy();
} catch (TypeError $e) {
    var_dump($e->getMessage());
}
var_dump($c);

// Test with 1 param
$c = new Cairo\FontFace\Toy("NotARealFont");
var_dump($c);

// Test with a silly param
try {
    $c = new Cairo\FontFace\Toy([]);
} catch (TypeError $e) {
    var_dump($e->getMessage());
}
var_dump($c);


/* Wrong arg type 2 */
try {
    $c = new Cairo\FontFace\Toy("sans-serif", []);
    trigger_error('selectFontFace requires an int font slant');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    $c = new Cairo\FontFace\Toy("sans-serif", Cairo\FontSlant::NORMAL, []);
    trigger_error('selectFontFace requires an int font weight');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\FontFace\Toy)#%d (0) {
}
object(Cairo\FontFace\Toy)#%d (0) {
}
string(70) "Cairo\FontFace\Toy::__construct() expects at least 1 argument, 0 given"
object(Cairo\FontFace\Toy)#2 (0) {
}
object(Cairo\FontFace\Toy)#1 (0) {
}
string(92) "Cairo\FontFace\Toy::__construct(): Argument #1 ($family) must be of type string, array given"
object(Cairo\FontFace\Toy)#1 (0) {
}
Cairo\FontFace\Toy::__construct(): Argument #2 ($slant) must be of type ?int, array given
Cairo\FontFace\Toy::__construct(): Argument #3 ($weight) must be of type ?int, array given