/*
  +----------------------------------------------------------------------+
  | For PHP Version 8                                                    |
  +----------------------------------------------------------------------+
  | Copyright (c) 2015 Elizabeth M Smith                                 |
  +----------------------------------------------------------------------+
  | http://www.opensource.org/licenses/mit-license.php  MIT License      |
  | Also available in LICENSE                                            |
  +----------------------------------------------------------------------+
  | Authors: Elizabeth M Smith <auroraeosrose@gmail.com>                 |
  |          Swen Zanon <swen.zanon@geoglis.de>                          |
  +----------------------------------------------------------------------+
*/

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <cairo.h>
#include <php.h>
#include <zend_exceptions.h>

#include <ext/eos_datastructures/php_eos_datastructures_api.h>

#include "php_cairo.h"
#include "php_cairo_internal.h"

zend_class_entry *ce_cairo_fontoptions;
zend_class_entry *ce_cairo_subpixelorder;
zend_class_entry *ce_cairo_hintstyle;
zend_class_entry *ce_cairo_hintmetrics;
zend_class_entry *ce_cairo_antialias;

static zend_object_handlers cairo_font_options_object_handlers; 

//typedef struct _cairo_font_options_object {
//	cairo_font_options_t *font_options;
//        zend_object std;
//} cairo_font_options_object;

cairo_font_options_object *cairo_font_options_fetch_object(zend_object *object)
{
    return (cairo_font_options_object *) ((char*)(object) - XtOffsetOf(cairo_font_options_object, std));
}

static inline cairo_font_options_object *cairo_font_options_object_get(zval *zv)
{
	cairo_font_options_object *object = Z_CAIRO_FONT_OPTIONS_P(zv);
	if(object->font_options == NULL) {
		zend_throw_exception_ex(ce_cairo_exception, 0,
			"Internal font options object missing in %s, you must call parent::__construct in extended classes",
			ZSTR_VAL(Z_OBJCE_P(zv)->name));
		return NULL;
	}
	return object;
}

/* ----------------------------------------------------------------
    Cairo\FontOptions Object management
------------------------------------------------------------------*/

/* {{{ */
static void cairo_font_options_free_obj(zend_object *object)
{
    cairo_font_options_object *intern = cairo_font_options_fetch_object(object);

    if(!intern) {
            return;
    }

    if (intern->font_options) {
            cairo_font_options_destroy(intern->font_options);
    }
    intern->font_options = NULL;

    zend_object_std_dtor(&intern->std);
}

/* {{{ */
static zend_object* cairo_font_options_obj_ctor(zend_class_entry *ce, cairo_font_options_object **intern)
{
	cairo_font_options_object *object = ecalloc(1, sizeof(cairo_font_options_object) + zend_object_properties_size(ce));
        
        object->font_options = NULL;
        
	zend_object_std_init(&object->std, ce);
	object->std.handlers = &cairo_font_options_object_handlers;
	*intern = object;

	return &object->std;
}
/* }}} */

/* {{{ */
static zend_object* cairo_font_options_create_object(zend_class_entry *ce)
{
	cairo_font_options_object *font_options_obj = NULL;
	zend_object *return_value = cairo_font_options_obj_ctor(ce, &font_options_obj);

	object_properties_init(&(font_options_obj->std), ce);
	return return_value;
}
/* }}} */

/* ----------------------------------------------------------------
    Cairo\FontOptions C API
------------------------------------------------------------------*/

/* {{{ */
zend_class_entry * php_cairo_get_fontoptions_ce()
{
	return ce_cairo_fontoptions;
}
/* }}} */

/* {{{ */
cairo_font_options_t *cairo_font_options_object_get_font_options(zval *zv)
{
	cairo_font_options_object *font_options_object = Z_CAIRO_FONT_OPTIONS_P(zv);
	return font_options_object->font_options;
}
/* }}} */


/* ----------------------------------------------------------------
    Cairo\FontOptions Class API
------------------------------------------------------------------*/
/* {{{ proto void __contruct(void) 
       Creates a new \Cairo\FontOptions object with all options initialized to default values.*/
