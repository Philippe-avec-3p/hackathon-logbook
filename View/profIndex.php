<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Enregistrements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.804.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            opacity: 0;  /* La page est invisible au début */
            transform: translateX(-100%);  /* Positionnée hors de l'écran à gauche */
            transition: opacity 1s ease-out, transform 1s ease-out;  /* Transition fluide pour le fondu et le glissement */
        }

        body.loaded {
            opacity: 1;  /* La page devient visible */
            transform: translateX(0);  /* Le contenu glisse pour arriver à sa position normale */
        }



        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #004d40;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        #recordings-list {
            width: 100%;
            margin-top: 20px;
        }

        .recording-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
            background: #ffffff;
        }

        .btn-secondary {
            background-color: #225157ff;
        }
    </style>
</head>
<body>
<button class="logout-btn" onclick="window.location.href='../logout.php'">Déconnexion</button>
<div class="container">
    <h1>Mes Enregistrements</h1>
    <a href="../transcription.php" class="btn btn-success mb-3" style="color: #225157ff;background-color: #ede1caff">Enregistrer un nouvel audio</a>

    <!-- DataTable -->
    <table id="recordings-table" class="display">
        <thead>
        <tr>
            <th>Nom de l'Enregistrement</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="recordings-list">
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="recordingModal" tabindex="-1" aria-labelledby="recordingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recordingModalLabel">Détails de l'Enregistrement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Section pour l'audio -->
                <div class="section" id="audioSection">
                    <h5>Écouter l'Audio</h5>
                    <audio controls id="audioPlayer">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                </div>

                <!-- Section pour la transcription -->
                <div class="section" id="transcriptionSection">
                    <h5>Transcription</h5>
                    <div id="transcriptionContent" class="transcription-text">
                        Chargement de la transcription...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Boutons pour télécharger audio et transcription -->
                <a id="downloadAudioBtn" href="#" class="btn btn-primary" download>Télécharger Audio</a>
                <a id="downloadTextBtn" href="#" class="btn btn-secondary" download>Télécharger Transcription</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Attendre que la page soit entièrement chargée
    window.onload = function() {
        // Ajouter la classe 'loaded' au body une fois le chargement terminé
        document.body.classList.add('loaded');
    };

    AWS.config.update({
        accessKeyId: 'AKIAX5ZI6KZ2Y3RVOUAV',
        secretAccessKey: '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',
        region: 'eu-north-1'
    });

    const s3 = new AWS.S3();
    const bucketName = 'logbooktest200';
    const audioPrefix = 'audio/';
    const textPrefix = 'text/';

    // Obtenez le nom et le prénom de la session PHP
    const sessionNom = "<?php echo $_SESSION['nom']; ?>";
    const sessionPrenom = "<?php echo $_SESSION['prenom']; ?>";

    function generateDownloadUrl(fileKey) {
        const params = {
            Bucket: bucketName,
            Key: fileKey,
            Expires: 360,
            ResponseContentDisposition: 'attachment; filename="' + fileKey + '"'
        };

        return new Promise((resolve, reject) => {
            s3.getSignedUrl('getObject', params, function(err, url) {
                if (err) {
                    console.error("Erreur lors de la génération de l'URL signée :", err);
                    reject(err);
                    return;
                }
                resolve(url);
            });
        });
    }

    function listFilesWithTranscriptions() {
        s3.listObjectsV2({ Bucket: bucketName, Prefix: audioPrefix }, function(err, data) {
            if (err) {
                console.error("Erreur lors du chargement des fichiers audio :", err);
                document.getElementById("recordings-list").innerHTML = "<p>❌ Erreur de chargement des fichiers.</p>";
            } else {
                const audioFiles = data.Contents.filter(file => file.Key.endsWith('.wav'));
                const listElement = document.getElementById("recordings-list");
                listElement.innerHTML = "";

                if (audioFiles.length === 0) {
                    listElement.innerHTML = "<p>Aucun enregistrement trouvé.</p>";
                } else {
                    audioFiles.forEach(async (audioFile) => {
                        const fileName = audioFile.Key.replace(audioPrefix, '').replace('.wav', '');

                        // Filtrer les fichiers en fonction du nom et prénom de l'utilisateur
                        if (fileName.includes(sessionNom) && fileName.includes(sessionPrenom)) {
                            const audioUrl = await generateDownloadUrl(audioFile.Key);
                            const fileNameWithoutExtension = audioFile.Key.replace(audioPrefix, '').replace('.wav', '');

                            // Chercher la transcription correspondante
                            const textFileKey = textPrefix + fileNameWithoutExtension + '.txt';

                            try {
                                const textUrl = await generateDownloadUrl(textFileKey);

                                // Ajouter l'audio et la transcription à la liste dans le tableau
                                const row = `<tr>
                                    <td>${fileNameWithoutExtension}</td>
                                    <td><button class="btn btn-secondary" style="background-color: #225157ff;" onclick="openRecordingModal('${audioUrl}', '${textUrl}', '${fileNameWithoutExtension}')">Afficher</button></td>
                                </tr>`;
                                listElement.innerHTML += row;
                            } catch (error) {
                                console.error(`Erreur lors de la récupération de la transcription pour ${fileNameWithoutExtension}:`, error);
                            }
                        }
                    });
                }
            }
        });
    }

    // Charger les fichiers audio et leurs transcriptions au démarrage
    listFilesWithTranscriptions();

    // Initialiser DataTable après avoir chargé les enregistrements
    $(document).ready(function() {
        $('#recordings-table').DataTable();
    });

    // Fonction pour ouvrir le modal avec l'audio et la transcription
    function openRecordingModal(audioUrl, textUrl, fileName) {
        // Charger l'audio
        document.getElementById('audioPlayer').src = audioUrl;

        // Charger la transcription
        fetch(textUrl)
            .then(response => response.text())
            .then(data => {
                document.getElementById('transcriptionContent').innerText = data;
            })
            .catch(error => {
                console.error("Erreur lors de la récupération du texte de la transcription:", error);
            });

        // Mettre à jour les liens de téléchargement
        document.getElementById('downloadAudioBtn').href = audioUrl;
        document.getElementById('downloadTextBtn').href = textUrl;

        // Afficher le modal
        var myModal = new bootstrap.Modal(document.getElementById('recordingModal'));
        myModal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
