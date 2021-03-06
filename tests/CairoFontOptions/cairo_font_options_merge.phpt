--TEST--
cairo_font_options_merge() function
--SKIPIF--
<?php
if(!extension_loaded('cairo')) die('skip - Cairo extension not available');
?>
--FILE--
<?php
$options = cairo_font_options_create();
var_dump($options);

$options2 = cairo_font_options_create();

cairo_font_options_merge($options, $options2);

// bad type hint is an E_RECOVERABLE_ERROR, so let's hook a handler
function bad_class($errno, $errstr) {
	echo 'CAUGHT ERROR: ' . $errstr, PHP_EOL;
}
set_error_handler('bad_class', E_RECOVERABLE_ERROR);

// check number of args - should accept ONLY 2
cairo_font_options_merge();
cairo_font_options_merge($options);
cairo_font_options_merge($options, $options2, 1);

// check arg types, should be fontoptions objects
cairo_font_options_merge(1, $options2);
cairo_font_options_merge($options, 1);
?>
--EXPECTF--
object(CairoFontOptions)#%d (0) {
}

Warning: cairo_font_options_merge() expects exactly 2 parameters, 0 given in %s on line %d

Warning: cairo_font_options_merge() expects exactly 2 parameters, 1 given in %s on line %d

Warning: cairo_font_options_merge() expects exactly 2 parameters, 3 given in %s on line %d
CAUGHT ERROR: Argument 1 passed to cairo_font_options_merge() must be an instance of CairoFontOptions, integer given

Warning: cairo_font_options_merge() expects parameter 1 to be CairoFontOptions, integer given in %s on line %d
CAUGHT ERROR: Argument 2 passed to cairo_font_options_merge() must be an instance of CairoFontOptions, integer given

Warning: cairo_font_options_merge() expects parameter 2 to be CairoFontOptions, integer given in %s on line %d