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
#include "cairo_jpg.h"

zend_class_entry *ce_cairo_imagesurface;
zend_class_entry *ce_cairo_format;

/* ----------------------------------------------------------------
    Cairo\ImageSurface Class API
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoImageSurface___construct_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void __construct(int format, int width, int height)
       Returns new CairoSurfaceImage object created on an image surface */
PHP_METHOD(CairoImageSurface, __construct)
{
	zend_long format, width, height;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(3,3)
                Z_PARAM_LONG(format)
                Z_PARAM_LONG(width)
                Z_PARAM_LONG(height)
        ZEND_PARSE_PARAMETERS_END();

	surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }
	surface_object->surface = cairo_image_surface_create(format, width, height);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */

ZEND_BEGIN_ARG_INFO_EX(CairoImageSurface_createForData_args, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 4)
	ZEND_ARG_INFO(0, data)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto \Cairo\Surface\Image Object \Cairo\Surface\Image::createForData(string data, int format, int width, int height, int stride)
       Creates an image surface for the provided pixel data. */
PHP_METHOD(CairoImageSurface, createForData)
{
	/* NOTE: we have to keep the data buffer around, so we put it in the cairo_surface_object */
	char *data;
	size_t data_len;
	zend_long format, width, height, stride = -1;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(4,4)
                Z_PARAM_STRING(data, data_len)
                Z_PARAM_LONG(format)
                Z_PARAM_LONG(width)
                Z_PARAM_LONG(height)
        ZEND_PARSE_PARAMETERS_END();
	
	if (format < 0) {
		zend_throw_exception(ce_cairo_exception, "Cairo\\Surface\\Image::createForData(): invalid format", 0);
		return;
	}

	if (width < 1 || height < 1) {
		zend_throw_exception(ce_cairo_exception, "Cairo\\Surface\\Image::createForData(): invalid surface dimensions", 0);
		return;
	}
	
	if (stride >= INT_MAX || stride < -1) {
		zend_error(E_WARNING, "Invalid stride for Cairo\\Surface\\Image::createForData().");
		return;
	}

	/* Figure out our stride */
	/* This is the way the stride SHOULD be done */
	stride = cairo_format_stride_for_width (format, width);

	if (stride <= 0) {
		zend_error(E_WARNING, "Could not calculate stride for surface in Cairo\\Surface\\Image::createForData().");
		return;
	}

	/* Create the object, stick in the buffer and surface, check our status */
	object_init_ex(return_value, ce_cairo_imagesurface);
	surface_object = Z_CAIRO_SURFACE_P(return_value);
        
	if(!surface_object) {
		return;
        }
        
	/* allocate our internal surface object buffer - has to be left lying around until we destroy the image */
	surface_object->buffer = safe_emalloc(stride * height, sizeof(char), 0);
        
	if(surface_object->buffer == NULL) {
		zend_throw_exception(ce_cairo_exception, "Cairo\\Surface\\Image::createForData(): Could not allocate memory for buffer", 0);
		return;
	}

	/* copy our data into the buffer */
	surface_object->buffer = memcpy(surface_object->buffer, data, data_len);
	
        /* create our surface and check for errors */
	surface_object->surface = cairo_image_surface_create_for_data((unsigned char*)surface_object->buffer, format, width, height, stride);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */

/* {{{ proto string \Cairo\Surface\Image->getData()
       Get the string data of the image surface, for direct inspection or modification */
PHP_METHOD(CairoImageSurface, getData)
{
	cairo_surface_object *surface_object;
	unsigned char *data;	
	zend_long height, stride;

	ZEND_PARSE_PARAMETERS_NONE();

        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
        
	data = cairo_image_surface_get_data(surface_object->surface);
	height = cairo_image_surface_get_height(surface_object->surface);
	stride = cairo_image_surface_get_stride(surface_object->surface);
        
	RETURN_STRINGL(data, height * stride);
}
/* }}} */

/* {{{ proto int \Cairo\Surface\Image->getFormat()
       Get the format of the surface */
PHP_METHOD(CairoImageSurface, getFormat)
{
	cairo_surface_object *surface_object;

	ZEND_PARSE_PARAMETERS_NONE();

        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));

        object_init_ex(return_value, ce_cairo_format);
        php_eos_datastructures_set_enum_value(return_value, cairo_image_surface_get_format(surface_object->surface));
}
/* }}} */

