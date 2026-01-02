<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="icon" href="../../../public/Image/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/halaman-login.css">
    <style>
        
    </style>
</head>

<body>
    <div class="kotak">
        <div class="kotak2">
            <img src="../../../public/Image/logo.png" alt="SIWa">
            <div class="font1">
                <h2>Perumahan Legenda<br>
                    <span>RW 01</span>
                </h2>
            </div>
        </div>
        <div>
            <form action="../../controllers/login/cek-login.php" method="POST">

                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <?= $_SESSION['error']; ?>
                    </div>
                <?php unset($_SESSION['error']);
                endif; ?>

                <div class="input">
                    <label>Username</label><br>
                    <input type="text" name="username" class="inp1" required placeholder="Masukkan Username anda"><br>

                    <label>Password</label><br>

                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="inp2" required placeholder="Masukkan Password">
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                    </div>

                </div>

                <div class="login">
                    <button type="submit">Login</button>
                </div>
            </form>

        </div>
    </div>
</body>
<script>
const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

togglePassword.addEventListener("click", function () {
    const isPassword = passwordInput.type === "password";

    passwordInput.type = isPassword ? "text" : "password";

    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
    this.classList.toggle("active");
});
</script>


</html>