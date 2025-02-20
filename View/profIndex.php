<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Enregistrements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.804.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
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
        .recordings-list {
            list-style: none;
            padding: 0;
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
        audio {
            width: 250px;
        }
        /* Style du bouton de déconnexion */
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
    </style>
</head>
<body>
<button class="logout-btn" onclick="window.location.href='../logout.php'">Déconnexion</button>
<div class="container">
    <h1>Mes Enregistrements</h1>
    <a href="../transcription.php" class="btn btn-success mb-3" style="color: #225157ff;background-color: #ede1caff">Enregistrer un nouvel audio</a>

    <ul id="recordings-list" class="recordings-list">
        <p>Chargement des enregistrements...</p>
    </ul>
</div>

<script>
    AWS.config.update({
        accessKeyId: 'AKIAX5ZI6KZ2Y3RVOUAV',
        secretAccessKey: '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',
        region: 'eu-north-1'
    });

    const s3 = new AWS.S3();
    const bucketName = 'logbooktest200';
    const prefix = 'audio/';

    // Fonction pour générer l'URL signée avec Content-Disposition
    function generateDownloadUrl(fileKey) {
        const params = {
            Bucket: bucketName,
            Key: fileKey,
            Expires: 60, // L'URL signée expire après 60 secondes
            ResponseContentDisposition: 'attachment; filename="' + fileKey + '"'
        };

        s3.getSignedUrl('getObject', params, function(err, url) {
            if (err) {
                console.error("Erreur lors de la génération de l'URL signée :", err);
                return;
            }

            // Ajouter le lien de téléchargement avec l'URL signée
            const listElement = document.getElementById("recordings-list");
            const listItem = document.createElement("li");
            listItem.className = "recording-item";

            listItem.innerHTML = `
                    <span>${fileKey.replace(prefix, '')}</span>
                    <audio controls>
                        <source src="https://${bucketName}.s3.eu-north-1.amazonaws.com/${fileKey}" type="audio/wav">
                        Votre navigateur ne supporte pas l'élément audio.
                    </audio>
                    <a href="${url}" class="btn btn-primary" style="background-color: #225157ff" download>Télécharger</a>
                `;
            listElement.appendChild(listItem);
        });
    }

    function listAudioFiles() {
        s3.listObjectsV2({ Bucket: bucketName, Prefix: prefix }, function(err, data) {
            if (err) {
                console.error("Erreur lors du chargement des fichiers :", err);
                document.getElementById("recordings-list").innerHTML = "<p>❌ Erreur de chargement des fichiers.</p>";
            } else {
                const files = data.Contents.filter(file => file.Key.endsWith('.wav'));
                const listElement = document.getElementById("recordings-list");
                listElement.innerHTML = "";

                if (files.length === 0) {
                    listElement.innerHTML = "<p>Aucun enregistrement trouvé.</p>";
                } else {
                    files.forEach(file => {
                        generateDownloadUrl(file.Key); // Utiliser l'URL signée pour chaque fichier
                    });
                }
            }
        });
    }

    // Charger les fichiers au démarrage
    listAudioFiles();
</script>

</body>
</html>
