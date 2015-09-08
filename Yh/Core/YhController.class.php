<?php
class YhController extends Yh
{
    public $assign = array();
    public function init()
    {

    }

    // 输出显示
    protected function display($string = '')
    {
        try{
            extract($this->assign);
            $apply = self::GC('apply');
            $controller = self::GC('controller');
            $action = self::GC('action');
            $PATH_VIEW = PATH_ROOT.DS.$apply.DS.'View'.DS.$controller.DS;
            $PATH_LAYOUT = PATH_ROOT.DS.$apply.DS.'View'.DS.'Layout'.DS;
            $suffix = '.html';
            include_once($PATH_LAYOUT.'head'.$suffix);
            include_once($PATH_VIEW.'index'.$suffix);
            include_once($PATH_LAYOUT.'foot'.$suffix);
        } catch (Exception $e) {
            $this->errorReport($e->getMessage(),$e->getFile(),$e->getLine(),$e->__toString());
        }

    }

    // 设置布局文件
    protected function setLayout($head = '', $foot ='')
    {
        if ($head) :
            Yh::SC(array('layout.headFile' => $head));
        endif;
        if ($foot) :
            Yh::SC(array('layout.footFile' => $foot));
        endif;

    }

    // 模版赋值
    protected function assign()
    {
        $assign = func_get_args();
        if (!empty($assign)) :
            foreach ($assign as $detail) :
                extract($detail);
                $this->assign = array_merge(&$this->assign,compact(array_keys($detail)));
            endforeach;
        endif;

    }

    protected function show($msg)
    {
        echo $msg;

    }

    // 执行控制器方法用
    public function C($controller = '',$action = '', $apply = '')
    {
        $pca = array(Yh::GC('apply'),Yh::GC('controller'),Yh::GC('action'));
        if ($controller) :
            Yh::SC(array('controller' => $controller));
        endif;
        if ($action) :
            Yh::SC(array('action' => $action));
        else :
            Yh::SC(array('action' => 'init'));
        endif;
        if ($apply) :
            Yh::SC(array('apply' => $apply));
        endif;
        parent::C();
        Yh::SC(array('apply' => $pca[0], 'controller' => $pca[1], 'action' => $pca[2]));

    }

    // 加载扩展部分
    public function loadExt($class,$apply = '')
    {
        $apply = $apply?$apply:Yh::GC('apply');
        Yh::$CLASS_PATH = PATH_ROOT.DS.$apply.DS.'Extention';
        parent::loadExt($class,$apply);

    }

}
?>