PHP_METHOD(CairoFontOptions, __construct) 
{
        cairo_font_options_object *font_options_object;

        ZEND_PARSE_PARAMETERS_NONE();

        font_options_object = Z_CAIRO_FONT_OPTIONS_P(getThis());
	if(!font_options_object) {
            return;
        }
    
        font_options_object->font_options = cairo_font_options_create();
        php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto void \Cairo\FontOptions::getStatus(void)
        Checks whether an error has previously occurred for this font options object.*/
PHP_METHOD(CairoFontOptions, getStatus) 
{
	cairo_font_options_object *font_options_object;
	
	ZEND_PARSE_PARAMETERS_NONE();

	font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
        object_init_ex(return_value, ce_cairo_status);
        php_eos_datastructures_set_enum_value(return_value, cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoFontOptions_fontoptions_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_OBJ_INFO(0, other, Cairo\\FontOptions, 0)
	//ZEND_ARG_INFO(0, other)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::merge(\Cairo\FontOptions other)
        Merges non-default options from other into options, replacing existing values.*/
PHP_METHOD(CairoFontOptions, merge)
{
	zval *other_zval = NULL;
	cairo_font_options_object *options_object, *other_object;
	
        ZEND_PARSE_PARAMETERS_START(1,1)
            Z_PARAM_OBJECT_OF_CLASS(other_zval, ce_cairo_fontoptions)
        ZEND_PARSE_PARAMETERS_END();
        
        options_object = cairo_font_options_object_get(getThis());
	if(!options_object) {
            return;
        }
        
	other_object = cairo_font_options_object_get(other_zval);
	if(!other_object) {
            return;
        }
        
	cairo_font_options_merge(options_object->font_options, other_object->font_options);
	php_cairo_throw_exception(cairo_font_options_status(options_object->font_options));
}
/* }}} */


/* {{{ proto long \Cairo\FontOptions::hash(void)
        Compute a hash for the font options object.*/
PHP_METHOD(CairoFontOptions, hash) 
{
	cairo_font_options_object *font_options_object;

        ZEND_PARSE_PARAMETERS_NONE();
        
	font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
	RETURN_LONG(cairo_font_options_hash(font_options_object->font_options));
}
/* }}} */


/* {{{ proto boolean \Cairo\FontOptions::equal(\Cairo\FontOptions other)
        Compares two font options objects for equality.*/
PHP_METHOD(CairoFontOptions, equal)
{
	zval *other_zval = NULL;
	cairo_font_options_object *options_object_a, *options_object_b;
	
        ZEND_PARSE_PARAMETERS_START(1,1)
            Z_PARAM_OBJECT_OF_CLASS(other_zval, ce_cairo_fontoptions)
        ZEND_PARSE_PARAMETERS_END();
        
        options_object_a = cairo_font_options_object_get(getThis());
	if(!options_object_a) {
            return;
        }
        
	options_object_b = cairo_font_options_object_get(other_zval);
	if(!options_object_b) {
            return;
        }
        
	RETURN_BOOL(cairo_font_options_equal(options_object_a->font_options, options_object_b->font_options));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoFontOptions_setAntialias_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, antialias)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::setAntialias(void)
        Sets the antialiasing mode for the font options object.*/
PHP_METHOD(CairoFontOptions, setAntialias) 
{
	zend_long antialias = CAIRO_ANTIALIAS_DEFAULT;
	cairo_font_options_object *font_options_object;
	zval *antialias_enum;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET|ZEND_PARSE_PARAMS_THROW,
		ZEND_NUM_ARGS(), "O", &antialias_enum, ce_cairo_antialias) == FAILURE) {
		if (zend_parse_parameters(ZEND_NUM_ARGS(), "|l", &antialias) == FAILURE) {
			return;
		} else {
			if(!php_eos_datastructures_check_value(ce_cairo_antialias, antialias)) {
				return;
			}
		}
	} else {
		antialias = php_eos_datastructures_get_enum_value(antialias_enum);
	}
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
                return;
        }
	
	cairo_font_options_set_antialias(font_options_object->font_options, antialias);
	php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto int \Cairo\FontOptions::getAntialias(void)
        Gets the antialiasing mode for the font options object.*/
PHP_METHOD(CairoFontOptions, getAntialias) 
{
	cairo_font_options_object *font_options_object;
	
        ZEND_PARSE_PARAMETERS_NONE();
        
	font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
        object_init_ex(return_value, ce_cairo_antialias);
        php_eos_datastructures_set_enum_value(return_value, cairo_font_options_get_antialias(font_options_object->font_options));
        
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoFontOptions_setSubpixelOrder_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, subpixel_order)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::setSubpixelOrder(void)
        Sets the subpixel order for the font options object.*/
PHP_METHOD(CairoFontOptions, setSubpixelOrder) 
{
	zend_long subpixel_order = 0;
	cairo_font_options_object *font_options_object;
	zval *subpixel_order_enum;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET|ZEND_PARSE_PARAMS_THROW,
		ZEND_NUM_ARGS(), "O", &subpixel_order_enum, ce_cairo_subpixelorder) == FAILURE) {
		if (zend_parse_parameters(ZEND_NUM_ARGS(), "|l", &subpixel_order) == FAILURE) {
			return;
		} else {
			if(!php_eos_datastructures_check_value(ce_cairo_subpixelorder, subpixel_order)) {
				return;
			}
		}
	} else {
		subpixel_order = php_eos_datastructures_get_enum_value(subpixel_order_enum);
	}
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
	cairo_font_options_set_subpixel_order(font_options_object->font_options, subpixel_order);
	php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto int \Cairo\FontOptions::getSubpixelOrder(void)
        Gets the subpixel order for the font options object.*/
