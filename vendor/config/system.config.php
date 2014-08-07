<?php
define("_VALID_DOMAIN", "0");

define("PATH_DELIMETER", DIRECTORY_SEPARATOR);
define("_DOCUMENT_ROOT",getcwd().constant("PATH_DELIMETER"));
define("_SERVER_NAME", (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : "www.nuagesystems.com");
define("_HTTP_ROOT", (constant("_VALID_DOMAIN") ? "http://" . constant("_SERVER_NAME") . "" : "http://" . constant("_SERVER_NAME") . "/onyourcircle/public"));

#PHP SCRIPTS INCLUDE PATH
define("_APP_LOGO_TEMP_FOLDER",constant("_DOCUMENT_ROOT")."workspace".  constant("PATH_DELIMETER")."whitelabeling1".constant("PATH_DELIMETER")."path_app_logo".constant("PATH_DELIMETER")."temp".constant("PATH_DELIMETER"));
define("_SWIFT_LIB_FOLDER", constant("_DOCUMENT_ROOT").'vendor' .constant("PATH_DELIMETER") . 'Swift-5.0.1' .constant("PATH_DELIMETER") . 'lib' .constant("PATH_DELIMETER"));
define("_BVH_TEMP_FOLDER",constant("_DOCUMENT_ROOT")."workspace".constant("PATH_DELIMETER")."bvh".constant("PATH_DELIMETER")."temp".constant("PATH_DELIMETER"));
define("_BVH_FOLDER",constant("_DOCUMENT_ROOT")."workspace".constant("PATH_DELIMETER")."bvh".constant("PATH_DELIMETER"));


#HTML OUT PUT INCLUDE PATH

define("_FACEBOOK_LOGIN_URL",constant("_HTTP_ROOT")."/user/login/fblogin");
define("_GOOGLE_LOGIN_URL",constant("_HTTP_ROOT")."/user/login/glogin");

define("_GOOGLE_LOGIN_PROCESS_URL",constant("_HTTP_ROOT")."/user/login/gprocess");