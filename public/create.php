<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    createTask($pdo, $_POST);

    // Redirection après POST
    header('Location: index.php');
    exit;
}

$priorites = $pdo->query("SELECT * FROM priorite")->fetchAll();
$statuts = $pdo->query("SELECT * FROM statut")->fetchAll();
$categories = $pdo->query("SELECT * FROM categorie")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une tâche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        h1 {
            margin-bottom: 20px;
        }

        /* ===== FORMULAIRE ===== */
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        label {
            display: block;
            margin-top: 12px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* ===== BOUTON ===== */
        button {
            margin-top: 15px;
            padding: 10px 15px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #27ae60;
        }

        /* ===== LIEN RETOUR ===== */
        .back {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #3498db;
        }

        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Ajouter une tâche</h1>

<form method="POST">

    <label>Titre :</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description :</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Date échéance :</label><br>
    <input type="date" name="dateEcheance"><br><br>

    <label>Priorité :</label><br>
    <select name="idPriorite">
        <?php foreach ($priorites as $p): ?>
            <option value="<?= $p['idPriorite'] ?>">
                <?= $p['priorite'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Statut :</label><br>
    <select name="idStatut">
        <?php foreach ($statuts as $s): ?>
            <option value="<?= $s['idStatut'] ?>">
                <?= $s['statut'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Catégorie :</label><br>
    <select name="idCategorie">
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['idCategorie'] ?>">
                <?= $c['categorie'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Créer</button>
</form>

<p><a href="index.php">Retour</a></p>

</body>
</html>