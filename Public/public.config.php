<?php
return array(
    'db' => array('type' => 'mysql', 'dbHost' => 'localhost', 'dbUser' => 'root', 'dbPwd' => '', 'dbName' => 'dbName', 'prefix' => 'yh_'),
    'project' => array('home,admin'),
    'urlSet' => array('route' => array('Index/index' => 'home', 'Index/news:aid' => 'ariticle', 'admin/Index/product:id' => 'ap')),
    'debug' => array('toFile' => true, 'show' => true)
);
?>