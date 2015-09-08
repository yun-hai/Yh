<?php
class Yh extends Exception{
    static $config;
    static $arr;
    // 控制路径包含类
    static $CLASS_PATH;
    // 存储类
    static $c = array();

    // 自动加载类文件
    static function autoLoad($class)
    {
        $fileName = self::$CLASS_PATH.DS.$class.'.class.php';
        if ($class == 'YhController') :
            $fileName = PATH_CORE_DIR.DS.$class.'.class.php';
        endif;
        if (is_file($fileName)) :
            require_once($fileName);
        else :
            echo $fileName.'not found';exit();
        endif;

    }

    // 加载扩展部分
    public function loadExt($class,$apply = '')
    {
        if (!$apply) :
            self::$CLASS_PATH = PATH_CORE_EXT;
        endif;
        Yh::autoLoad($class);

    }

    // 核心文件引入并实例化
    static function coreClass($className)
    {
        self::$CLASS_PATH = PATH_CORE_DIR;
        if (isset(self::$c[$className]) && self::$c[$className] !== '') :
            $class = $c[$className];
        else :
            $class = new $className;
            self::$c[$className] = $class;
        endif;
        return $class;

    }

    // 用于读取配置,传递字符串
    static function GC($name = '')
    {
        if (!$name) :
            return '';
        endif;
        if (isset(self::$config[$name])) :
            return self::$config[$name];
        endif;
        if (!isset(self::$config[$name]) && !isset(self::$arr[$name])) :
            $string = substr($name, 0,strpos($name,'.'));
            if (isset(self::$config[$string])) :
                self::$arr = self::$config[$string];
            endif;
            return self::GC(substr($name, strpos($name, '.')+1));
        else :
            return self::$arr[$name];
        endif;

    }

    // 用于写入配置
    static function SC($array)
    {
        if (isset($array) && is_array($array) && $array != '') :
            self::$config = array_merge(self::$config, $array);
        endif;

    }

    // 执行
    public function run()
    {
        try {
            $this->prepare();
            $this->getPca();
            $this->C();
        } catch (Exception $e) {
            $this->errorReport($e->getMessage(),$e->getFile(),$e->getLine(),$e->__toString());
        }

    }

    // 初始化
    protected function prepare()
    {
        Yh::autoLoad('Db');
        if (is_file(PATH_ROOT.DS.'Public'.DS.'public.config.php') && self::$config == '') :
            self::$config = require_once(PATH_ROOT.DS.'Public'.DS.'public.config.php');
        endif;
        call_user_func(array('Init','createMenu'));

    }


    // 获取路由,执行控制器
    protected function C($controller = '', $action = '', $apply = '')
    {
        $apply = self::GC('apply');
        $controller = self::GC('controller');
        self::$CLASS_PATH = PATH_ROOT.DS.$apply.DS.'Controller';
        $action = self::GC('action');
        $controller = $controller.'Controller';
        $controller = new $controller;
        if ($action != 'init') :
            call_user_func(array($controller,'init'));
        endif;
        call_user_func(array($controller,$action));

    }

    // 解析路由,获取控制器，方法和参数
    private function getPca()
    {

        if (isset($_SERVER['PATH_INFO']) && $request = $_SERVER['PATH_INFO']) :
            $request = $this->setPca($request);
            $args = $this->parseUrlToArgs($request);
            $this->setArgs($args);
            if (in_array($pca[0], Yh::GC('project'))) :
                $apply = $pca[0];
            else :
                $apply = DEFAULT_PROJECT;
            endif;
            if (isset($pca[1])) :
                $controller = $pca[1];
            else :
                $controller = DEFAULT_CONTROLLER;
            endif;
            if (isset($pca[2])) :
                $action = $pca[2];
            else :
                $action = DEFAULT_ACTION;
            endif;
            self::SC(array('apply' => $apply, 'controller' => $controller, 'action' => $action, 'urlArgs' => $args));
        else :
            self::SC(array('apply' => DEFAULT_PROJECT, 'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION));
        endif;

    }

    // 解析
    public function parseUrlToArgs($url)
    {
        $args = trim($url,'/');
        $args = explode('/',$args);
        $returnArgs = array();
        if ($args && count($args)>0) :
            foreach ($args as $key => $value) :
                if ($key%2==0) :
                    $returnArgs[$value] =  $args[$key+1];
                endif;
            endforeach;
        endif;
        return $returnArgs;

    }

    // 设置url应用
    public function setPca($args)
    {
        $pca = explode('/', $args);
        $routeList = Yh::GC('urlSet.route');
        $project = Yh::GC('project');
        if (!in_array($pca[0], $project)) :
            $apply = DEFAULT_PROJECT;
        else :
            $apply = $pca[0];
        endif;

        var_dump($project);
        exit();
        self::SC(array('apply' => $apply, 'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION)); 
    }

    // 设置路由 信息
    public function setArgs($args)        
    {
        return;

    }

    // 生成错误报告
    public function errorReport($msg,$file = '',$line = '',$detail='')
    {
        if (Yh::GC('debug.show')) :
            echo $msg = "<br>\n\rMsg: ".$msg."<br>".'File: '.$file."<br>\n\r".'Line: '.$line;
        endif;
        if (Yh::GC('debug.toFile')) :
            $log = "\n\r".$msg."\n\rdetail：".$detail."\n\r".date('Y年-m月-d日 H:i:s',time()).implode('.', array_fill(1, 40, '-'))."\n\r";
            file_put_contents('error.txt', $log,FILE_APPEND);
        endif;

    }

    // 打印变量
    public function logToFile($varible)
    {
        $path = PATH_ROOT.DS.Yh::GC('apply').DS.'Log'.DS;
        $path = str_replace(array('/',"\\"), DS, $path);
        $date = date("Y-m-d-H-i-s",time());
        $fileName = (string)$date.'.txt';
        $string = var_export($varible,true);
        file_put_contents($path.$fileName, $string);

    }


}
?>