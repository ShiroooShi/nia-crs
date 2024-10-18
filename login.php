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
            font-size: 15px;
            z-index: 1000;
            background-color: rgba(0,
                    0,
                    0,
                    0.5);
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
            <form id="loginForm">
                <div class="field">
                    <span class="fa fa-user" style="color: white"></span>
                    <input class="uname_pass" type="text" id="username" placeholder="Username">
                </div>
                <div id="usernameMessage" style="color: red; display: none;">Incorrect username!</div>
                <br>
                <div class="field">
                    <span class="fa fa-lock" style="color: white"></span>
                    <input type="password" id="password" class="pass-key uname_pass" required placeholder="Password">
                    <span class="show"><i class="fas fa-eye" style="color: white"></i></span>
                </div>

                <div id="passwordMessage" style="color: red; display: none;">Incorrect password!</div>
                <br>
                <div id="bothMessage" style="color: red; display: none;">Username & Password are incorrect!</div>
                <br>
                <div class="field">
                    <input type="submit" value="LOGIN">
                </div>
            </form>            
        </div>
    </div>
    <div class="credit">© Shiro / Adrian</div>
    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        const loginForm = document.getElementById('loginForm');
        const usernameMessage = document.getElementById('usernameMessage');
        const passwordMessage = document.getElementById('passwordMessage');
        const bothMessage = document.getElementById('bothMessage');

        showBtn.addEventListener('click', function() {
            if (pass_field.type === "password") {
                pass_field.type = "text";
                showBtn.innerHTML = '<i class="fas fa-eye-slash" style="color: red"></i>';
                showBtn.style.color = "#3498db";
            } else {
                pass_field.type = "password";
                showBtn.innerHTML = '<i class="fas fa-eye" style="color: white"></i>';
                showBtn.style.color = "#222";
            }
        });

        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Clear previous messages
            usernameMessage.style.display = 'none';
            passwordMessage.style.display = 'none';
            bothMessage.style.display = 'none';

            // Check credentials
            const isUsernameValid = username === 'admin';
            const isPasswordValid = password === 'admin123';

            if (!isUsernameValid && !isPasswordValid) {
                bothMessage.style.display = 'block';
                setTimeout(() => {
                    bothMessage.style.display = 'none';
                }, 2000);
            } else if (!isUsernameValid) {
                usernameMessage.style.display = 'block';
                setTimeout(() => {
                    usernameMessage.style.display = 'none';
                }, 2000);
            } else if (!isPasswordValid) {
                passwordMessage.style.display = 'block';
                setTimeout(() => {
                    passwordMessage.style.display = 'none';
                }, 2000);
            } else {
                window.location.href = 'home.php';
            }
        });
    </script>
</body>

</html>