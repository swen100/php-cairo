--TEST--
Cairo\Pdf class constants
--SKIPIF--
<?php
if (!extension_loaded('cairo')) {
    die('skip - Cairo extension not available');
}
?>
--FILE--
<?php

if (\Cairo\VERSION >= 11600) {
    $constants = [
        '\Cairo\Pdf\Outline::ROOT',
        
        '\Cairo\Pdf\OutlineFlags::OPEN',
        '\Cairo\Pdf\OutlineFlags::BOLD',
        '\Cairo\Pdf\OutlineFlags::ITALIC',
        
        '\Cairo\Pdf\Metadata::TITLE',
        '\Cairo\Pdf\Metadata::AUTHOR',
        '\Cairo\Pdf\Metadata::SUBJECT',
        '\Cairo\Pdf\Metadata::KEYWORDS',
        '\Cairo\Pdf\Metadata::CREATOR',
        '\Cairo\Pdf\Metadata::CREATE_DATE',
        '\Cairo\Pdf\Metadata::MOD_DATE',
        
        '\Cairo\Pdf\Version::1_4',
        '\Cairo\Pdf\Version::1_5'
    ];
} else {
    $constants = [];
}

$error = false;
foreach ($constants as $constant) {
    if (!defined($constant)) {
        $error = true;
        echo 'Missing Constant: ' . $constant . "\n";
    }
}

if (!$error) {
    echo "No missing constants, checked " . sizeof($constants) . "!\n";
}
echo "Done\n";
?>
--EXPECTF--
No missing constants, checked %d!
Done