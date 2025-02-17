<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcription en Temps Réel</title>
    <!-- Lien vers le CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #transcription {
            font-size: 1.5em;
            margin-top: 20px;
        }
        #micButton {
            font-size: 2em;
            cursor: pointer;
            transition: color 0.3s;
        }
        #micButton.active {
            color: green;
        }
        #micButton.inactive {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="my-4">Transcription en Temps Réel</h1>
    <p>Commencez à parler et votre discours sera transcrit ici :</p>
    <button id="micButton" class="btn btn-light inactive">
        🎤
    </button>
    <div id="transcription">Votre transcription apparaîtra ici...</div>
</div>

<script>
    // Vérifier la compatibilité du navigateur avec l'API Web Speech
    if ('webkitSpeechRecognition' in window) {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'fr-FR';

        // Sélectionner le bouton et la div de transcription
        const micButton = document.getElementById('micButton');
        const transcriptionDiv = document.getElementById('transcription');

        // Variable pour suivre l'état de la reconnaissance
        let isRecognizing = false;

        // Fonction pour démarrer la reconnaissance vocale
        function startRecognition() {
            recognition.start();
            isRecognizing = true;
            micButton.classList.remove('inactive');
            micButton.classList.add('active');
        }

        // Fonction pour arrêter la reconnaissance vocale
        function stopRecognition() {
            recognition.stop();
            isRecognizing = false;
            micButton.classList.remove('active');
            micButton.classList.add('inactive');
        }

        // Écouter les résultats de la reconnaissance
        recognition.onresult = function(event) {
            let transcript = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
                transcript += event.results[i][0].transcript;
            }
            // Afficher la transcription en temps réel
            transcriptionDiv.innerText = transcript;
        };

        // Gérer les erreurs
        recognition.onerror = function(event) {
            console.error('Erreur de reconnaissance vocale:', event.error);
        };

        // Ajouter un événement de clic au bouton
        micButton.addEventListener('click', function() {
            if (isRecognizing) {
                stopRecognition();
            } else {
                startRecognition();
            }
        });
    } else {
        console.log('API Web Speech non supportée par ce navigateur.');
    }
</script>

<!-- Lien vers le JS de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
