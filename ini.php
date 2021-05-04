<?php
session_start();
//config

defined("DS") ? NULL : define("DS", DIRECTORY_SEPARATOR);
defined("ADMIN_PATH") ? null : define("ADMIN_PATH", dirname(realpath(__FILE__)) . DS."admin".DS);
defined("INI_PATH") ? null : define("INI_PATH","ini.php");
defined("MAIN_PAGE_PARTS") ? null : define("MAIN_PAGE_PARTS","config".DS."template".DS."html_parts".DS);

defined("CONFIG_PATH") ? null : define("CONFIG_PATH", dirname(realpath(__FILE__)) . DS . "config" . DS);
defined("FUNCTIONS_PATH") ? null : define("FUNCTIONS_PATH", CONFIG_PATH. "functions" . DS."functions.php");
defined("CONN_PATH") ? null : define("CONN_PATH",CONFIG_PATH . "functions" . DS."connection.php");

defined("TEMPLATE_PATH") ? NULL : define("TEMPLATE_PATH",ADMIN_PATH."include".DS."template".DS);
defined("MEMBER_PATH") ? NULL : define("MEMBER_PATH",TEMPLATE_PATH."members".DS);
defined("CATEGORY_PATH") ? NULL : define("CATEGORY_PATH",TEMPLATE_PATH."category".DS);
defined("ITEMS_PATH") ? NULL : define("ITEMS_PATH",TEMPLATE_PATH."items".DS);
defined("COMMENTS_PATH") ? NULL : define("COMMENTS_PATH",TEMPLATE_PATH."comments".DS);
defined("HTML_PARTS") ? NULL : define("HTML_PARTS",TEMPLATE_PATH."html_parts".DS);
defined("CHANGE_LANG") ? null : define("CHANGE_LANG",CONFIG_PATH."lang.php");
defined("LANG_PATH") ? null : define("LANG_PATH",CONFIG_PATH. "lang" . DS);
defined("ENG_LANG") ? null : define("ENG_LANG", LANG_PATH."en.lang.php");
defined("AR_LANG") ? null : define("AR_LANG", LANG_PATH . "ar.lang.php");
defined("CSS_PATH") ? NULL : define("CSS_PATH","themes".DS."css".DS);
defined("JS_PATH") ? null : define("JS_PATH","themes" . DS . "js" . DS);
defined("DEFAULT_LANG") ? null : define("DEFAULT_LANG","AR");


require_once CONN_PATH;
require_once FUNCTIONS_PATH;





// SET LANG


