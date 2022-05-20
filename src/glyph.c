/*
  +----------------------------------------------------------------------+
  | For PHP Version 8                                                    |
  +----------------------------------------------------------------------+
  | Copyright (c) 2022 Swen Zanon                                        |
  +----------------------------------------------------------------------+
  | http://www.opensource.org/licenses/mit-license.php  MIT License      |
  | Also available in LICENSE                                            |
  +----------------------------------------------------------------------+
  | Authors: Swen Zanon <swen.zanon@geoglis.de>                          |
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

zend_class_entry *ce_cairo_glyph;

static zend_object_handlers cairo_glyph_object_handlers; 

cairo_glyph_object *cairo_glyph_fetch_object(zend_object *object)
{
	return (cairo_glyph_object *) ((char*)(object) - XtOffsetOf(cairo_glyph_object, std));
}

static inline double cairo_glyph_get_property_default(zend_class_entry *ce, char * name) {
	zend_property_info *property_info;
	double value = 0.0;
	zend_string *key = zend_string_init(name, strlen(name), 0);

	property_info = zend_get_property_info(ce, key, 1);
	if (property_info) {
		zval *val = (zval*)((char*)ce->default_properties_table + property_info->offset - OBJ_PROP_TO_OFFSET(0));
		if(val) {
			value = zval_get_double(val);
		}
	}
	zend_string_release(key);
	return value;
}

/*static inline double cairo_glyph_get_property_value(zend_object *object, char *name) {
	zval *prop, rv;

	prop = zend_read_property(object->ce, object, name, strlen(name), 1, &rv);
	return zval_get_double(prop);
}*/

#define CAIRO_ALLOC_GLYPH(glyph_value) if (!glyph_value) \
	{ glyph_value = ecalloc(1,sizeof(cairo_glyph_t)); }

#define CAIRO_VALUE_FROM_STRUCT(n, m)         \
	if(strcmp(member->val, m) == 0) { \
		value = glyph_object->glyph->n;           \
		break;                               \
	}

#define CAIRO_VALUE_TO_STRUCT(n,m)                  \
	if(strcmp(member->val, m) == 0) {        \
		glyph_object->glyph->n = zval_get_double(value); \
		break;                                      \
	}

#define CAIRO_ADD_STRUCT_VALUE(n,m)                  \
	ZVAL_DOUBLE(&tmp, glyph_object->glyph->n);            \
	zend_hash_str_update(props, m, sizeof(m)-1, &tmp);

/* ----------------------------------------------------------------
    \Cairo\Glyph C API
------------------------------------------------------------------*/

