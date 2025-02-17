<?php include('public/theme.php'); session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body, html {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #F2F2F2;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="card" style="width: 30rem; height: 25rem;">
        <div class="text-center">
            <img src="style/img/test.png" alt="" class="img-fluid">
        </div>
        <div class="text-center">
            <?php
            if (isset($_SESSION['error'])){
                echo $_SESSION['error'];} ?>
        </div>
        <div class="card-body">
            <form method="post" action="Controller/LoginController.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
