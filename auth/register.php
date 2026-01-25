<?php
session_start();
$username = trim($_POST['username']) ?? '';
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirmedPassword = trim($_POST['confirmedPassword'] ?? '');

$bool['username'] = $bool['email'] = $bool['password'] = false;

// username validation
if(preg_match('/^\w{4,}$/u', $username)) {
    $bool['username'] = true;
}
// email validation
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $bool['email'] = true;
}

// password validation
if ($password === $confirmedPassword) {
    $lengthOk = strlen($password) >= 8;
    $hasNumber = preg_match("/[0-9]/", $password);
    $hasUpper = preg_match("/[A-Z]/", $password);
    $hasLower = preg_match("/[a-z]/", $password);

    if ($lengthOk && $hasNumber && $hasUpper && $hasLower) {
        $bool['password'] = true; // heslo je validní
    } else {
        $bool['password'] = false; // heslo nevyhovuje
    }
} else {
    $bool['password'] = false; // hesla se neshodují
}

// Successed registration
if ($bool['username'] && $bool['email'] && $bool['password']) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // načtení nastavení DB
    $env = parse_ini_file(__DIR__ . '/webuser.env');

    // vytvoření PDO objektu
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4",
        $env['DB_USER'],
        $env['DB_PASS']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        INSERT INTO users (username, email, password_hash)
        VALUES (:username, :email, :password)
    ");

    $stmt->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $hashedPassword
    ]);

    
    session_regenerate_id(true);

    // uložení uživatele
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = "user";

    // redirect
    $redirect = $_SESSION['redirect_after_login'] ?? '/index.php';
    unset($_SESSION['redirect_after_login']);

    header("Location: $redirect");
    exit;
}
?>