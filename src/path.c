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


zend_class_entry *ce_cairo_path;
zend_class_entry *ce_cairo_path_datatype;

static zend_object_handlers cairo_path_object_handlers; 

cairo_path_object *cairo_path_fetch_object(zend_object *object)
{
    return (cairo_path_object *) ((char*)(object) - XtOffsetOf(cairo_path_object, std));
}

static inline cairo_path_object *cairo_path_object_get(zval *zv)
{
	cairo_path_object *object = Z_CAIRO_PATH_P(zv);
	if(object->path == NULL) {
		zend_throw_exception_ex(ce_cairo_exception, 0,
			"Internal path object missing in %s, you must call parent::__construct in extended classes",
			ZSTR_VAL(Z_OBJCE_P(zv)->name));
		return NULL;
	}
	return object;
}

/* ----------------------------------------------------------------
    \Cairo\Path Object management
------------------------------------------------------------------*/

/* {{{ */
static void cairo_path_free_obj(zend_object *object)
{
    cairo_path_object *intern = cairo_path_fetch_object(object);

    if(!intern) {
            return;
    }

    if (intern->path) {
            cairo_path_destroy(intern->path);
    }
    intern->path = NULL;

    zend_object_std_dtor(&intern->std);
}

/* {{{ */
static zend_object* cairo_path_obj_ctor(zend_class_entry *ce, cairo_path_object **intern)
{
	cairo_path_object *object = ecalloc(1, sizeof(cairo_path_object) + zend_object_properties_size(ce));
        
        object->path = NULL;
        
	zend_object_std_init(&object->std, ce);
	object->std.handlers = &cairo_path_object_handlers;
	*intern = object;

	return &object->std;
}
/* }}} */

/* {{{ */
static zend_object* cairo_path_create_object(zend_class_entry *ce)
{
	cairo_path_object *path_obj = NULL;
	zend_object *return_value = cairo_path_obj_ctor(ce, &path_obj);

	object_properties_init(&(path_obj->std), ce);
	return return_value;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Path C API
------------------------------------------------------------------*/

zend_class_entry * php_cairo_get_path_ce()
{
	return ce_cairo_path;
}

/* }}} -----------------------------------------------------------*/


/* ----------------------------------------------------------------
    \Cairo\Path Definition and registration
------------------------------------------------------------------*/

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_path)
{
	zend_class_entry path_ce, datatype_ce;

        memcpy(&cairo_path_object_handlers,
                    zend_get_std_object_handlers(),
                    sizeof(zend_object_handlers));
        
        /* Path */
        cairo_path_object_handlers.offset = XtOffsetOf(cairo_path_object, std);
        cairo_path_object_handlers.free_obj = cairo_path_free_obj;
        
        INIT_NS_CLASS_ENTRY(path_ce, CAIRO_NAMESPACE, "Path", NULL);
        path_ce.create_object = cairo_path_create_object;
        ce_cairo_path = zend_register_internal_class(&path_ce);

        /* Path\DataType */
        INIT_NS_CLASS_ENTRY(datatype_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Path", "DataType"), NULL);
        ce_cairo_path_datatype = zend_register_internal_class_ex(&datatype_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_path_datatype->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_PATH_DATATYPE_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_path_datatype, #name, \
            sizeof(#name)-1, CAIRO_PATH_## name);
        
        CAIRO_PATH_DATATYPE_DECLARE_ENUM(MOVE_TO);
        CAIRO_PATH_DATATYPE_DECLARE_ENUM(LINE_TO);
        CAIRO_PATH_DATATYPE_DECLARE_ENUM(CURVE_TO);
        CAIRO_PATH_DATATYPE_DECLARE_ENUM(CLOSE_PATH);
        
	return SUCCESS;
}
/* }}} */

