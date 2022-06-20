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

#include "php_cairo.h"
#include "php_cairo_internal.h"

zend_class_entry *ce_cairo_rectangle;

static zend_object_handlers cairo_rectangle_object_handlers; 

cairo_rectangle_object *cairo_rectangle_fetch_object(zend_object *object)
{
	return (cairo_rectangle_object *) ((char*)(object) - XtOffsetOf(cairo_rectangle_object, std));
}

static inline long cairo_rectangle_get_property_default(zend_class_entry *ce, char * name) {
	zend_property_info *property_info;
	long value = 0;
	zend_string *key = zend_string_init(name, strlen(name), 0);

	property_info = zend_get_property_info(ce, key, 1);
	if(property_info) {
		zval *val = (zval*)((char*)ce->default_properties_table + property_info->offset - OBJ_PROP_TO_OFFSET(0));
		if(val) {
			value = zval_get_long(val);
		}
	}
	zend_string_release(key);
	return value;
}

static inline long cairo_rectangle_get_property_value(zend_object *object, char *name) {
	zval *prop, rv;

	prop = zend_read_property(object->ce, object, name, strlen(name), 1, &rv);
	return zval_get_long(prop);
}

#define CAIRO_ALLOC_RECT(rect_value) if (!rect_value) \
	{ rect_value = ecalloc(1,sizeof(cairo_rectangle_int_t)); }

#define CAIRO_VALUE_FROM_STRUCT(n, m)         \
	if(strcmp(member->val, m) == 0) { \
		value = rectangle_object->rect->n;           \
		break;                               \
	}

#define CAIRO_VALUE_TO_STRUCT(n,m)                  \
	if(strcmp(member->val, m) == 0) {        \
		rectangle_object->rect->n = zval_get_long(value); \
		break;                                      \
	}

#define CAIRO_ADD_STRUCT_VALUE(n,m)                  \
	ZVAL_LONG(&tmp, rectangle_object->rect->n);            \
	zend_hash_str_update(props, m, sizeof(m)-1, &tmp);

/* ----------------------------------------------------------------
    \Cairo\Rectangle C API
------------------------------------------------------------------*/