/* {{{ proto int \Cairo\Surface\Image->getWidth()
       Get the width of the image surface in pixels. */
PHP_METHOD(CairoImageSurface, getWidth)
{
	cairo_surface_object *surface_object;

	ZEND_PARSE_PARAMETERS_NONE();

        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));

	RETURN_LONG(cairo_image_surface_get_width(surface_object->surface));
}
/* }}} */

/* {{{ proto int \Cairo\Surface\Image->getHeight()
       Get the height of the image surface in pixels. */
PHP_METHOD(CairoImageSurface, getHeight)
{
	cairo_surface_object *surface_object;

	ZEND_PARSE_PARAMETERS_NONE();

        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));

	RETURN_LONG(cairo_image_surface_get_height(surface_object->surface));
}
/* }}} */

/* {{{ proto int \Cairo\Surface\Image->getStride()
       Get the stride of the image surface in bytes */
PHP_METHOD(CairoImageSurface, getStride)
{
	cairo_surface_object *surface_object;

	ZEND_PARSE_PARAMETERS_NONE();

        surface_object = cairo_surface_object_get(getThis());
	if(!surface_object) {
            return;
        }
        
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));

	RETURN_LONG(cairo_image_surface_get_stride(surface_object->surface));
}
/* }}} */

ZEND_BEGIN_ARG_INFO(CairoFormat_strideForWidth_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, format)
	ZEND_ARG_INFO(0, width)
ZEND_END_ARG_INFO()

/* {{{ proto int CairoFormat::strideForWidth(long format, long width)
        This function provides a stride value that will respect all alignment 
        requirements of the accelerated image-rendering code within cairo. */
PHP_METHOD(CairoFormat, strideForWidth)
{
	zend_long format, width;

        ZEND_PARSE_PARAMETERS_START(2,2)
                Z_PARAM_LONG(format)
                Z_PARAM_LONG(width)
        ZEND_PARSE_PARAMETERS_END();
        
	RETURN_LONG(cairo_format_stride_for_width(format, width));
}
/* }}} */

#ifdef CAIRO_HAS_PNG_FUNCTIONS

ZEND_BEGIN_ARG_INFO(CairoImageSurface_createFromPng_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, file)
ZEND_END_ARG_INFO()

/* {{{ proto \Cairo\Surface\Image object \Cairo\Surface\Image::createFromPng(file|resource file)
       Creates a new image surface and initializes the contents to the given PNG file. */
