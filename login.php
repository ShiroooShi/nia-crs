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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            font-family: 'Cambria', serif;
        }

        .bg-img {
            background: url("images/background1.jpg");
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .bg-img:after {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 999;
            text-align: center;
            padding: 60px 32px;
            width: 400px;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: -1px 4px 28px 0px rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
            border-radius: 20px;
        }

        .content header {
            color: white;
            font-size: 40px;
            font-weight: 600;
            margin: 0 0 35px 0;
            font-family: "Harlow Solid", sans-serif;
        }

        .field {
            height: 45px;
            width: 100%;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background: transparent;
        }

        .field span {
            color: #222;
            width: 40px;
            line-height: 45px;
            margin-right: 10px;
        }

        .field input {
            height: 100%;
            width: 100%;
            background: transparent;
            border: 2px solid white;
            outline: none;
            color: white;
            font-size: 16px;
            padding: 8px;
            border-radius: 5px;
        }

        .field input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .space {
            margin-top: 16px;
        }

        .show {
            position: absolute;
            right: 13px;
            font-size: 13px;
            font-weight: 700;
            color: #222;
            display: none;
            cursor: pointer;
        }

        .pass-key:valid~.show {
            display: block;
        }

        .pass {
            text-align: left;
            margin: 10px 0;
        }

        .field input[type="submit"] {
            background: red;
            border: 1px solid #2691d9;
            color: white;
            font-size: 18px;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
        }

        .field input[type="submit"]:hover {
            background: #2691d9;
        }

        .login {
            color: white;
            margin: 20px 0;
        }

        .logo {
            position: absolute;
            top: 50px;
            left: 40px;
            width: 70px;
            height: auto;
            z-index: 1000;
        }

        .content .field input {
            background: transparent;
            border: 2px solid white;
            padding: 8px;
            border-radius: 10px;
        }

        */ .input-container {
            position: relative;
            flex-grow: 1;
            display: inline-block;
        }

        .input-container input {
            width: 100%;
            padding-right: 30px;
        }

        .input-container .show {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

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