--TEST--
Cairo\Surface\Pdf->addOutline() method
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
$name = "Link";
$linkAttr = "uri='https://cairographics.org'";
$flag = \Cairo\Surface\Pdf\OutlineFlags::BOLD;

$target = $surface->addOutline(\Cairo\Surface\Pdf\Outline::ROOT, $name, $linkAttr, $flag);
var_dump($target);

$newTarget = $surface->addOutline($target, $name, $linkAttr, $flag);
var_dump($newTarget);

/* invalid arg */
try {
    $surface->addOutline($target, $name, $linkAttr, 999);
    trigger_error('We should bomb here 1');
} catch (ValueError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* invalid arg */
try {
    var_dump( $surface->addOutline($target, "filename", "file='document.pdf' page=16 pos=[25 40]", $flag) );
    trigger_error('We should bomb here 1');
} catch (Cairo\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 0 */
try {
    $surface->addOutline();
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 1 */
try {
    $surface->addOutline($target);
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 2 */
try {
    $surface->addOutline($target, $name);
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong number args 3 */
try {
    $surface->addOutline($target, $name, $linkAttr);
    trigger_error('We should bomb here');
} catch (ArgumentCountError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 1 */
try {
    $surface->addOutline([], $name, $linkAttr, $flag);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 2 */
try {
    $surface->addOutline($target, [], $linkAttr, $flag);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 3 */
try {
    $surface->addOutline($target, $name, [], $flag);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

/* Wrong arg type 4 */
try {
    $surface->addOutline($target, $name, $linkAttr, []);
    trigger_error('We should bomb here');
} catch (TypeError $e) {
    echo $e->getMessage(), PHP_EOL;
}

?>
--EXPECTF--
object(Cairo\Surface\Pdf)#%d (0) {
}
int(1)
int(2)
Cairo\Surface\Pdf::addOutline(): Argument #4 ($outline_flag) is not a valid Cairo\Surface\Pdf\OutlineFlags constant.
invalid tag name, attributes, or nesting
Cairo\Surface\Pdf::addOutline() expects exactly 4 arguments, 0 given
Cairo\Surface\Pdf::addOutline() expects exactly 4 arguments, 1 given
Cairo\Surface\Pdf::addOutline() expects exactly 4 arguments, 2 given
Cairo\Surface\Pdf::addOutline() expects exactly 4 arguments, 3 given
Cairo\Surface\Pdf::addOutline(): Argument #1 ($parent_id) must be of type int, array given
Cairo\Surface\Pdf::addOutline(): Argument #2 ($name) must be of type string, array given
Cairo\Surface\Pdf::addOutline(): Argument #3 ($link_attribs) must be of type string, array given
Cairo\Surface\Pdf::addOutline(): Argument #4 ($outline_flag) must be of type int, array given