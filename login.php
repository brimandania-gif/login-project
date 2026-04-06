<?php
session_start();

$errors = [];

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['otp_pending']) && $_SESSION['otp_pending'] === true) {
        $otp = trim($_POST['otp'] ?? '');

        if ($otp === '12345') {
            $_SESSION['user'] = $_SESSION['otp_user'];
            unset($_SESSION['otp_pending'], $_SESSION['otp_user']);
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid OTP.';
        }
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $validUser = 'admin';
        $validPass = 'password123';

        if ($username === $validUser && $password === $validPass) {
            $_SESSION['otp_pending'] = true;
            $_SESSION['otp_user'] = $username;
        } else {
            $errors[] = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login version 2.0</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 320px; }
        .login-box h1 { margin: 0 0 16px; font-size: 24px; }
        .login-box input { width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box; }
        .login-box button { width: 100%; padding: 10px; background: #007bff; border: none; color: #fff; border-radius: 4px; cursor: pointer; }
        .login-box .error { color: #d9534f; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Login</h1>
        <?php if ($errors): ?>
            <div class="error"><?= htmlspecialchars($errors[0]) ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['otp_pending']) && $_SESSION['otp_pending'] === true): ?>
            <form method="post" action="login.php">
                <p>Enter OTP for <?= htmlspecialchars($_SESSION['otp_user']) ?>:</p>
                <input type="text" name="otp" placeholder="OTP" required autofocus>
                <button type="submit">Verify OTP</button>
            </form>
        <?php else: ?>
            <form method="post" action="login.php">
                <input type="text" name="username" placeholder="Username" required autofocus>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>