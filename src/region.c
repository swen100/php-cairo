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

zend_class_entry *ce_cairo_region;
extern zend_class_entry *ce_cairo_rectangle;
zend_class_entry *ce_cairo_region_overlap;

static zend_object_handlers cairo_region_object_handlers;

typedef struct _cairo_region_object {
	cairo_region_t *region;
	zend_object std;
} cairo_region_object;

static inline cairo_region_object *cairo_region_fetch_object(zend_object *object)
{
	return (cairo_region_object *) ((char*)(object) - XtOffsetOf(cairo_region_object, std));
}

#define Z_CAIRO_REGION_P(zv) cairo_region_fetch_object(Z_OBJ_P(zv))

cairo_region_object *cairo_region_object_get(zval *zv)
{
	cairo_region_object *object = Z_CAIRO_REGION_P(zv);
	if(object->region == NULL) {
		zend_throw_exception_ex(ce_cairo_exception, 0,
			"Internal region object missing in %s, you must call parent::__construct in extended classes",
			ZSTR_VAL(Z_OBJCE_P(zv)->name));
		return NULL;
	}
	return object;
}

/* ----------------------------------------------------------------
    \Cairo\Region Object management
------------------------------------------------------------------*/

/* {{{ */
static void cairo_region_free_obj(zend_object *object)
{
    cairo_region_object *intern = cairo_region_fetch_object(object);

    if(!intern) {
            return;
    }

    if (intern->region) {
            cairo_region_destroy(intern->region);
    }
    intern->region = NULL;

    zend_object_std_dtor(&intern->std);
}

/* {{{ */
static zend_object* cairo_region_obj_ctor(zend_class_entry *ce, cairo_region_object **intern)
{
	cairo_region_object *object = ecalloc(1, sizeof(cairo_region_object) + zend_object_properties_size(ce));
        
        object->region = NULL;
        
	zend_object_std_init(&object->std, ce);
	object->std.handlers = &cairo_region_object_handlers;
	*intern = object;

	return &object->std;
}
/* }}} */

/* {{{ */
static zend_object* cairo_region_create_object(zend_class_entry *ce)
{
	cairo_region_object *region_obj = NULL;
	zend_object *return_value = cairo_region_obj_ctor(ce, &region_obj);

	object_properties_init(&(region_obj->std), ce);
	return return_value;
}
/* }}} */

/* {{{ */
static zend_object* cairo_region_clone_obj(zend_object *old_object) 
{
	cairo_region_object *new_region;
	cairo_region_object *old_region = cairo_region_fetch_object(old_object);
	zend_object *return_value = cairo_region_obj_ctor(old_object->ce, &new_region);

        new_region->region = old_region->region;
        cairo_region_reference(old_region->region);

	zend_objects_clone_members(&new_region->std, &old_region->std);

	return return_value;
}
/* }}} */


/* ----------------------------------------------------------------
    \Cairo\Region Class API
------------------------------------------------------------------ */

ZEND_BEGIN_ARG_INFO_EX(CairoRegion___construct_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
	ZEND_ARG_INFO(0, rectangles)
ZEND_END_ARG_INFO()

/* {{{ proto void __contruct([void | Cairo\Rectangle $rect | array Cairo\Rectangle $rects)
	Creates a new region - optionally with a single or union of multiple rectangles inside */
PHP_METHOD(CairoRegion, __construct)
{
	cairo_region_object *region_object;
        zval *rectangles_zval = NULL;
        long num_rectangles = 0;
        HashTable *rectangles_hash = NULL;
        cairo_rectangle_int_t *rectangle, *rectangles_array;
        int i = 0;
        zval *pzval;

	ZEND_PARSE_PARAMETERS_START(0,1)
                Z_PARAM_OPTIONAL
                Z_PARAM_ZVAL(rectangles_zval)
        ZEND_PARSE_PARAMETERS_END();

	region_object = Z_CAIRO_REGION_P(getThis());
	if(!region_object) {
		return;
	}
        
        if( rectangles_zval == NULL ) {
                region_object->region = cairo_region_create();
        } else if( Z_TYPE_P(rectangles_zval) == IS_OBJECT ) {
                rectangle = cairo_rectangle_object_get_rect(rectangles_zval);
                region_object->region = cairo_region_create_rectangle(rectangle);
        } else if( Z_TYPE_P(rectangles_zval) == IS_ARRAY ) {
                
                /* Grab the zend hash and see how big our array will be */
                rectangles_hash = Z_ARRVAL_P(rectangles_zval);
                num_rectangles = zend_hash_num_elements(rectangles_hash);
                rectangles_array = emalloc(num_rectangles * sizeof(cairo_rectangle_int_t));
                
                /* iterate over the array*/
                ZEND_HASH_FOREACH_VAL(rectangles_hash, pzval) {
                    /* ToDo: check type of object. Has to be a \Cairo\Rectangle */
                    if (Z_TYPE_P(pzval) != IS_OBJECT) {
                            zend_throw_exception(ce_cairo_exception, "Cairo\\Region::__construct() expects parameter 1 to be empty or an object|array of Cairo\\Rectangle.", 0);
                            return;
                    }
                    rectangles_array[i++] = *(cairo_rectangle_object_get_rect(pzval));
                } ZEND_HASH_FOREACH_END();
                
                region_object->region = cairo_region_create_rectangles(rectangles_array, i);
                
        } else {
            zend_throw_exception(ce_cairo_exception, "Cairo\\Region::__construct() expects parameter 1 to be empty or an object|array of Cairo\\Rectangle.", 0);
            return;
	}
        
	php_cairo_throw_exception(cairo_region_status(region_object->region));
}
/* }}} */

/* {{{ proto long \Cairo\Region::getStatus()
   Checks whether an error has previous occurred for this region object. Returns CAIRO_STATUS_SUCCESS or CAIRO_STATUS_NO_MEMORY */
PHP_METHOD(CairoRegion, getStatus)
{
	cairo_region_object *region_object;

	ZEND_PARSE_PARAMETERS_NONE();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }
        
        object_init_ex(return_value, ce_cairo_status);
        php_eos_datastructures_set_enum_value(return_value, cairo_region_status(region_object->region));
}
/* }}} */

