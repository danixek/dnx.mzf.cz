<?php
require_once __DIR__ . '/pdo.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

session_start();

try {

    $stmt = pdo()->prepare("
    SELECT id, email, username, password_hash
    FROM users
    WHERE email = :email
    LIMIT 1
    ");

    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // redirect
    $redirect = $_SESSION['redirect_after_login'] ?? '/index.php';
    unset($_SESSION['redirect_after_login']);
    if (
        filter_var($email, FILTER_VALIDATE_EMAIL) &&
        $user &&
        password_verify($password, $user['password_hash'])
    ) {

        // OK - Login is succesfull
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    } else {
    // neplatné přihlašovací údaje
    $_SESSION['login_error'] = 'Neplatný email nebo heslo.';

    header("Location: $redirect");
    }
    exit;

} catch (Throwable $e) {

    session_unset();
    session_destroy();

    session_start();
    $_SESSION['login_error'] = 'Došlo k chybě při přihlášení.';

    error_log('Login error: ' . $e->getMessage());

    header('Location: /login.php');
    exit;
}
?>