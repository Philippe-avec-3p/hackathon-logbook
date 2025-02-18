<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes enregistrements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        .left-panel {
            background-color: #004D4D;
            color: white;
            padding: 3rem;
            width: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .slogan {
            font-size: 1.2rem;
            text-align: center;
        }

        .right-panel {
            flex: 1;
            padding: 3rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .new-audio-button {
            background-color: #004D4D;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .recordings-list {
            list-style: none;
            padding: 0;
        }

        .recording-item {
            padding: 1rem;
            border: 1px solid #ddd;
            margin-bottom: 1rem;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="left-panel">
    <div class="logo">Logbook</div>
</div>

<div class="right-panel">
    <div class="header">
        <h1>Mes enregistrements</h1>
        <button class="new-audio-button" onclick="window.location.href='../transcription.php'">Nouveau audio</button>
    </div>

    <ul class="recordings-list">
        <li class="recording-item">Enregistrement 1 <button>Écouter</button></li>
        <li class="recording-item">Enregistrement 2 <button>Écouter</button></li>
        <li class="recording-item">Enregistrement 3 <button>Écouter</button></li>
    </ul>
</div>
</body>
</html>
