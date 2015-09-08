<?php
// mysql 操作类
class db
{
    static $table;
    static $handle;
    static $db;
    // 查询字段
    public $field = '*';
    // 排序
    public $order = '';
    // 条数
    public $limit = '';
    // 查询条件
    public $condition = '';
    // 更新字段
    public $update = '';
    // sql附加
    public $add = '';
    // 链接数据库
    static function connect($dsn = '', $user = '', $password = '')
    {
        if (isset(self::$db)) :
            return self::$db;
        endif;
        $dbHost = Yh::GC('db.dbHost');
        $dbName = Yh::GC('db.dbName');
        $dsn = $dsn?$dsn:"mysql:host=$dbHost;dbname=$dbName";
        $user = $user?$user:Yh::GC('db.dbUser');
        $password = $password?$password:Yh::GC('db.dbPwd');
        self::$handle = new PDO($dsn, $user, $password);
        return self::$db = new self;

    }

/*--------------------------------------------------查询部分--------------------------------------------------*/
    // 查询所有
    public function selectAll($arg = '')
    {
        $handle = self::$handle;
        $sql = sprintf("select %s from %s%s%s%s",$this->field,self::$table,$this->condition,$this->limit,$this->add);
        // $sql = str_replace("_","\_",$sql);//转义掉”_”
        // $sql = str_replace("%","\%",$sql);//转义掉”%”
        $sql = addslashes($sql);
        if (strpos($sql, "base64_") !== false)
            exit;
        if (strpos($sql, "union") !== false && strpos($sql, "select") !== false)
            exit;
        $rs = $handle->query($sql);
        $rs->setFetchMode(PDO::FETCH_ASSOC);
        $result_arr = $rs->fetchAll();
        if ($arg && !empty($result_arr)) :
            foreach ($result_arr as $key => $value) :
                $ret[] = $value[$arg];
            endforeach;
            return $ret;
        endif;
        return $result_arr;

    }

    // 设置字段
    public function field($arg)
    {
        if (is_array($arg)) :
            function add($value) {
                return "`".$value."`";
            };
            $arg = array_map("add", $arg);
            $this->field = implode(',', $arg);
        else :
            $this->field = $arg;
        endif;
            return $this;

    }

    // 限制条数
    public function limit($arg)
    {
        $this->limit = 'limit '.$arg;
        return $this;

    }

    // 测试用
    public function test()
    {
        echo 'test';

    }

/*--------------------------------------------------更新部分--------------------------------------------------*/
/*--------------------------------------------------插入部分--------------------------------------------------*/
/*--------------------------------------------------删除部分--------------------------------------------------*/
}

    // 无模型文件，$model即为表名
    function M($model)
    {
        db::$table = Yh::GC('db.prefix').$model;
        return db::connect();

    }
    // $db = db::connect();
    // $db->test();
?>