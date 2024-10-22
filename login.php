<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: home.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['loggedin'] = true;
        header('Location: home.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .credit {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: white;
            font-size: 14px;
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="bg-img">
        <div class="content">
            <img src="images/nia.png" alt="Logo" class="logo">
            <header>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admin Login</header><br>
            <form id="loginForm" method="POST">
                <div class="field">
                    <span class="fa fa-user" style="color: white"></span>
                    <input class="uname_pass" type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <br>
                <div class="field">
                    <span class="fa fa-lock" style="color: white"></span>
                    <input type="password" id="password" name="password" class="pass-key uname_pass" required placeholder="Password">
                    <span class="show"><i class="fas fa-eye" style="color: white"></i></span>
                </div>
                <br>
                <?php if ($error): ?>
                    <div style="color: red;"><?= $error; ?></div>
                <?php endif; ?>
                <div class="field">
                    <input type="submit" value="LOGIN">
                </div>
            </form>
        </div>
    </div>
    <div class="credit">Adrian "SHIRO"</div>
    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        showBtn.addEventListener('click', function() {
            pass_field.type = pass_field.type === "password" ? "text" : "password";
            showBtn.innerHTML = pass_field.type === "password" ? '<i class="fas fa-eye" style="color: white"></i>' : '<i class="fas fa-eye-slash" style="color: red"></i>';
        });
    </script>
</body>

</html>