<?php
return array(
    'db' => array('type' => 'mysql', 'dbHost' => 'localhost', 'dbUser' => 'root', 'dbPwd' => '', 'dbName' => 'dbName', 'prefix' => 'yh_'),
    'project' => array('home'),
    'urlSet' => array('route' => array('Index/index' => 'home')),
    'layout' => array('headFile' => 'head', 'footFile' => 'foot', 'suffix' => '.html', 'body' => 'index'),
    'debug' => array('toFile' => true, 'show' => true)
);
?>