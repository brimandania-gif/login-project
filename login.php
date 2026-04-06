<?php
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Replace these with your real user lookup
    $validUser = 'admin';
    $validPass = 'password123';

    if ($username === $validUser && $password === $validPass) {
        $_SESSION['user'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $errors[] = 'Invalid username or password.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        <form method="post" action="login.php">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>