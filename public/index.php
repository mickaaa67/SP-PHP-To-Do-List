<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

/**
 * Récupération des tâches
 */
$tasks = getAllTasks($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>To Do List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #222;
            color: white;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
        }

        .edit {
            background: #3498db;
        }

        .delete {
            background: #e74c3c;
        }

        .create {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #2ecc71;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .tag {
            display: inline-block;
            padding: 3px 8px;
            background: #eee;
            border-radius: 12px;
            margin-right: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<h1>📋 To Do List</h1>

<a class="create" href="create.php">+ Ajouter une tâche</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Création</th>
            <th>Échéance</th>
            <th>Priorité</th>
            <th>Statut</th>
            <th>Catégorie</th>
            <th>Tags</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ($tasks as $task): ?>

        <?php
        // récupération des tags pour chaque tâche
        $stmt = $pdo->prepare("
            SELECT tag.tag
            FROM tag
            JOIN tache_tag tt ON tt.idTag = tag.idTag
            WHERE tt.idTache = ?
        ");
        $stmt->execute([$task['idTache']]);
        $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
        ?>

        <tr>
            <td><?= $task['idTache'] ?></td>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= $task['dateCreation'] ?></td>
            <td><?= $task['dateEcheance'] ?></td>
            <td><?= $task['priorite'] ?></td>
            <td><?= $task['statut'] ?></td>
            <td><?= $task['categorie'] ?></td>

            <td>
                <?php foreach ($tags as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            </td>

            <td class="actions">
                <a class="edit" href="edit.php?id=<?= $task['idTache'] ?>">Modifier</a>
                <a class="delete" href="delete.php?id=<?= $task['idTache'] ?>"
                   onclick="return confirm('Supprimer cette tâche ?')">
                    Supprimer
                </a>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

</body>
</html>