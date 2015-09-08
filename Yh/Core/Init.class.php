<?php
    Class Init{
        // 创建项目目录
        public function createMenu()
        {
            $menuList = array(
            'Controller',
            'Log',
            'Extention',
            'View/Index',
            'View/Layout',
            'Public/css',
            'Public/img',
            'public/js');
            $config = Yh::$config;
            $menu = array(DEFAULT_PROJECT);
            if (isset($config['project'])) :
                $menu = array_merge($menu,$config['project']);
            endif;
            if (is_array($menu) && $menu != '') :
                foreach ($menu as $dir) :
                    if(!is_dir($dirName = PATH_ROOT.DS.$dir)) :
                        foreach ($menuList as $list) :
                            $dirDetail = $dirName.DS.$list;
                            mkdir(str_replace(array('/',"\\"), DS, $dirDetail),0777,true);
                        endforeach;
                        self::touchFile($dirName);
                    endif;
                endforeach;
            endif;

        }

        // 生成初始文件
        static function touchFile($dirName)
        {
            $controller = '<?php
class IndexController Extends YhController
{
    public function index()
    {
        $this->display();

    }

}

?>';
            $config = '<?php
return array(
    \'db\' => array(\'type\' => \'mysql\', \'dbHost\' => \'localhost\', \'dbUser\' => \'root\', \'dbPwd\' => \'\', \'dbName\' => \'dbName\', \'prefix\' => \'yh_\'),
    \'project\' => array(\''.DEFAULT_PROJECT.'\'),
    \'urlSet\' => array(\'route\' => array(\'Index/index\' => \'home\')),
    \'layout\' => array(\'headFile\' => \'head\', \'footFile\' => \'foot\', \'suffix\' => \'.html\', \'body\' => \'index\'),
    \'debug\' => array(\'toFile\' => true, \'show\' => true)
);
?>';
            $head = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><div style=\'width: 100%;height: 100%;margin: 0px auto;opacity: 0.82;border-top: 69px solid rgb(234, 3, 3);background-color: rgb(230, 4, 4);\'>
<div style=\'width:70%;height:90%;border:25px dotted #FB7F75;margin: 0 auto;\'>
    <div style=\'width:100%;height:100%;border: 1px dotted rgb(252, 80, 80);background-color: rgb(255, 223, 224);border-radius: 7%;\'>
        <div style=\'width:99%;height:20%;margin: 0 auto;font-size: 27px;color: rgb(249, 115, 115);\'>
        <h1><marquee>Hello World!</marquee></h1>
        </div>';
            $index = '<div style=\'width:90%;height:50%;background-color: #FFD9D9;margin: 0 auto;\'><h2>welcome Yh!</h2></div>';
            $foot = '<div style=\'w;idth:100%;height:10%;margin: 0 auto;text-align:right;color:#FF4D4D;\'>
        <hr><i><b>- - - -powerd by wyp</b></i>
        </div>
    </div>
</div>
</div>';
            if (!is_file(PATH_ROOT.DS.'Public'.DS.'public.config.php')) :
                if (!is_dir(PATH_ROOT.DS.'Public')) :
                    mkdir(PATH_ROOT.DS.'Public'.DS.'css',0777,true);
                endif;
                if (!is_dir(PATH_ROOT.DS.'Model')) :
                    mkdir(PATH_ROOT.DS.'Model');
                endif;
                if (!is_dir(PATH_ROOT.DS.'Conf')) :
                    mkdir(PATH_ROOT.DS.'Conf');
                endif;
                if (!is_dir(PATH_ROOT.DS.'Extention')) :
                    mkdir(PATH_ROOT.DS.'Extention');
                endif;
                file_put_contents(PATH_ROOT.DS.'Conf'.DS.'public.config.php', $config);
                if (is_file(PATH_ROOT.DS.'Conf'.DS.'public.config.php') && Yh::$config == '') :
                    Yh::$config = require_once(PATH_ROOT.DS.'Conf'.DS.'public.config.php');
                endif;
            endif;
                file_put_contents($dirName.DS.'Controller'.DS.'IndexController.class.php', $controller);
                file_put_contents($dirName.DS.'View'.DS.'Index'.DS.'index.html', $index);
                file_put_contents($dirName.DS.'View'.DS.'Layout'.DS.'head.html', $head);
                file_put_contents($dirName.DS.'View'.DS.'Layout'.DS.'foot.html', $foot);
        }

    }
?>