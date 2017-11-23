<?php
require_once('./product.php');
require_once('./user.php');
require_once('./cat.php');
//连接数据库
function connect_database()
{
    //默认配置
    $options = [
        /* 常用设置 */
        PDO::ATTR_CASE => PDO::CASE_NATURAL, /*PDO::CASE_NATURAL | PDO::CASE_LOWER 小写，PDO::CASE_UPPER 大写， */
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, /*是否报错，PDO::ERRMODE_SILENT 只设置错误码，PDO::ERRMODE_WARNING 警告级，如果出错提示警告并继续执行| PDO::ERRMODE_EXCEPTION 异常级，如果出错提示异常并停止执行*/
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL, /* 空值的转换策略 */
        PDO::ATTR_STRINGIFY_FETCHES => false, /* 将数字转换为字符串 */
        PDO::ATTR_EMULATE_PREPARES => false, /* 模拟语句准备 */
    ];
    //链接数据库  用PDO  PDO 是一个类需要new
    return $pdo = new PDO('mysql:host=wangye.mvp;dbname=information_product', 'root', 'wangye', $options);
}

//获取传入参数
function get_params()
{
    $params = array_merge($_POST, $_GET);
    //获取传入的类 model   类名首字母都是大写  索引要用 ucfirst()这个方法把获取到的类名 首字母大写
    $klass = ucfirst(@$params['model']);
    //获取一下传入的方法  是add 还是read
    $methods = @$params['action'];
    //实例化这个类   还把获取的信息传入进去
    $a = new $klass(connect_database());
    //调用这个方法
    unset($params['model']);
    unset($params['action']);
    return $a->$methods($params);
}

//就json 的形式返回方法
function json($data)
{
    header('Content-Type:application/json');
    return json_encode($data);
}

//页面加载后只进行函数
function init()
{
    echo json(get_params());
}

init();
