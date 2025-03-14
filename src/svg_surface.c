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

#if CAIRO_HAS_SVG_SURFACE
#include <cairo-svg.h>

zend_class_entry *ce_cairo_svgsurface;
zend_class_entry *ce_cairo_svgversion;
zend_class_entry *ce_cairo_svgunit;

/* ----------------------------------------------------------------
    \Cairo\Surface\Svg Class API
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoSvgSurface___construct_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, file)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void __construct(string|resource file, float width, float height) 
       Creates a SVG surface of the specified size in points to be written to filename. */
PHP_METHOD(CairoSvgSurface, __construct)
{
	zval *stream_zval = NULL;
	stream_closure *closure;
	php_stream *stream = NULL;
	double width, height;
	zend_bool owned_stream = 0;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(3,3)
                Z_PARAM_ZVAL(stream_zval)
                Z_PARAM_DOUBLE(width)
                Z_PARAM_DOUBLE(height)
        ZEND_PARSE_PARAMETERS_END();

	surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	/* special case - a NULL file is like an "in memory" svg */
	if(Z_TYPE_P(stream_zval) == IS_NULL) {
		surface_object->surface = cairo_svg_surface_create(NULL, width, height);
	/* Otherwise it can be a filename or a PHP stream */
	} else {
		if(Z_TYPE_P(stream_zval) == IS_STRING) {
			stream = php_stream_open_wrapper(Z_STRVAL_P(stream_zval), "w+b", REPORT_ERRORS, NULL);
			owned_stream = 1;
		} else if(Z_TYPE_P(stream_zval) == IS_RESOURCE) {
			php_stream_from_zval(stream, stream_zval);	
		} else {
			zend_throw_exception(ce_cairo_exception, "Cairo\\Surface\\Svg::__construct() expects parameter 1 to be null, a string, or a stream resource", 0);
			return;
		}

		/* Pack stream into struct */
		closure = ecalloc(1, sizeof(stream_closure));
		closure->stream = stream;
		closure->owned_stream = owned_stream;
                
		surface_object->closure = closure;
		surface_object->surface = cairo_svg_surface_create_for_stream(php_cairo_write_func, (void *)closure, width, height);
	}

	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoSvgSurface_restrictToVersion_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, version)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Svg::restrictToVersion(int version)
       Restricts the generated SVG file to version. This should be called before any drawing takes place on the surface */
PHP_METHOD(CairoSvgSurface, restrictToVersion)
{
	zend_long version;
	cairo_surface_object *surface_object;
        
        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_LONG(version)
        ZEND_PARSE_PARAMETERS_END();

	surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }

	cairo_svg_surface_restrict_to_version(surface_object->surface, version);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoSvgSurface_versionToString_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, version)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Svg::versionToString(int version)
       Get the string representation of the given version id. This function will return NULL if version isn't valid. */
PHP_METHOD(CairoSvgSurface, versionToString)
{
	zend_long version;

	ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_LONG(version)
        ZEND_PARSE_PARAMETERS_END();

	RETURN_STRING(cairo_svg_version_to_string(version));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoSvgSurface_method_no_args, ZEND_SEND_BY_VAL)
ZEND_END_ARG_INFO()

/* {{{ proto array \Cairo\Surface\Svg::getVersions()
       Used to retrieve the list of supported versions */
PHP_METHOD(CairoSvgSurface, getVersions)
{
	const cairo_svg_version_t *versions = 0;
	int version_count = 0, i = 0;

	ZEND_PARSE_PARAMETERS_NONE();

	cairo_svg_get_versions(&versions, &version_count);
	array_init(return_value);

	for (i = 0; i < version_count; i++) {
		add_next_index_long(return_value, versions[i]);
	}
}
/* }}} */


#if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)

ZEND_BEGIN_ARG_INFO(CairoSvgSurface_setDocumentUnit_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, unit)
ZEND_END_ARG_INFO()

/* {{{ proto array \Cairo\Surface\Svg::setDocumentUnit(\Cairo\Surface\Svg\Unit unit)
       ... */
