<?php
    DEFINED('DEFAULT_PROJECT') or DEFINE('DEFAULT_PROJECT','home');
    DEFINED('DEFAULT_CONTROLLER') or DEFINE('DEFAULT_CONTROLLER','Index');
    DEFINED('DEFAULT_ACTION') or DEFINE('DEFAULT_ACTION','index');
    // 定义分割符
    DEFINED('DS') or DEFINE('DS',DIRECTORY_SEPARATOR);
    // 定义核心类文件目录
    DEFINED('PATH_CORE') or DEFINE('PATH_CORE',str_replace(array('/',"\\"), DS, dirname(__FILE__)));
    // 定义项目完整根目录
    DEFINED('PATH_ROOT') or DEFINE('PATH_ROOT',dirname(PATH_CORE));
    // 定义项目根目录
    DEFINED('PATH_APP_ROOT') or DEFINE('PATH_APP_ROOT',$_SERVER['REQUEST_URI']);
    // 定义核心类文件夹路径
    DEFINED('PATH_CORE_DIR') or DEFINE('PATH_CORE_DIR',PATH_CORE.DS.'Core');
    // 定义扩展类文件目录
    DEFINED('PATH_CORE_EXT') or DEFINE('PATH_CORE_EXT', PATH_CORE.DS.'Extention');
    // 模型类目录
    DEFINED('PATH_MODEL') or DEFINE('PATH_MODEL', PATH_ROOT.DS.'Model');
    DEFINED('PATH_SERVER') or DEFINE('PATH_SERVER', str_replace(array('/',"\\"), DS, $_SERVER['SCRIPT_NAME']));
    header("Content-type: text/html; charset=utf-8");
    require_once(PATH_CORE_DIR.DS.'Yh.class.php');
    spl_autoload_register('Yh::autoLoad');
    Yh::coreClass('Yh')->run();

?>