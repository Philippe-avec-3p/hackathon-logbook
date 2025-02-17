<?php
session_start();
include "public/theme.php"
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook - Connexion</title>
    <style>
        :root {
            --primary-color: #004D4D;
            --secondary-color: #00A3A3;
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
        }

        .left-panel {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem;
            width: 40%;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .slogan {
            font-size: 1.2rem;
            line-height: 1.4;
            margin-bottom: 2rem;
            text-align: center;
        }

        .image-container {
            border-radius: 1rem;
            overflow: hidden;
            margin-top: 2rem;
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
        }

        .connect-header {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .space-buttons {
            display: flex;
            gap: 2rem;
            margin-bottom: 3rem;
            width: 100%;
            border-bottom: 2px solid #E6E6E6;
        }

        .space-button {
            padding: 1rem 0;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            border: none;
            background: none;
            cursor: pointer;
            position: relative;
        }

        .space-button.active {
            color: var(--secondary-color);
        }

        .space-button.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .login-form {
            width: 100%;
            max-width: 500px;
            display: none;
        }

        .login-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 2rem;
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

        .password-input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
        }

        .secret-key-inputs {
            display: flex;
            gap: 0.5rem;
        }

        .secret-key-inputs input {
            width: 50px;
            height: 50px;
            text-align: center;
            border: 1px solid #E6E6E6;
            border-radius: 0.5rem;
            font-size: 1.2rem;
        }

        .name-inputs {
            display: flex;
            gap: 0.5rem;
        }

        .name-inputs input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #E6E6E6;
            border-radius: 0.5rem;
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
        }

        .forgot-password {
            text-align: right;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #666;
            text-decoration: none;
        }

        .register-link {
            color: var(--primary-color);
            text-decoration: none;
            margin-top: 2rem;
            display: inline-block;
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
    <h1 class="connect-header">Connectez-vous</h1>
    <?php if(isset($_SESSION['error'])){ echo $_SESSION['error'];}?>
    <div class="space-buttons">
        <button class="space-button active" id="teacher-space">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Espace enseignant
        </button>
        <button class="space-button" id="student-space">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
            </svg>
            Espace étudiant
        </button>
    </div>

    <!-- Formulaire Enseignant -->
    <form class="login-form active" id="teacher-form" action="Controller/LoginController" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-input" required>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <div class="password-input-container">
                <input type="password" name="password" class="form-input" required>
                <button type="button" class="password-toggle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="forgot-password">
            <a href="#">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="submit-button">Se connecter</button>

        <a href="#" class="register-link">Inscrivez vous sur Logbook</a>
    </form>

    <!-- Formulaire Étudiant -->
    <form class="login-form" id="student-form">
        <div class="form-group">
            <label>Quelle est votre clef secrète ?</label>
            <div class="secret-key-inputs">
                <input type="text" maxlength="1" class="key-input" required>
                <input type="text" maxlength="1" class="key-input" required>
                <input type="text" maxlength="1" class="key-input" required>
                <input type="text" maxlength="1" class="key-input" required>
                <input type="text" maxlength="1" class="key-input" required>
                <input type="text" maxlength="1" class="key-input" required>
            </div>
        </div>

        <div class="form-group">
            <label>Quelles sont les 3 premières lettres de votre prénom ?</label>
            <div class="name-inputs">
                <input type="text" maxlength="3" required>
                <input type="text" maxlength="3" required>
                <input type="text" maxlength="3" required>
            </div>
        </div>

        <button type="submit" class="submit-button">Se connecter</button>
    </form>
</div>

<script>
    // Gestionnaire pour la navigation entre les espaces
    const teacherSpace = document.getElementById('teacher-space');
    const studentSpace = document.getElementById('student-space');
    const teacherForm = document.getElementById('teacher-form');
    const studentForm = document.getElementById('student-form');

    teacherSpace.addEventListener('click', () => {
        teacherSpace.classList.add('active');
        studentSpace.classList.remove('active');
        teacherForm.classList.add('active');
        studentForm.classList.remove('active');
    });

    studentSpace.addEventListener('click', () => {
        studentSpace.classList.add('active');
        teacherSpace.classList.remove('active');
        studentForm.classList.add('active');
        teacherForm.classList.remove('active');
    });

    // Gestionnaire pour les inputs de la clé secrète
    const keyInputs = document.querySelectorAll('.key-input');
    keyInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value && index < keyInputs.length - 1) {
                keyInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                keyInputs[index - 1].focus();
            }
        });
    });

    // Gestionnaire pour afficher/masquer le mot de passe
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            const input = e.target.closest('.password-input-container').querySelector('input');
            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        });
    });
</script>
</body>
</html>
