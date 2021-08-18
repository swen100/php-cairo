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

#if CAIRO_HAS_PDF_SURFACE
#include <cairo-pdf.h>

zend_class_entry *ce_cairo_pdfsurface;
zend_class_entry *ce_cairo_pdf_metadata;
zend_class_entry *ce_cairo_pdf_outlineflag;
zend_class_entry *ce_cairo_pdfversion;
zend_class_entry *ce_cairo_pdf_outline;

/* ----------------------------------------------------------------
    \Cairo\Surface\Pdf Class API
------------------------------------------------------------------*/

ZEND_BEGIN_ARG_INFO(CairoPdfSurface___construct_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, file)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void __construct(string|resource file, float width, float height) 
       Creates a PDF surface of the specified size in points to be written to filename. */
PHP_METHOD(CairoPdfSurface, __construct)
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

	/* special case - a NULL file is like an "in memory" PDF */
	if(Z_TYPE_P(stream_zval) == IS_NULL) {
		surface_object->surface = cairo_pdf_surface_create(NULL, width, height);
	/* Otherwise it can be a filename or a PHP stream */
	} else {
		if(Z_TYPE_P(stream_zval) == IS_STRING) {
			stream = php_stream_open_wrapper(Z_STRVAL_P(stream_zval), "w+b", REPORT_ERRORS, NULL);
			owned_stream = 1;
		} else if(Z_TYPE_P(stream_zval) == IS_RESOURCE)  {
			php_stream_from_zval(stream, stream_zval);	
		} else {
			zend_throw_exception(zend_ce_type_error, "Cairo\\Surface\\Pdf::__construct() expects parameter 1 to be null, a string, or a stream resource", 0);
			return;
		}

		/* Pack stream into struct*/
		closure = ecalloc(1, sizeof(stream_closure));
		closure->stream = stream;
		closure->owned_stream = owned_stream;

		surface_object->closure = closure;
		surface_object->surface = cairo_pdf_surface_create_for_stream(php_cairo_write_func, (void *)closure, width, height);
	}

	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_versionToString_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, version)
ZEND_END_ARG_INFO()

/* {{{ proto string \Cairo\Surface\Pdf::versionToString(int version)
       Get the string representation of the given version id. This function will return NULL if version isn't valid. */
PHP_METHOD(CairoPdfSurface, versionToString)
{
	zend_long version;

	ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_LONG(version)
        ZEND_PARSE_PARAMETERS_END();

        if(!php_eos_datastructures_check_value(ce_cairo_pdfversion, version)) {
            zend_throw_exception(zend_ce_value_error, "Cairo\\Surface\\Pdf::versionToString(): Argument #1 ($version) is not a valid Cairo\\Surface\\Pdf\\Version constant.", 0);
            return;
        }
        
	RETURN_STRING(cairo_pdf_version_to_string(version));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_getVersions_args, ZEND_SEND_BY_VAL)
ZEND_END_ARG_INFO()

/* {{{ proto array \Cairo\Surface\Pdf::getVersions()
       Used to retrieve the list of supported versions */
