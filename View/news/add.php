<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une actualité - Actualités Polytechniciennes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/script.js" defer></script>
</head>
<body>
    
    <main class="container">
        <h2 class="main-title">Ajouter une nouvelle actualité</h2>

        <?php
        // Initialisation des variables
        $message = '';
        $titre = '';
        $contenu = '';
        $categorie = '';

        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=mglsi_news', 'mglsi_user', 'passer');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Traitement du formulaire lorsqu'il est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et validation des données
            $titre = trim($_POST['titre'] ?? '');
            $contenu = trim($_POST['contenu'] ?? '');
            $categorie = trim($_POST['categorie'] ?? '');

            // Validation des champs
            $errors = [];
            if (empty($titre)) {
                $errors[] = 'Le titre est requis';
            }
            if (empty($contenu)) {
                $errors[] = 'Le contenu est requis';
            }
            if (empty($categorie)) {
                $errors[] = 'La catégorie est requise';
            }

            // Si aucune erreur, insertion dans la base de données
            if (empty($errors)) {
                try {
                    // Récupération de l'ID de la catégorie
                    $stmt = $db->prepare("SELECT id FROM Categorie WHERE libelle = ?");
                    $stmt->execute([$categorie]);
                    $categorieId = $stmt->fetchColumn();

                    if ($categorieId) {
                        // Insertion de l'article
                        $stmt = $db->prepare("INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)");
                        $stmt->execute([$titre, $contenu, $categorieId]);
                        
                        $message = 'Actualité ajoutée avec succès!';
                        // Réinitialisation des champs après succès
                        $titre = '';
                        $contenu = '';
                        $categorie = '';
                    } else {
                        $message = 'Catégorie invalide';
                    }
                } catch (PDOException $e) {
                    $message = 'Erreur lors de l\'ajout de l\'actualité: ' . $e->getMessage();
                }
            } else {
                $message = implode('<br>', $errors);
            }
        }
        ?>

        <?php if (!empty($message)): ?>
            <div class="alert <?= strpos($message, 'succès') !== false ? 'alert-success' : 'alert-danger' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-right: 0.5rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post" novalidate>
                <div class="form-group">
                    <label for="titre" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Titre de l'actualité
                    </label>
                    <input 
                        type="text" 
                        id="titre" 
                        name="titre" 
                        class="form-input" 
                        placeholder="Saisissez le titre de votre actualité..."
                        required
                        maxlength="255"
                        value="<?= htmlspecialchars($titre) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="contenu" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Contenu de l'actualité
                    </label>
                    <textarea 
                        id="contenu" 
                        name="contenu" 
                        class="form-textarea" 
                        placeholder="Rédigez le contenu de votre actualité..."
                        required
                        rows="6"
                    ><?= htmlspecialchars($contenu) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="categorie" class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Catégorie
                    </label>
                    <select id="categorie" name="categorie" class="form-select" required>
                        <option value="">Choisissez une catégorie...</option>
                        <option value="Sport" <?= $categorie === 'Sport' ? 'selected' : '' ?>>Sport</option>
                        <option value="Santé" <?= $categorie === 'Santé' ? 'selected' : '' ?>>Santé</option>
                        <option value="Education" <?= $categorie === 'Education' ? 'selected' : '' ?>>Education</option>
                        <option value="Politique" <?= $categorie === 'Politique' ? 'selected' : '' ?>>Politique</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <a href="index.php" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter l'actualité
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>
</html>