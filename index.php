<?php
include('includes/db.php');

// Gestion de la catégorie
$categories_valides = ['Accueil', 'Sport', 'Santé', 'Education', 'Politique'];
$emojis = ['Sport' => '⚽️', 'Santé' => '🩺', 'Education' => '📚', 'Politique' => '🏛️'];

$categorie = $_GET['categorie'] ?? 'Accueil';
if (!in_array($categorie, $categories_valides)) {
    $categorie = 'Accueil';
}

// Conversion du libellé en ID de catégorie
$categorie_id = array_search($categorie, $categories_valides);

$where = $categorie !== 'Accueil' ? "WHERE categorie = ?" : "";
$params = $categorie !== 'Accueil' ? [$categorie_id] : [];

try {
    // Modification ici pour utiliser la table Article et jointure avec Categorie
    $sql = "SELECT a.*, c.libelle as categorie_nom 
            FROM Article a
            JOIN Categorie c ON a.categorie = c.id
            $where 
            ORDER BY a.dateCreation DESC 
            LIMIT 12";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $actualites = [];
    error_log("Erreur DB: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>

<header>
    <h1 align="center">📰 Actualités Polytechniciennes</h1>
    <div class="category-buttons" align="center">
        <?php foreach ($categories_valides as $cat): ?>
            <a href="?categorie=<?= urlencode($cat) ?>" 
   class="category-btn <?= $categorie === $cat ? 'active' : '' ?>">
   <span class="emoji"><?= $emojis[$cat] ?? '' ?></span>
   <span><?= $cat ?></span>
</a>
        <?php endforeach; ?>
    </div>
</header>


<main class="container py-4">
    <h2 class="mb-4 text-center"><?= $emojis[$categorie] ?? '' ?> <?= htmlspecialchars($categorie) ?></h2>

    <?php if (count($actualites)): ?>
        <div class="row">
            <?php foreach ($actualites as $news): ?>
                <div class="col-12">
                    <div class="news-card full-width-card">
                        <h3><?= htmlspecialchars($news['titre']) ?></h3>
                        <div class="news-content">
                            <?= nl2br(htmlspecialchars($news['contenu'])) ?>
                        </div>
                        <div class="news-meta">
                            <!-- Modification ici pour utiliser categorie_nom -->
                            <span>Catégorie : <?= htmlspecialchars($news['categorie_nom']) ?></span>
                            <!-- Modification ici pour utiliser dateCreation -->
                            <span>Publié le : <?= date('d/m/Y H:i', strtotime($news['dateCreation'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center mt-5">
            <p class="text-muted fs-4">Aucune actualité trouvée.</p>
        </div>
    <?php endif; ?>
</main>

<!-- [Le reste du footer et scripts JS reste identique] -->

</body>
</html>