PHP_METHOD(CairoFontOptions, getSubpixelOrder) 
{
	cairo_font_options_object *font_options_object;

	ZEND_PARSE_PARAMETERS_NONE();
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
        object_init_ex(return_value, ce_cairo_subpixelorder);
        php_eos_datastructures_set_enum_value(return_value, cairo_font_options_get_subpixel_order(font_options_object->font_options));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoFontOptions_setHintStyle_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, hint_style)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::setHintStyle(void)
        Sets the hint style for font outlines for the font options object.*/
PHP_METHOD(CairoFontOptions, setHintStyle) 
{
	zend_long hint_style = 0;
	cairo_font_options_object *font_options_object;
	zval *hint_style_enum;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET|ZEND_PARSE_PARAMS_THROW,
		ZEND_NUM_ARGS(), "O", &hint_style_enum, ce_cairo_hintstyle) == FAILURE) {
		if (zend_parse_parameters(ZEND_NUM_ARGS(), "|l", &hint_style) == FAILURE) {
			return;
		} else {
			if(!php_eos_datastructures_check_value(ce_cairo_hintstyle, hint_style)) {
				return;
			}
		}
	} else {
		hint_style = php_eos_datastructures_get_enum_value(hint_style_enum);
	}
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
	cairo_font_options_set_hint_style(font_options_object->font_options, hint_style);
	php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto int \Cairo\FontOptions::getHintStyle(void)
        Gets the hint style for font outlines for the font options object.*/
PHP_METHOD(CairoFontOptions, getHintStyle) 
{
	cairo_font_options_object *font_options_object;

	ZEND_PARSE_PARAMETERS_NONE();
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
        object_init_ex(return_value, ce_cairo_hintstyle);
        php_eos_datastructures_set_enum_value(return_value, cairo_font_options_get_hint_style(font_options_object->font_options));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoFontOptions_setHintMetrics_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, hint_metrics)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::setHintMetrics(void)
        Sets the metrics hinting mode for the font options object.*/