/* {{{ */
cairo_rectangle_int_t *cairo_rectangle_object_get_rect(zval *zv)
{
	cairo_rectangle_object *rect_object = Z_CAIRO_RECTANGLE_P(zv);

        if (rect_object->rect == NULL) {
		zend_throw_exception_ex(ce_cairo_exception, 0,
			"Internal rectangle object missing in %s, you must call parent::__construct in extended classes",
			ZSTR_VAL(Z_OBJCE_P(zv)->name));
		return NULL;
	}
        
	return rect_object->rect;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Rectangle Class API
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO_EX(CairoRectangle____construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
	ZEND_ARG_INFO(0, x)
	ZEND_ARG_INFO(0, y)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void __construct([int x, int y, int width, int height])
	Creates a new rectangle with the properties populated */
PHP_METHOD(CairoRectangle, __construct)
{
	cairo_rectangle_object *rectangle_object;
        zend_object *object = Z_OBJ_P(getThis());

	/* read defaults from object */
	long x = cairo_rectangle_get_property_value(object, "x");
	long y = cairo_rectangle_get_property_value(object, "y");
	long width = cairo_rectangle_get_property_value(object, "width");
	long height = cairo_rectangle_get_property_value(object, "height");

	/* Now allow constructor to overwrite them if desired */
        ZEND_PARSE_PARAMETERS_START(0,4)
                Z_PARAM_OPTIONAL
                Z_PARAM_LONG(x)
                Z_PARAM_LONG(y)
                Z_PARAM_LONG(width)
                Z_PARAM_LONG(height)
        ZEND_PARSE_PARAMETERS_END();

	rectangle_object = cairo_rectangle_fetch_object(object);

	rectangle_object->rect->x = x;
	rectangle_object->rect->y = y;
	rectangle_object->rect->width = width;
	rectangle_object->rect->height = height;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Rectangle Object management
------------------------------------------------------------------*/

/* {{{ */
static void cairo_rectangle_free_obj(zend_object *object)
{
	cairo_rectangle_object *intern = cairo_rectangle_fetch_object(object);

	if(!intern) {
		return;
	}

	if(intern->rect) {
		efree(intern->rect);
	}
	intern->rect = NULL;

	zend_object_std_dtor(&intern->std);
}
/* }}} */

/* {{{ */
static zend_object* cairo_rectangle_obj_ctor(zend_class_entry *ce, cairo_rectangle_object **intern)
{
	cairo_rectangle_object *object = ecalloc(1, sizeof(cairo_rectangle_object) + zend_object_properties_size(ce));
	CAIRO_ALLOC_RECT(object->rect);

	zend_object_std_init(&object->std, ce);
	
	object->std.handlers = &cairo_rectangle_object_handlers;
	*intern = object;

	/* We need to read in any default values and set them if applicable */
	if(ce->default_properties_count) {
		object->rect->x = cairo_rectangle_get_property_default(ce, "x");
		object->rect->y = cairo_rectangle_get_property_default(ce, "y");
		object->rect->width = cairo_rectangle_get_property_default(ce, "width");
		object->rect->height = cairo_rectangle_get_property_default(ce, "height");
	}

	return &object->std;
}
/* }}} */

/* {{{ */
static zend_object* cairo_rectangle_create_object(zend_class_entry *ce)
{
	cairo_rectangle_object *intern = NULL;
	zend_object *return_value = cairo_rectangle_obj_ctor(ce, &intern);

	object_properties_init(&(intern->std), ce);
	return return_value;
}
/* }}} */

/* {{{ */
static zend_object* cairo_rectangle_clone_obj(zend_object *zobj) 
{
	cairo_rectangle_object *new_rectangle;
	cairo_rectangle_object *old_rectangle = cairo_rectangle_fetch_object(zobj);
	zend_object *return_value = cairo_rectangle_obj_ctor(zobj->ce, &new_rectangle);
	CAIRO_ALLOC_RECT(new_rectangle->rect);

	new_rectangle->rect->x = old_rectangle->rect->x;
	new_rectangle->rect->y = old_rectangle->rect->y;
	new_rectangle->rect->width = old_rectangle->rect->width;
	new_rectangle->rect->height = old_rectangle->rect->height;

	zend_objects_clone_members(&new_rectangle->std, &old_rectangle->std);

	return return_value;
}
/* }}} */

/* {{{ */
static zval *cairo_rectangle_object_read_property(zend_object *object, zend_string *member, int type, void **cache_slot, zval *rv)
{
	zval *retval;
	double value;
	cairo_rectangle_object *rectangle_object = cairo_rectangle_fetch_object(object);

	if(!rectangle_object) {
		return rv;
	}

	do {
		CAIRO_VALUE_FROM_STRUCT(x,"x");
		CAIRO_VALUE_FROM_STRUCT(y,"y");
		CAIRO_VALUE_FROM_STRUCT(width,"width");
		CAIRO_VALUE_FROM_STRUCT(height,"height");

		/* not a struct member */
		retval = (zend_get_std_object_handlers())->read_property(object, member, type, cache_slot, rv);

		return retval;
	} while(0);

	retval = rv;
	ZVAL_LONG(retval, value);

	return retval;
}
/* }}} */

/* {{{ */
static zval *cairo_rectangle_object_write_property(zend_object *object, zend_string *member, zval *value, void **cache_slot)
{
	cairo_rectangle_object *rectangle_object = cairo_rectangle_fetch_object(object);
        zval *retval = NULL;
        
	if(!rectangle_object) {
		return retval;
	}

	do {
		CAIRO_VALUE_TO_STRUCT(x,"x");
		CAIRO_VALUE_TO_STRUCT(y,"y");
		CAIRO_VALUE_TO_STRUCT(width,"width");
		CAIRO_VALUE_TO_STRUCT(height,"height");

	} while(0);

	/* not a struct member */
	retval = (zend_get_std_object_handlers())->write_property(object, member, value, cache_slot);

        return retval;
}
/* }}} */

/* {{{ */
static HashTable *cairo_rectangle_object_get_properties(zend_object *object) 
{
	HashTable *props;
	zval tmp;
	cairo_rectangle_object *rectangle_object = cairo_rectangle_fetch_object(object);

	props = zend_std_get_properties(object);

	if(!rectangle_object->rect) {
		return props;
	}

	CAIRO_ADD_STRUCT_VALUE(x, "x");
	CAIRO_ADD_STRUCT_VALUE(y, "y");
	CAIRO_ADD_STRUCT_VALUE(width, "width");
	CAIRO_ADD_STRUCT_VALUE(height, "height");

	return props;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Rectangle Definition and registration
------------------------------------------------------------------*/

/* {{{ cairo_rectangle_methods[] */
const zend_function_entry cairo_rectangle_methods[] = {
	PHP_ME(CairoRectangle, __construct, CairoRectangle____construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_rectangle)
{
	zend_class_entry ce;

	memcpy(&cairo_rectangle_object_handlers,
		   zend_get_std_object_handlers(),
		   sizeof(zend_object_handlers));

	cairo_rectangle_object_handlers.offset = XtOffsetOf(cairo_rectangle_object, std);
	cairo_rectangle_object_handlers.free_obj = cairo_rectangle_free_obj;
	cairo_rectangle_object_handlers.clone_obj = cairo_rectangle_clone_obj;
	cairo_rectangle_object_handlers.read_property = cairo_rectangle_object_read_property;
	cairo_rectangle_object_handlers.write_property = cairo_rectangle_object_write_property;
	cairo_rectangle_object_handlers.get_property_ptr_ptr = NULL;
	cairo_rectangle_object_handlers.get_properties = cairo_rectangle_object_get_properties;

	INIT_NS_CLASS_ENTRY(ce,  CAIRO_NAMESPACE, "Rectangle", cairo_rectangle_methods);
	ce.create_object = cairo_rectangle_create_object;
	ce_cairo_rectangle = zend_register_internal_class(&ce);

	zend_declare_property_long(ce_cairo_rectangle, "x", sizeof("x")-1, 0, ZEND_ACC_PUBLIC);
	zend_declare_property_long(ce_cairo_rectangle, "y", sizeof("y")-1, 0, ZEND_ACC_PUBLIC);
	zend_declare_property_long(ce_cairo_rectangle, "width", sizeof("width")-1, 0, ZEND_ACC_PUBLIC);
	zend_declare_property_long(ce_cairo_rectangle, "height", sizeof("height")-1, 0, ZEND_ACC_PUBLIC);

	return SUCCESS;
}
/* }}} */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
