<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcription et Enregistrement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        h1 {
            font-size: 1.8rem;
            color: #004d40;
            text-align: center;
        }
        #transcription {
            font-size: 1.1em;
            padding: 10px;
            border: 1px solid #ddd;
            min-height: 80px;
            background: #f1f1f1;
            border-radius: 5px;
        }
        #micButton {
            width: 100%;
            font-size: 1.5em;
        }
        .waveform-container {
            margin-top: 15px;
        }
        #waveform {
            width: 100%;
            height: 60px;
            background: #e0e0e0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Transcription et Enregistrement</h1>
    <p class="text-center">Appuyez sur le bouton et commencez à parler :</p>
    <button id="micButton" class="btn btn-success">🎤 Démarrer</button>
    <a id="downloadButton" class="btn btn-primary mt-2 w-100" style="display:none;" download="enregistrement.wav">⬇️ Télécharger</a>
    <div class="waveform-container">
        <div id="waveform"></div>
        <button id="playButton" class="btn btn-info w-100 mt-2" style="display:none;">▶️ Lecture</button>
    </div>
    <div id="transcription" class="mt-3">Votre transcription apparaîtra ici...</div>
</div>

<script>
    if ('webkitSpeechRecognition' in window && 'MediaRecorder' in window) {
        const recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'fr-FR';
        const micButton = document.getElementById('micButton');
        const downloadButton = document.getElementById('downloadButton');
        const playButton = document.getElementById('playButton');
        const transcriptionDiv = document.getElementById('transcription');
        let isRecording = false;
        let mediaRecorder;
        let audioChunks = [];
        let finalTranscript = "";
        let wavesurfer = WaveSurfer.create({
            container: '#waveform',
            waveColor: '#007bff',
            progressColor: '#0056b3',
            cursorColor: '#000',
            barWidth: 2,
            height: 60,
            responsive: true
        });
        navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            };
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                const audioUrl = URL.createObjectURL(audioBlob);
                downloadButton.href = audioUrl;
                downloadButton.style.display = 'block';
                playButton.style.display = 'block';
                wavesurfer.load(audioUrl);
                audioChunks = [];
            };
        }).catch(error => console.error('Erreur micro:', error));
        function startRecording() {
            recognition.start();
            mediaRecorder.start();
            isRecording = true;
            micButton.classList.remove('btn-success');
            micButton.classList.add('btn-danger');
            micButton.innerText = '⏹️ Arrêter';
        }
        function stopRecording() {
            recognition.stop();
            mediaRecorder.stop();
            isRecording = false;
            micButton.classList.remove('btn-danger');
            micButton.classList.add('btn-success');
            micButton.innerText = '🎤 Démarrer';
        }
        recognition.onresult = function(event) {
            let interimTranscript = "";
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript + ". ";
                } else {
                    interimTranscript = event.results[i][0].transcript;
                }
            }
            transcriptionDiv.innerHTML = finalTranscript + `<span style="color:gray;">${interimTranscript}</span>`;
        };
        micButton.addEventListener('click', function() {
            isRecording ? stopRecording() : startRecording();
        });
        playButton.addEventListener('click', function() {
            wavesurfer.playPause();
        });
    } else {
        console.log('API Web Speech ou MediaRecorder non supportée.');
    }
</script>
</body>
</html>