/* {{{ */
cairo_glyph_t *cairo_glyph_object_get_glyph(zval *zv)
{
	cairo_glyph_object *glyph_object = Z_CAIRO_GLYPH_P(Z_OBJ_P(zv));

	return glyph_object->glyph;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Glyph Class API
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO_EX(CairoGlyph____construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
        ZEND_ARG_INFO(0, index)
	ZEND_ARG_INFO(0, x)
	ZEND_ARG_INFO(0, y)
ZEND_END_ARG_INFO()

/* {{{ proto void __construct(int index [,float x, float y])
	Creates a new glyph with the properties populated */
PHP_METHOD(CairoGlyph, __construct)
{
	cairo_glyph_object *glyph_object;

	/* read defaults from object */
	unsigned long index; //cairo_glyph_get_property_value(Z_OBJ_P(getThis()), "index");
        double x = 0.0; //cairo_glyph_get_property_value(Z_OBJ_P(getThis()), "x");
	double y = 0.0; //cairo_glyph_get_property_value(Z_OBJ_P(getThis()), "y");

	/* Now allow constructor to overwrite them if desired */
        ZEND_PARSE_PARAMETERS_START(1,3)
            Z_PARAM_LONG(index)
            Z_PARAM_OPTIONAL
            Z_PARAM_DOUBLE(x)
            Z_PARAM_DOUBLE(y)
        ZEND_PARSE_PARAMETERS_END();

	glyph_object = Z_CAIRO_GLYPH_P(Z_OBJ_P(getThis()));

	glyph_object->glyph->x = x;
	glyph_object->glyph->y = y;
	glyph_object->glyph->index = index;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Glyph Object management
------------------------------------------------------------------*/

/* {{{ */
static void cairo_glyph_free_obj(zend_object *zobj)
{
	cairo_glyph_object *intern = cairo_glyph_fetch_object(zobj);

	if(!intern) {
            return;
	}

	if(intern->glyph) {
            efree(intern->glyph);
	}
	intern->glyph = NULL;

	zend_object_std_dtor(&intern->std);
}
/* }}} */

/* {{{ */
static zend_object* cairo_glyph_obj_ctor(zend_class_entry *ce, cairo_glyph_object **intern)
{
	cairo_glyph_object *object = ecalloc(1, sizeof(cairo_glyph_object) + zend_object_properties_size(ce));
	CAIRO_ALLOC_GLYPH(object->glyph);

	zend_object_std_init(&object->std, ce);
	
	object->std.handlers = &cairo_glyph_object_handlers;
	*intern = object;

	/* We need to read in any default values and set them if applicable */
	if(ce->default_properties_count) {
		object->glyph->x = cairo_glyph_get_property_default(ce, "x");
		object->glyph->y = cairo_glyph_get_property_default(ce, "y");
		object->glyph->index = cairo_glyph_get_property_default(ce, "index");
	}

	return &object->std;
}
/* }}} */

/* {{{ */
static zend_object* cairo_glyph_create_object(zend_class_entry *ce)
{
	cairo_glyph_object *intern = NULL;
	zend_object *return_value = cairo_glyph_obj_ctor(ce, &intern);

	object_properties_init(&(intern->std), ce);
	return return_value;
}
/* }}} */

/* {{{ */
static zend_object* cairo_glyph_clone_obj(zend_object *zobj) 
{
	cairo_glyph_object *new_glyph;
	cairo_glyph_object *old_glyph = Z_CAIRO_GLYPH_P(zobj);
	zend_object *return_value = cairo_glyph_obj_ctor(zobj->ce, &new_glyph);
	CAIRO_ALLOC_GLYPH(new_glyph->glyph);

        new_glyph->glyph->index = old_glyph->glyph->index;
	new_glyph->glyph->x = old_glyph->glyph->x;
	new_glyph->glyph->y = old_glyph->glyph->y;

	zend_objects_clone_members(&new_glyph->std, &old_glyph->std);

	return return_value;
}
/* }}} */

/* {{{ */
/*static zval *cairo_glyph_object_read_property(zend_object *zobj, zend_string *member, int type, void **cache_slot, zval *rv)
{
	zval *retval;
	double value;
	cairo_glyph_object *glyph_object = Z_CAIRO_GLYPH_P(zobj);

	if(!glyph_object) {
            return rv;
	}

	do {
            CAIRO_VALUE_FROM_STRUCT(index,"index");
            CAIRO_VALUE_FROM_STRUCT(x,"x");
            CAIRO_VALUE_FROM_STRUCT(y,"y");	

            // not a struct member
            retval = (zend_get_std_object_handlers())->read_property(zobj, member, type, cache_slot, rv);

            return retval;
	} while(0);

	retval = rv;
	ZVAL_DOUBLE(retval, value);

	return retval;
}*/
/* }}} */

/* {{{ */
/*static zval *cairo_glyph_object_write_property(zend_object *zobj, zend_string *member, zval *value, void **cache_slot)
{
	cairo_glyph_object *glyph_object = Z_CAIRO_GLYPH_P(zobj);
        zval *retval = NULL;
        
	if(!glyph_object) {
            return retval;
	}

	do {
            CAIRO_VALUE_TO_STRUCT(index,"index");
            CAIRO_VALUE_TO_STRUCT(x,"x");
            CAIRO_VALUE_TO_STRUCT(y,"y");
	} while(0);

	// not a struct member
	retval = (zend_get_std_object_handlers())->write_property(zobj, member, value, cache_slot);

        return retval;
}*/
/* }}} */

/* {{{ */
static HashTable *cairo_glyph_object_get_properties(zend_object *zobj) 
{
	HashTable *props;
	zval tmp;
	cairo_glyph_object *glyph_object = Z_CAIRO_GLYPH_P(zobj);

	props = zend_std_get_properties(zobj);

	if(!glyph_object->glyph) {
		return props;
	}

        CAIRO_ADD_STRUCT_VALUE(index, "index");
	CAIRO_ADD_STRUCT_VALUE(x, "x");
	CAIRO_ADD_STRUCT_VALUE(y, "y");

	return props;
}
/* }}} */

/* ----------------------------------------------------------------
    \Cairo\Glyph Definition and registration
------------------------------------------------------------------*/

/* {{{ cairo_glyph_methods[] */
const zend_function_entry cairo_glyph_methods[] = {
	PHP_ME(CairoGlyph, __construct, CairoGlyph____construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_glyph)
{
	zend_class_entry ce;

	memcpy(&cairo_glyph_object_handlers,
		   zend_get_std_object_handlers(),
		   sizeof(zend_object_handlers));

	cairo_glyph_object_handlers.offset = XtOffsetOf(cairo_glyph_object, std);
	cairo_glyph_object_handlers.free_obj = cairo_glyph_free_obj;
	cairo_glyph_object_handlers.clone_obj = cairo_glyph_clone_obj;
	//cairo_glyph_object_handlers.read_property = cairo_glyph_object_read_property;
	//cairo_glyph_object_handlers.write_property = cairo_glyph_object_write_property;
	cairo_glyph_object_handlers.get_property_ptr_ptr = NULL;
	cairo_glyph_object_handlers.get_properties = cairo_glyph_object_get_properties;

	INIT_NS_CLASS_ENTRY(ce,  CAIRO_NAMESPACE, "Glyph", cairo_glyph_methods);
	ce.create_object = cairo_glyph_create_object;
	ce_cairo_glyph = zend_register_internal_class(&ce);
        ce_cairo_glyph->ce_flags |= ZEND_ACC_FINAL;
        
        zend_declare_property_long(ce_cairo_glyph, "index", sizeof("index")-1, 0, ZEND_ACC_PUBLIC);
	zend_declare_property_double(ce_cairo_glyph, "x", sizeof("x")-1, 0.0, ZEND_ACC_PUBLIC);
	zend_declare_property_double(ce_cairo_glyph, "y", sizeof("y")-1, 0.0, ZEND_ACC_PUBLIC);

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