PHP_METHOD(CairoPdfSurface, getVersions)
{
	const cairo_pdf_version_t *versions = 0;
	int version_count = 0, i = 0;

	ZEND_PARSE_PARAMETERS_NONE();

	cairo_pdf_get_versions(&versions, &version_count);
	array_init(return_value);

	for (i = 0; i < version_count; i++) {
		add_next_index_long(return_value, versions[i]);
	}
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_setSize_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Pdf::setSize(double width, double height)
       Changes the size of a PDF surface for the current (and subsequent) pages.
       This should be called before any drawing takes place on the surface */
PHP_METHOD(CairoPdfSurface, setSize)
{
	double width = 0.0, height = 0.0;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(2,2)
                Z_PARAM_DOUBLE(width)
                Z_PARAM_DOUBLE(height)
        ZEND_PARSE_PARAMETERS_END();
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	cairo_pdf_surface_set_size(surface_object->surface, width, height);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_restrictToVersion_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, version)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Pdf::restrictToVersion(int version)
       Restricts the generated PDF file to version. */
PHP_METHOD(CairoPdfSurface, restrictToVersion)
{
	cairo_surface_object *surface_object;
        zend_long version;
        
        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_LONG(version);
        ZEND_PARSE_PARAMETERS_END();
        
        if(!php_eos_datastructures_check_value(ce_cairo_pdfversion, version)) {
            zend_throw_exception(zend_ce_value_error, "Cairo\\Surface\\Pdf::restrictToVersion(): Argument #1 ($version) is not a valid Cairo\\Surface\\Pdf\\Version constant.", 0);
            return;
        }
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	cairo_pdf_surface_restrict_to_version(surface_object->surface, version);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_addOutline_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, parent_id)
        ZEND_ARG_INFO(0, name)
        ZEND_ARG_INFO(0, link_attribs)
        ZEND_ARG_INFO(0, outline_flag)
ZEND_END_ARG_INFO()

/* {{{ proto int \Cairo\Surface\Pdf::addOutline(int parent_id, string name, string link_attr, int outline_flag])
       Add an item to the document outline hierarchy with a name that links to the location specified by link_attribs.
       Link attributes have the same keys and values as the Link Tag, excluding the "rect" attribute.
       The item will be a child of the item with id parent_id.
       Use CAIRO_PDF_OUTLINE_ROOT as the parent id of top level items.
       Returns the id for the added item. */
PHP_METHOD(CairoPdfSurface, addOutline)
{
	cairo_surface_object *surface_object;
        zend_long parent_id, outline_flag;
        char *name, *linkAttribs;
        size_t name_len, linkAttribs_len;
        
        ZEND_PARSE_PARAMETERS_START(4,4)
                Z_PARAM_LONG(parent_id);
                Z_PARAM_STRING(name, name_len)
                Z_PARAM_STRING(linkAttribs, linkAttribs_len)
                Z_PARAM_LONG(outline_flag);
        ZEND_PARSE_PARAMETERS_END();
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }
        
        if(!php_eos_datastructures_check_value(ce_cairo_pdf_outlineflag, outline_flag)) {
            zend_throw_exception(zend_ce_value_error, "Cairo\\Surface\\Pdf::addOutline(): Argument #4 ($outline_flag) is not a valid Cairo\\Surface\\Pdf\\OutlineFlags constant.", 0);
            return;
        }

	RETVAL_LONG( cairo_pdf_surface_add_outline(surface_object->surface, parent_id, (const char *)name, (const char *)linkAttribs, outline_flag) );
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_setMetadata_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, metadata_constant)
        ZEND_ARG_INFO(0, metadata)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Pdf::setMetadata(int metadata_constant [, string metadata])
       Set document metadata.
       The CAIRO_PDF_METADATA_CREATE_DATE and CAIRO_PDF_METADATA_MOD_DATE values must be in ISO-8601 format: YYYY-MM-DDThh:mm:ss.
       An optional timezone of the form "[+/-]hh:mm" or "Z" for UTC time can be appended.
       All other metadata values can be any UTF-8 string. */
PHP_METHOD(CairoPdfSurface, setMetadata)
{
	cairo_surface_object *surface_object;
        zend_long metadata_const;
        char *metadata = "";
        size_t metadata_len;
        
        ZEND_PARSE_PARAMETERS_START(1,2)
                Z_PARAM_LONG(metadata_const);
                Z_PARAM_OPTIONAL;
                Z_PARAM_STRING(metadata, metadata_len)
        ZEND_PARSE_PARAMETERS_END();
        
        if(!php_eos_datastructures_check_value(ce_cairo_pdf_metadata, metadata_const)) {
            zend_throw_exception(zend_ce_value_error, "Cairo\\Surface\\Pdf::setMetadata(): Argument #1 ($metadata_constant) is not a valid Cairo\\Surface\\Pdf\\Metadata constant.", 0);
            return;
        }
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	cairo_pdf_surface_set_metadata(surface_object->surface, metadata_const, (const char *)metadata);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_setPageLabel_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, label)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Pdf::setPageLabel(string label)
       Set page label for the current page. */