/* {{{ proto long \Cairo\Region::getExtents()
   Gets the bounding rectangle of a region. Returns a \Cairo\Rectangle. */
PHP_METHOD(CairoRegion, getExtents)
{
	cairo_region_object *region_object;
        cairo_rectangle_object *rectangle_object;

	ZEND_PARSE_PARAMETERS_NONE();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }

        object_init_ex(return_value, ce_cairo_rectangle);
        rectangle_object = Z_CAIRO_RECTANGLE_P(Z_OBJ_P(return_value));
        cairo_region_get_extents(region_object->region, rectangle_object->rect);
}
/* }}} */

/* {{{ proto long \Cairo\Region::getNumRectangles()
   Returns the number of rectangles contained in region. */
PHP_METHOD(CairoRegion, getNumRectangles)
{
	cairo_region_object *region_object;

	ZEND_PARSE_PARAMETERS_NONE();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }
        
        RETVAL_LONG( cairo_region_num_rectangles(region_object->region) );
}
/* }}} */

/* {{{ proto long \Cairo\Region::isEmpty()
   Checks whether region is empty. Returns TRUE if region is empty, FALSE if it isn't. */
PHP_METHOD(CairoRegion, isEmpty)
{
	cairo_region_object *region_object;

	ZEND_PARSE_PARAMETERS_NONE();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }
        
        RETVAL_BOOL( cairo_region_is_empty(region_object->region) );
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoRegion_containsPoint_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, x)
	ZEND_ARG_INFO(0, y)
ZEND_END_ARG_INFO()

/* {{{ proto long \Cairo\Region::containsPoint(long x, long y)
   Checks whether (x , y ) is contained in region. Returns TRUE if (x , y ) is contained in region , FALSE if it is not. */
PHP_METHOD(CairoRegion, containsPoint)
{
        long x, y;
	cairo_region_object *region_object;

	ZEND_PARSE_PARAMETERS_START(2,2)
                Z_PARAM_LONG(x)
                Z_PARAM_LONG(y)
        ZEND_PARSE_PARAMETERS_END();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }
        
        RETVAL_BOOL( cairo_region_contains_point(region_object->region, x, y) );
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoRegion_equal_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_OBJ_INFO(0, region, Cairo\\Region, 0)
ZEND_END_ARG_INFO()
        
/* {{{ proto long \Cairo\Region::equal(\Cairo\Region region)
   Compares whether region_a is equivalent to region_b. NULL as an argument is equal to itself, but not to any non-NULL region. */
PHP_METHOD(CairoRegion, equal)
{
        zval *other_region = NULL;
	cairo_region_object *region_obj, *other_region_obj;

	ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_OBJECT_OF_CLASS_OR_NULL(other_region, ce_cairo_region)
        ZEND_PARSE_PARAMETERS_END();

        region_obj = cairo_region_object_get(getThis());
	if (!region_obj) {
            return;
        }
        
        if (other_region == NULL) {
            RETURN_TRUE;
        }
        
        other_region_obj = Z_CAIRO_REGION_P(other_region);
        RETVAL_BOOL( cairo_region_equal(region_obj->region, other_region_obj->region) );
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoRegion_translate_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, dx)
	ZEND_ARG_INFO(0, dy)
