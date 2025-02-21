<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook - Inscription</title>
    <style>
        :root {
            --primary-color: #004D4D;
            --secondary-color: #00A3A3;
            --transition-duration: 0.4s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .left-panel {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem;
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transform: translateX(-100%);
            animation: slideInLeft var(--transition-duration) ease-out forwards;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.2s forwards;
        }

        .slogan {
            font-size: 1.2rem;
            line-height: 1.4;
            margin-bottom: 2rem;
            text-align: center;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.4s forwards;
        }

        .image-container {
            border-radius: 1rem;
            overflow: hidden;
            margin-top: 2rem;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.6s forwards;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 1rem;
        }

        .right-panel {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transform: translateX(100%);
            animation: slideInRight var(--transition-duration) ease-out forwards;
        }

        .connect-header {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.2s forwards;
        }

        .form-group {
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.4s forwards;
        }

        .form-group label {
            display: block;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #E6E6E6;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .submit-button {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 2rem;
            transition: background-color var(--transition-duration);
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.6s forwards;
        }

        .submit-button:hover {
            background-color: var(--secondary-color);
        }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            opacity: 0;
            animation: fadeIn var(--transition-duration) 0.8s forwards;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Animations */
        @keyframes slideInLeft {
            to {
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<div class="left-panel">
    <div class="image-container">
        <img src="style/img/logo.svg" alt="Logo logbook">
    </div>
    <div class="slogan">Des corrections à l'oral pour motiver les élèves et soulager les enseignants</div>
    <div class="image-container">
        <img src="style/img/logbook_connect.jpeg" alt="Enseignant utilisant Logbook">
    </div>
</div>

<div class="right-panel">
    <h1 class="connect-header">Inscrivez-vous</h1>
    <form action="Controller/RegisterController" method="POST">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="nom">Nom de famille</label>
            <input type="text" id="nom" name="nom" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-input" required>
        </div>

        <button type="submit" class="submit-button">Créer un compte</button>
    </form>
    <div class="login-link">
        <b><a href="login.php">Vous avez déjà un compte Logbook ? Connectez-vous ici</a></b>
    </div>
</div>
</body>
</html>
