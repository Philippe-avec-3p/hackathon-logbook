<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #004D4D;
        }

        body, html {
            height: 100%;
        }

        .bg-primary-custom {
            background-color: var(--primary-color) !important;
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .error-box {
            text-align: center;
            color: #ffffff;
        }

        .error-box h1 {
            font-size: 10rem;
        }

        .error-box p {
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="bg-primary-custom">
<div class="container content">
    <div class="error-box">
        <h1>404</h1>
        <p>Page non trouvée</p>
        <a href="login.php" class="btn btn-light btn-lg text-primary-custom">Retour à l'accueil</a>
    </div>
</div>
</body>
</html>