PHP_METHOD(CairoFontOptions, setHintMetrics) 
{
	zend_long hint_metrics = 0;
	cairo_font_options_object *font_options_object;
        zval *hint_metrics_enum;

	if (zend_parse_parameters_ex(ZEND_PARSE_PARAMS_QUIET|ZEND_PARSE_PARAMS_THROW,
		ZEND_NUM_ARGS(), "O", &hint_metrics_enum, ce_cairo_hintmetrics) == FAILURE) {
		if (zend_parse_parameters(ZEND_NUM_ARGS(), "|l", &hint_metrics) == FAILURE) {
			return;
		} else {
			if(!php_eos_datastructures_check_value(ce_cairo_hintmetrics, hint_metrics)) {
				return;
			}
		}
	} else {
		hint_metrics = php_eos_datastructures_get_enum_value(hint_metrics_enum);
	}
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
	cairo_font_options_set_hint_metrics(font_options_object->font_options, hint_metrics);
	php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto int \Cairo\FontOptions::getHintMetrics(void)
        Gets the metrics hinting mode for the font options object.*/
PHP_METHOD(CairoFontOptions, getHintMetrics) 
{
	cairo_font_options_object *font_options_object;
	
	ZEND_PARSE_PARAMETERS_NONE();
	
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }
	
        object_init_ex(return_value, ce_cairo_hintmetrics);
        php_eos_datastructures_set_enum_value(return_value, cairo_font_options_get_hint_metrics(font_options_object->font_options));
}
/* }}} */


#if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)

ZEND_BEGIN_ARG_INFO(CairoFontOptions_setVariations_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, variations)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\FontOptions::setVariations(string variations)
       Sets the OpenType font variations for the font options object.
       Font variations are specified as a string with a format that is similar to the CSS font-variation-settings.
       The string contains a comma-separated list of axis assignments, which each assignment consists of a
       4-character axis name and a value, separated by whitespace and optional equals sign. */
PHP_METHOD(CairoFontOptions, setVariations)
{
	cairo_font_options_object *font_options_object;
        char *variations;
        size_t variations_len;
        
        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_STRING(variations, variations_len)
        ZEND_PARSE_PARAMETERS_END();
        
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }

	cairo_font_options_set_variations(font_options_object->font_options, (const char *)variations);
	php_cairo_throw_exception(cairo_font_options_status(font_options_object->font_options));
}
/* }}} */

/* {{{ proto string \Cairo\FontOptions::getVariations()
       Returns the font variations for the font options object.
       Gets the OpenType font variations for the font options object.
       The returned string belongs to the options and must not be modified. */
PHP_METHOD(CairoFontOptions, getVariations)
{
	cairo_font_options_object *font_options_object;
        
        ZEND_PARSE_PARAMETERS_NONE();
        
        font_options_object = cairo_font_options_object_get(getThis());
	if(!font_options_object) {
            return;
        }

	RETURN_STRING(cairo_font_options_get_variations(font_options_object->font_options));
}
/* }}} */
#endif