PHP_METHOD(CairoSvgSurface, setDocumentUnit)
{
        cairo_surface_object *surface_object;
	zend_long unit;

	ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_LONG(unit)
        ZEND_PARSE_PARAMETERS_END();
        
        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
        if(!php_eos_datastructures_check_value(ce_cairo_svgunit, unit)) {
            zend_throw_exception(zend_ce_value_error, "Cairo\\Surface\\Svg::setDocumentUnit(): Argument #1 ($unit) is not a valid Cairo\\Surface\\Svg\\Unit constant.", 0);
            return;
        }

	cairo_svg_surface_set_document_unit(surface_object->surface, unit);
}
/* }}} */

/* {{{ proto array \Cairo\Surface\Svg::getDocumentUnit()
       ... */
PHP_METHOD(CairoSvgSurface, getDocumentUnit)
{
        cairo_surface_object *surface_object;

	ZEND_PARSE_PARAMETERS_NONE();
        
        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }

        /* should it better return an enum object? */
	RETURN_LONG(cairo_svg_surface_get_document_unit(surface_object->surface));
}
/* }}} */
#endif

/* ----------------------------------------------------------------
    \Cairo\Surface\Svg Definition and registration
------------------------------------------------------------------*/

/* {{{ cairo_svg_surface_methods[] */
static const zend_function_entry cairo_svg_surface_methods[] = {
	PHP_ME(CairoSvgSurface, __construct, CairoSvgSurface___construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(CairoSvgSurface, restrictToVersion, CairoSvgSurface_restrictToVersion_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoSvgSurface, versionToString, CairoSvgSurface_versionToString_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	PHP_ME(CairoSvgSurface, getVersions, CairoSvgSurface_method_no_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
#if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)
	PHP_ME(CairoSvgSurface, setDocumentUnit, CairoSvgSurface_setDocumentUnit_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoSvgSurface, getDocumentUnit, CairoSvgSurface_method_no_args, ZEND_ACC_PUBLIC)
#endif
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_svg_surface)
{
	zend_class_entry surface_ce, version_ce, unit_ce;

        /* Svg-Surface */
	INIT_NS_CLASS_ENTRY(surface_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", "Svg"), cairo_svg_surface_methods);
	ce_cairo_svgsurface = zend_register_internal_class_ex(&surface_ce, ce_cairo_surface);
        
        /* Svg-Version */
        INIT_NS_CLASS_ENTRY(version_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Svg", "Version")), NULL);
	ce_cairo_svgversion = zend_register_internal_class_ex(&version_ce, php_eos_datastructures_get_enum_ce());
	ce_cairo_svgversion->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_SVG_VERSION_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_svgversion, #name, \
            sizeof(#name)-1, CAIRO_SVG_## name);

        CAIRO_SVG_VERSION_DECLARE_ENUM(VERSION_1_1);
        CAIRO_SVG_VERSION_DECLARE_ENUM(VERSION_1_2);
        
        /* Svg-Unit */
        #if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)
            INIT_NS_CLASS_ENTRY(unit_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Svg", "Unit")), NULL);
            ce_cairo_svgunit = zend_register_internal_class_ex(&unit_ce, php_eos_datastructures_get_enum_ce());
            ce_cairo_svgunit->ce_flags |= ZEND_ACC_FINAL;

            #define CAIRO_SVG_UNIT_DECLARE_ENUM(name) \
                zend_declare_class_constant_long(ce_cairo_svgunit, #name, \
                sizeof(#name)-1, CAIRO_SVG_UNIT_## name);

            CAIRO_SVG_UNIT_DECLARE_ENUM(USER);
            CAIRO_SVG_UNIT_DECLARE_ENUM(EM);
            CAIRO_SVG_UNIT_DECLARE_ENUM(EX);
            CAIRO_SVG_UNIT_DECLARE_ENUM(PX);
            CAIRO_SVG_UNIT_DECLARE_ENUM(IN);
            CAIRO_SVG_UNIT_DECLARE_ENUM(CM);
            CAIRO_SVG_UNIT_DECLARE_ENUM(MM);
            CAIRO_SVG_UNIT_DECLARE_ENUM(PT);
            CAIRO_SVG_UNIT_DECLARE_ENUM(PC);
            CAIRO_SVG_UNIT_DECLARE_ENUM(PERCENT);
        #endif

	return SUCCESS;
}

#endif

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