PHP_METHOD(CairoImageSurface, createFromPng)
{
	cairo_surface_object *surface_object;
	zval *stream_zval = NULL;
	stream_closure *closure;
	zend_bool owned_stream = 0;
	php_stream *stream = NULL;

        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_ZVAL(stream_zval)
        ZEND_PARSE_PARAMETERS_END();

	object_init_ex(return_value, ce_cairo_imagesurface);
	surface_object = Z_CAIRO_SURFACE_P(return_value);

	if(Z_TYPE_P(stream_zval) == IS_STRING) {
            surface_object->surface = cairo_image_surface_create_from_png( Z_STRVAL_P(stream_zval) );
	} else if(Z_TYPE_P(stream_zval) == IS_RESOURCE)  {
            php_stream_from_zval(stream, stream_zval);

            if(!stream) {
		return;
            }

            // Pack stream into struct
            closure = ecalloc(1, sizeof(stream_closure));
            closure->stream = stream;
            closure->owned_stream = owned_stream;

            surface_object->closure = closure;
            surface_object->surface = cairo_image_surface_create_from_png_stream((cairo_read_func_t) php_cairo_read_func, (void *)closure);
        } else {
            zend_throw_exception(ce_cairo_exception, "Cairo\\Surface\\Image::createFromPng() expects parameter 1 to be a string or a stream resource", 0);
            return;
	}

	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */
#endif


ZEND_BEGIN_ARG_INFO(CairoImageSurface_createFromJpeg_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, file)
ZEND_END_ARG_INFO()

/* {{{ proto \Cairo\Surface\Image object \Cairo\Surface\Image::createFromJpeg(file|resource file)
       Creates a new image surface and initializes the contents to the given JPEG file. */
PHP_METHOD(CairoImageSurface, createFromJpeg)
{
	cairo_surface_object *surface_object;
	zval *stream_zval = NULL;
	stream_closure *closure;
	zend_bool owned_stream = 0;
	php_stream *stream = NULL;

        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_ZVAL(stream_zval)
        ZEND_PARSE_PARAMETERS_END();

	object_init_ex(return_value, ce_cairo_imagesurface);
	surface_object = Z_CAIRO_SURFACE_P(return_value);

	if(Z_TYPE_P(stream_zval) == IS_STRING) {
            surface_object->surface = cairo_image_surface_create_from_jpeg( Z_STRVAL_P(stream_zval) );
	} else if(Z_TYPE_P(stream_zval) == IS_RESOURCE)  {
            php_stream_from_zval(stream, stream_zval);

            if(!stream) {
                return;
            }

            // Pack stream into struct
            closure = ecalloc(1, sizeof(stream_closure));
            closure->stream = stream;
            closure->owned_stream = owned_stream;

            surface_object->closure = closure;
            surface_object->surface = cairo_image_surface_create_from_jpeg_stream((cairo_read_func_t) php_cairo_read_func, (void *)closure);
        } else {
            zend_throw_exception(ce_cairo_exception, "CairoImageSurface::createFromJpeg() expects parameter 1 to be a string or a stream resource", 0);
            return;
        }
        
        php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


/* ----------------------------------------------------------------
    Cairo\FontOptions Definition and registration
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoImageSurface_method_no_args, ZEND_SEND_BY_VAL)
ZEND_END_ARG_INFO()

/* {{{ cairo_imagesurface_methods[] */
static const zend_function_entry cairo_imagesurface_methods[] = {
        PHP_ME(CairoImageSurface, __construct, CairoImageSurface___construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(CairoImageSurface, createForData, CairoImageSurface_createForData_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	PHP_ME(CairoImageSurface, getData, CairoImageSurface_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoImageSurface, getFormat, CairoImageSurface_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoImageSurface, getWidth, CairoImageSurface_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoImageSurface, getHeight, CairoImageSurface_method_no_args, ZEND_ACC_PUBLIC)
	PHP_ME(CairoImageSurface, getStride, CairoImageSurface_method_no_args, ZEND_ACC_PUBLIC)
#ifdef CAIRO_HAS_PNG_FUNCTIONS
	PHP_ME(CairoImageSurface, createFromPng, CairoImageSurface_createFromPng_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
#endif
        PHP_ME(CairoImageSurface, createFromJpeg, CairoImageSurface_createFromJpeg_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	ZEND_FE_END
};
/* }}} */

/* {{{ cairo_format_methods[] */
const zend_function_entry cairo_format_methods[] = {
	PHP_ME(CairoFormat, strideForWidth, CairoFormat_strideForWidth_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_image_surface)
{
        zend_class_entry ce, format_ce;

	INIT_NS_CLASS_ENTRY(ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", "Image"), cairo_imagesurface_methods);
	ce_cairo_imagesurface = zend_register_internal_class_ex(&ce, ce_cairo_surface);

        INIT_NS_CLASS_ENTRY(format_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", "ImageFormat"), cairo_format_methods);
	ce_cairo_format = zend_register_internal_class_ex(&format_ce, php_eos_datastructures_get_enum_ce());
	ce_cairo_format->ce_flags |= ZEND_ACC_FINAL;
        
        #define CAIRO_FORMAT_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_format, #name, \
            sizeof(#name)-1, CAIRO_FORMAT_## name);

        CAIRO_FORMAT_DECLARE_ENUM(ARGB32);
        CAIRO_FORMAT_DECLARE_ENUM(RGB24);
        CAIRO_FORMAT_DECLARE_ENUM(A8);
        CAIRO_FORMAT_DECLARE_ENUM(A1);
        CAIRO_FORMAT_DECLARE_ENUM(RGB16_565);
        CAIRO_FORMAT_DECLARE_ENUM(RGB30);
        
        #if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 17, 0)
            CAIRO_FORMAT_DECLARE_ENUM(RGBA128F);
            CAIRO_FORMAT_DECLARE_ENUM(RGB96F);
        #endif
        
	return SUCCESS;
}
/* }}} */
