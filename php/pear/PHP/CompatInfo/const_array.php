<?php
/**
 * Constant dictionary for PHP_CompatInfo 1.9.0a1 or better
 *
 * PHP versions 4 and 5
 *
 * @category PHP
 * @package  PHP_CompatInfo
 * @author   Davey Shafik <davey@php.net>
 * @author   Laurent Laville <pear@laurent-laville.org>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD
 * @version  CVS: $Id: const_array.php,v 1.19 2009/01/03 10:59:19 farell Exp $
 * @link     http://pear.php.net/package/PHP_CompatInfo
 * @since    version 1.9.0a1 (2008-11-23)
 */

require_once 'PHP/CompatInfo/calendar_const_array.php';
require_once 'PHP/CompatInfo/date_const_array.php';
require_once 'PHP/CompatInfo/dom_const_array.php';
require_once 'PHP/CompatInfo/filter_const_array.php';
require_once 'PHP/CompatInfo/ftp_const_array.php';
require_once 'PHP/CompatInfo/gd_const_array.php';
require_once 'PHP/CompatInfo/hash_const_array.php';
require_once 'PHP/CompatInfo/iconv_const_array.php';
require_once 'PHP/CompatInfo/internal_const_array.php';
require_once 'PHP/CompatInfo/libxml_const_array.php';
require_once 'PHP/CompatInfo/mbstring_const_array.php';
require_once 'PHP/CompatInfo/mysql_const_array.php';
require_once 'PHP/CompatInfo/mysqli_const_array.php';
require_once 'PHP/CompatInfo/openssl_const_array.php';
require_once 'PHP/CompatInfo/pcre_const_array.php';
require_once 'PHP/CompatInfo/pgsql_const_array.php';
require_once 'PHP/CompatInfo/SQLite_const_array.php';
require_once 'PHP/CompatInfo/standard_const_array.php';
require_once 'PHP/CompatInfo/tokenizer_const_array.php';
require_once 'PHP/CompatInfo/xml_const_array.php';
require_once 'PHP/CompatInfo/xsl_const_array.php';

/**
 * Predefined Constants
 *
 * @link http://www.php.net/manual/en/reserved.constants.php
 * @global array $GLOBALS['_PHP_COMPATINFO_CONST']
 */

$GLOBALS['_PHP_COMPATINFO_CONST'] = array_merge(
    $GLOBALS['_PHP_COMPATINFO_CONST_CALENDAR'],
    $GLOBALS['_PHP_COMPATINFO_CONST_DATE'],
    $GLOBALS['_PHP_COMPATINFO_CONST_DOM'],
    $GLOBALS['_PHP_COMPATINFO_CONST_FILTER'],
    $GLOBALS['_PHP_COMPATINFO_CONST_FTP'],
    $GLOBALS['_PHP_COMPATINFO_CONST_GD'],
    $GLOBALS['_PHP_COMPATINFO_CONST_HASH'],
    $GLOBALS['_PHP_COMPATINFO_CONST_ICONV'],
    $GLOBALS['_PHP_COMPATINFO_CONST_INTERNAL'],
    $GLOBALS['_PHP_COMPATINFO_CONST_LIBXML'],
    $GLOBALS['_PHP_COMPATINFO_CONST_MBSTRING'],
    $GLOBALS['_PHP_COMPATINFO_CONST_MYSQL'],
    $GLOBALS['_PHP_COMPATINFO_CONST_MYSQLI'],
    $GLOBALS['_PHP_COMPATINFO_CONST_OPENSSL'],
    $GLOBALS['_PHP_COMPATINFO_CONST_PCRE'],
    $GLOBALS['_PHP_COMPATINFO_CONST_PGSQL'],
    $GLOBALS['_PHP_COMPATINFO_CONST_SQLITE'],
    $GLOBALS['_PHP_COMPATINFO_CONST_STANDARD'],
    $GLOBALS['_PHP_COMPATINFO_CONST_TOKENIZER'],
    $GLOBALS['_PHP_COMPATINFO_CONST_XML'],
    $GLOBALS['_PHP_COMPATINFO_CONST_XSL']
    );
?>