PHP_METHOD(CairoPdfSurface, setPageLabel)
{
	char *label;
        size_t label_len;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(1,1)
                Z_PARAM_STRING(label, label_len)
        ZEND_PARSE_PARAMETERS_END();
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	cairo_pdf_surface_set_page_label(surface_object->surface, (const char *)label);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


ZEND_BEGIN_ARG_INFO(CairoPdfSurface_setThumbnailSize_args, ZEND_SEND_BY_VAL)
	ZEND_ARG_INFO(0, width)
	ZEND_ARG_INFO(0, height)
ZEND_END_ARG_INFO()

/* {{{ proto void \Cairo\Surface\Pdf::setThumbnailSize(double width, double height)
       Set the thumbnail image size for the current and all subsequent pages.
       Setting a width or height of 0 disables thumbnails for the current and subsequent pages. */
PHP_METHOD(CairoPdfSurface, setThumbnailSize)
{
	double width = 0.0, height = 0.0;
	cairo_surface_object *surface_object;

        ZEND_PARSE_PARAMETERS_START(2,2)
                Z_PARAM_DOUBLE(width)
                Z_PARAM_DOUBLE(height)
        ZEND_PARSE_PARAMETERS_END();
        
        surface_object = Z_CAIRO_SURFACE_P(getThis());
	if(!surface_object) {
            return;
        }

	cairo_pdf_surface_set_thumbnail_size(surface_object->surface, width, height);
	php_cairo_throw_exception(cairo_surface_status(surface_object->surface));
}
/* }}} */


/* ----------------------------------------------------------------
    \Cairo\Surface\Pdf Definition and registration
------------------------------------------------------------------*/

/* {{{ cairo_pdf_surface_methods[] */
const zend_function_entry cairo_pdf_surface_methods[] = {
	PHP_ME(CairoPdfSurface, __construct, CairoPdfSurface___construct_args, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
        PHP_ME(CairoPdfSurface, restrictToVersion, CairoPdfSurface_restrictToVersion_args, ZEND_ACC_PUBLIC)
        PHP_ME(CairoPdfSurface, getVersions, CairoPdfSurface_getVersions_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
        PHP_ME(CairoPdfSurface, versionToString, CairoPdfSurface_versionToString_args, ZEND_ACC_PUBLIC|ZEND_ACC_STATIC)
        PHP_ME(CairoPdfSurface, setSize, CairoPdfSurface_setSize_args, ZEND_ACC_PUBLIC)
        #if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)
            PHP_ME(CairoPdfSurface, addOutline, CairoPdfSurface_addOutline_args, ZEND_ACC_PUBLIC)
            PHP_ME(CairoPdfSurface, setMetadata, CairoPdfSurface_setMetadata_args, ZEND_ACC_PUBLIC)
            PHP_ME(CairoPdfSurface, setPageLabel, CairoPdfSurface_setPageLabel_args, ZEND_ACC_PUBLIC)
            PHP_ME(CairoPdfSurface, setThumbnailSize, CairoPdfSurface_setThumbnailSize_args, ZEND_ACC_PUBLIC)
        #endif
	ZEND_FE_END
};
/* }}} */

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(cairo_pdf_surface)
{
	zend_class_entry pdf_ce, version_ce, outline_ce, outlineflags_ce, metadata_ce;

        INIT_NS_CLASS_ENTRY(pdf_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", "Pdf"), cairo_pdf_surface_methods);
	ce_cairo_pdfsurface = zend_register_internal_class_ex(&pdf_ce, ce_cairo_surface);
	ce_cairo_pdfsurface->create_object = cairo_surface_create_object;
        
        /* PDF-Versions */
        INIT_NS_CLASS_ENTRY(version_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Pdf", "Version")), NULL);
        ce_cairo_pdfversion = zend_register_internal_class_ex(&version_ce, php_eos_datastructures_get_enum_ce());
        ce_cairo_pdfversion->ce_flags |= ZEND_ACC_FINAL;

        #define CAIRO_PDF_VERSIONS_DECLARE_ENUM(name) \
            zend_declare_class_constant_long(ce_cairo_pdfversion, #name, \
            sizeof(#name)-1, CAIRO_PDF_## name);

        CAIRO_PDF_VERSIONS_DECLARE_ENUM(VERSION_1_4);
        CAIRO_PDF_VERSIONS_DECLARE_ENUM(VERSION_1_5);
            

        #if CAIRO_VERSION >= CAIRO_VERSION_ENCODE(1, 16, 0)

            /* Outline */
            INIT_NS_CLASS_ENTRY(outline_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Pdf", "Outline")), NULL);
            ce_cairo_pdf_outline = zend_register_internal_class_ex(&outline_ce, php_eos_datastructures_get_enum_ce());
            ce_cairo_pdf_outline->ce_flags |= ZEND_ACC_FINAL;

            #define CAIRO_PDF_OUTLINE_DECLARE_ENUM(name) \
		zend_declare_class_constant_long(ce_cairo_pdf_outline, #name, \
		sizeof(#name)-1, CAIRO_PDF_OUTLINE_## name);

            CAIRO_PDF_OUTLINE_DECLARE_ENUM(ROOT);
            
            /* Outline-Flags */
            INIT_NS_CLASS_ENTRY(outlineflags_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Pdf", "OutlineFlags")), NULL);
            ce_cairo_pdf_outlineflag = zend_register_internal_class_ex(&outlineflags_ce, php_eos_datastructures_get_enum_ce());
            ce_cairo_pdf_outlineflag->ce_flags |= ZEND_ACC_FINAL;

            #define CAIRO_PDF_OUTLINEFLAGS_DECLARE_ENUM(name) \
		zend_declare_class_constant_long(ce_cairo_pdf_outlineflag, #name, \
		sizeof(#name)-1, CAIRO_PDF_OUTLINE_FLAG_## name);

            CAIRO_PDF_OUTLINEFLAGS_DECLARE_ENUM(OPEN);
            CAIRO_PDF_OUTLINEFLAGS_DECLARE_ENUM(BOLD);
            CAIRO_PDF_OUTLINEFLAGS_DECLARE_ENUM(ITALIC);
            
            /* Metadata */
            INIT_NS_CLASS_ENTRY(metadata_ce, CAIRO_NAMESPACE, ZEND_NS_NAME("Surface", ZEND_NS_NAME("Pdf", "Metadata")), NULL);
            ce_cairo_pdf_metadata = zend_register_internal_class_ex(&metadata_ce, php_eos_datastructures_get_enum_ce());
            ce_cairo_pdf_metadata->ce_flags |= ZEND_ACC_FINAL;

            #define CAIRO_PDF_METADATA_DECLARE_ENUM(name) \
		zend_declare_class_constant_long(ce_cairo_pdf_metadata, #name, \
		sizeof(#name)-1, CAIRO_PDF_METADATA_## name);

            CAIRO_PDF_METADATA_DECLARE_ENUM(TITLE);
            CAIRO_PDF_METADATA_DECLARE_ENUM(AUTHOR);
            CAIRO_PDF_METADATA_DECLARE_ENUM(SUBJECT);
            CAIRO_PDF_METADATA_DECLARE_ENUM(KEYWORDS);
            CAIRO_PDF_METADATA_DECLARE_ENUM(CREATOR);
            CAIRO_PDF_METADATA_DECLARE_ENUM(CREATE_DATE);
            CAIRO_PDF_METADATA_DECLARE_ENUM(MOD_DATE);
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

