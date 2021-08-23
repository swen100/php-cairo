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
  +----------------------------------------------------------------------+
*/

#ifndef PHP_CAIRO_EXT_H
#define PHP_CAIRO_EXT_H

#include <php.h>

extern zend_module_entry cairo_module_entry;
#define phpext_cairo_ptr &cairo_module_entry

#define PHP_CAIRO_VERSION "1.0.1-dev"
#define CAIRO_NAMESPACE "Cairo"

#endif /* PHP_CAIRO_EXT_H */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
