<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID manquant');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateTask($pdo, $id, $_POST);

    // Redirection après POST
    header('Location: index.php');
    exit;
}

$task = getTaskById($pdo, $id);

$priorites = $pdo->query("SELECT * FROM priorite")->fetchAll();
$statuts = $pdo->query("SELECT * FROM statut")->fetchAll();
$categories = $pdo->query("SELECT * FROM categorie")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une tâche</title>
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

<h1>Modifier une tâche</h1>

<form method="POST">

    <label>Titre :</label><br>
    <input type="text" name="title"
           value="<?= htmlspecialchars($task['title']) ?>" required><br><br>

    <label>Description :</label><br>
    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea><br><br>

    <label>Date échéance :</label><br>
    <input type="date" name="dateEcheance"
           value="<?= $task['dateEcheance'] ?>"><br><br>

    <label>Priorité :</label><br>
    <select name="idPriorite">
        <?php foreach ($priorites as $p): ?>
            <option value="<?= $p['idPriorite'] ?>"
                <?= $task['idPriorite'] == $p['idPriorite'] ? 'selected' : '' ?>>
                <?= $p['priorite'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Statut :</label><br>
    <select name="idStatut">
        <?php foreach ($statuts as $s): ?>
            <option value="<?= $s['idStatut'] ?>"
                <?= $task['idStatut'] == $s['idStatut'] ? 'selected' : '' ?>>
                <?= $s['statut'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Catégorie :</label><br>
    <select name="idCategorie">
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['idCategorie'] ?>"
                <?= $task['idCategorie'] == $c['idCategorie'] ? 'selected' : '' ?>>
                <?= $c['categorie'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Modifier</button>
</form>

<p><a href="index.php">Retour</a></p>

</body>
</html>