/* ----------------------------------------------------------------
    Cairo\FontOptions Definition and registration
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoFontOptions_method_no_args, ZEND_SEND_BY_VAL)
ZEND_END_ARG_INFO()

/* {{{ cairo_pattern_methods[] */
static const zend_function_entry cairo_font_options_methods[] = {
        PHP_ME(CairoFontOptions, __construct, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(CairoFontOptions, getStatus, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, merge, CairoFontOptions_fontoptions_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, hash, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, equal, CairoFontOptions_fontoptions_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, setAntialias, CairoFontOptions_setAntialias_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, getAntialias, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, setSubpixelOrder, CairoFontOptions_setSubpixelOrder_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, getSubpixelOrder, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, setHintStyle, CairoFontOptions_setHintStyle_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, getHintStyle, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, setHintMetrics, CairoFontOptions_setHintMetrics_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, getHintMetrics, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
#if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)
	PHP_ME(CairoFontOptions, setVariations, CairoFontOptions_setVariations_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoFontOptions, getVariations, CairoFontOptions_method_no_args, ZEND_ACC_PUBLIC)
#endif
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_font_options)
{
	zend_class_entry fontoptions_ce, hintstyle_ce, hintmetrics_ce, antialias_ce, subpixelorder_ce;

        memcpy(&cairo_font_options_object_handlers,
                    zend_get_std_object_handlers(),
                    sizeof(zend_object_handlers));
        
        /* FontOptions */
        cairo_font_options_object_handlers.offset = XtOffsetOf(cairo_font_options_object, std);
        cairo_font_options_object_handlers.free_obj = cairo_font_options_free_obj;
        
        INIT_NS_CLASS_ENTRY(fontoptions_ce, CAIRO_NAMESPACE, "FontOptions", cairo_font_options_methods);
        fontoptions_ce.create_object = cairo_font_options_create_object;
        ce_cairo_fontoptions = zend_register_internal_class(&fontoptions_ce);
        
        
        /* Antialias */
	INIT_NS_CLASS_ENTRY(antialias_ce, CAIRO_NAMESPACE, "Antialias", NULL);
        ce_cairo_antialias = zend_register_internal_class_ex(&antialias_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_antialias->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_ANTIALIAS_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_antialias, #name, \
            sizeof(#name)-1, CAIRO_ANTIALIAS_## name);

        CAIRO_ANTIALIAS_DECLARE_ENUM(DEFAULT);
        CAIRO_ANTIALIAS_DECLARE_ENUM(NONE);
        CAIRO_ANTIALIAS_DECLARE_ENUM(GRAY);
        CAIRO_ANTIALIAS_DECLARE_ENUM(SUBPIXEL);
        CAIRO_ANTIALIAS_DECLARE_ENUM(FAST);
        CAIRO_ANTIALIAS_DECLARE_ENUM(GOOD);
        CAIRO_ANTIALIAS_DECLARE_ENUM(BEST);
        
        
        /* SubPixelOrder */
	INIT_NS_CLASS_ENTRY(subpixelorder_ce, CAIRO_NAMESPACE, "SubPixelOrder", NULL);
        ce_cairo_subpixelorder = zend_register_internal_class_ex(&subpixelorder_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_subpixelorder->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_SUBPIXELORDER_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_subpixelorder, #name, \
            sizeof(#name)-1, CAIRO_SUBPIXEL_ORDER_## name);
            
        CAIRO_SUBPIXELORDER_DECLARE_ENUM(DEFAULT);
        CAIRO_SUBPIXELORDER_DECLARE_ENUM(RGB);
        CAIRO_SUBPIXELORDER_DECLARE_ENUM(BGR);
        CAIRO_SUBPIXELORDER_DECLARE_ENUM(VRGB);
        CAIRO_SUBPIXELORDER_DECLARE_ENUM(VBGR);
        
        
        /* HintStyle */
	INIT_NS_CLASS_ENTRY(hintstyle_ce, CAIRO_NAMESPACE, "HintStyle", NULL);
        ce_cairo_hintstyle = zend_register_internal_class_ex(&hintstyle_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_hintstyle->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_HINTSTYLE_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_hintstyle, #name, \
            sizeof(#name)-1, CAIRO_HINT_STYLE_## name);

        CAIRO_HINTSTYLE_DECLARE_ENUM(DEFAULT);
        CAIRO_HINTSTYLE_DECLARE_ENUM(NONE);
        CAIRO_HINTSTYLE_DECLARE_ENUM(SLIGHT);
        CAIRO_HINTSTYLE_DECLARE_ENUM(MEDIUM);
        CAIRO_HINTSTYLE_DECLARE_ENUM(FULL);

        
        /* HintMetrics */
        INIT_NS_CLASS_ENTRY(hintmetrics_ce, CAIRO_NAMESPACE, "HintMetrics", NULL);
        ce_cairo_hintmetrics = zend_register_internal_class_ex(&hintmetrics_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_hintmetrics->ce_flags |= ZEND_ACC_FINAL;

        #define CAIRO_HINTMETRICS_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_hintmetrics, #name, \
            sizeof(#name)-1, CAIRO_HINT_METRICS_## name);

        CAIRO_HINTMETRICS_DECLARE_ENUM(DEFAULT);
        CAIRO_HINTMETRICS_DECLARE_ENUM(OFF);
        CAIRO_HINTMETRICS_DECLARE_ENUM(ON);

	return SUCCESS;
}
/* }}} */