ZEND_END_ARG_INFO()

/* {{{ proto long \Cairo\Region::translate(long dx, long dy)
   Translates region by (dx , dy ). */
PHP_METHOD(CairoRegion, translate)
{
        long dx, dy;
	cairo_region_object *region_object;

	ZEND_PARSE_PARAMETERS_START(2,2)
                Z_PARAM_LONG(dx)
                Z_PARAM_LONG(dy)
        ZEND_PARSE_PARAMETERS_END();

        region_object = cairo_region_object_get(getThis());
	if (!region_object) {
            return;
        }
        
        cairo_region_translate(region_object->region, dx, dy);
        php_cairo_throw_exception(cairo_region_status(region_object->region));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoRegion_intersect_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_OBJ_INFO(0, region, Cairo\\Region, 0)
ZEND_END_ARG_INFO()

/* {{{ proto long \Cairo\Region::intersect(\Cairo\Region other_region)
   Computes the intersection with other_region and stores the result. */
PHP_METHOD(CairoRegion, intersect)
{
        zval *other_region;
	cairo_region_object *region_obj, *other_region_obj;

	ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_OBJECT_OF_CLASS(other_region, ce_cairo_region)
        ZEND_PARSE_PARAMETERS_END();

        region_obj = cairo_region_object_get(getThis());
	if (!region_obj) {
            return;
        }
        
        other_region_obj = Z_CAIRO_REGION_P(other_region);

        object_init_ex(return_value, ce_cairo_status);
        php_eos_datastructures_set_enum_value(return_value, cairo_region_intersect(region_obj->region, other_region_obj->region));
}
/* }}} */


/* ----------------------------------------------------------------
    \Cairo\Region Definition and registration
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoRegion_method_no_args, ZEND_SEND_BY_VAL)
ZEND_END_ARG_INFO()
        
/* {{{ cairo_region_methods[] */
const zend_function_entry cairo_region_methods[] = {
	PHP_ME(CairoRegion, __construct, CairoRegion___construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
        PHP_ME(CairoRegion, getStatus, CairoRegion_method_no_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, getExtents, CairoRegion_method_no_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, getNumRectangles, CairoRegion_method_no_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, getRectangle, CairoRegion_getRectangle_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, isEmpty, CairoRegion_method_no_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, containsPoint, CairoRegion_containsPoint_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, containsRectangle, CairoRegion_containsRectangle_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, equal, CairoRegion_equal_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, translate, CairoRegion_translate_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoRegion, intersect, CairoRegion_intersect_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, intersectRectangle, CairoRegion_intersectRectangle_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, subtract, CairoRegion_subtract_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, subtractRectangle, CairoRegion_subtractRectangle_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, union, CairoRegion_union_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, unionRectangle, CairoRegion_unionRectangle_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, xor, CairoRegion_xor_args, ZEND_ACC_PUBLIC)
//        PHP_ME(CairoRegion, xorRectangle, CairoRegion_xorRectangle_args, ZEND_ACC_PUBLIC)
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_region)
{
	zend_class_entry region_ce, overlap_ce;

	memcpy(&cairo_region_object_handlers,
		   zend_get_std_object_handlers(),
		   sizeof(zend_object_handlers));

	cairo_region_object_handlers.offset = XtOffsetOf(cairo_region_object, std);
	cairo_region_object_handlers.free_obj = cairo_region_free_obj;
        cairo_region_object_handlers.clone_obj = cairo_region_clone_obj;

	INIT_NS_CLASS_ENTRY(region_ce, CAIRO_NAMESPACE, "Region", cairo_region_methods);
	region_ce.create_object = cairo_region_create_object;
        ce_cairo_region = zend_register_internal_class(&region_ce);

	INIT_NS_CLASS_ENTRY(overlap_ce,  CAIRO_NAMESPACE, ZEND_NS_NAME("Region", "Overlap"), NULL);
	ce_cairo_region_overlap = zend_register_internal_class_ex(&overlap_ce, php_eos_datastructures_get_enum_ce());
	ce_cairo_region_overlap->ce_flags |= ZEND_ACC_FINAL;

	#define CAIRO_OVERLAP_DECLARE_ENUM(name) \
		zend_declare_class_constant_long(ce_cairo_region_overlap, #name, \
		sizeof(#name)-1, CAIRO_REGION_OVERLAP_## name);

	CAIRO_OVERLAP_DECLARE_ENUM(IN);
	CAIRO_OVERLAP_DECLARE_ENUM(OUT);
	CAIRO_OVERLAP_DECLARE_ENUM(PART);

	return SUCCESS;
}