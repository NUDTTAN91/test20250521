<?php
// login.php
$host = 'mysql5647'; // 通常是这个地址
$db   = 'user';      // 数据库名
$user = 'root';      // 数据库用户名
$pass = '123456';    // 数据库密码
$charset = 'utf8mb4';

// 设置DSN（数据源名称）
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 创建PDO实例
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// 检查表单是否被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 准备SQL语句
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 验证用户名和密码
    if ($user && $user['password'] === $password) {
        echo "登录成功！欢迎 " . htmlspecialchars($username);
        // 这里可以设置session或者跳转到其他页面
    } else {
        echo "登录失败：用户名或密码错误。";
    }
}
?>
