<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités Polytechniciennes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/script.js" defer></script>
</head>
<body>
    <!-- <header class="header">
        <div class="header-content">
            <h1>ACTUALITÉS POLYTECHNICIENNES</h1>
            <nav class="nav">
                <div class="nav-item">
                    <a href="index.php" class="nav-link <?= !isset($_GET['categorie']) ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Accueil
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?categorie=Sport" class="nav-link <?= isset($_GET['categorie']) && $_GET['categorie'] === 'Sport' ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Sport
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?categorie=Santé" class="nav-link <?= isset($_GET['categorie']) && $_GET['categorie'] === 'Santé' ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Santé
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?categorie=Education" class="nav-link <?= isset($_GET['categorie']) && $_GET['categorie'] === 'Education' ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Education
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?categorie=Politique" class="nav-link <?= isset($_GET['categorie']) && $_GET['categorie'] === 'Politique' ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Politique
                    </a>
                </div>
                <div class="nav-item">
                    <a href="index.php?action=add" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter
                    </a>
                </div>
            </nav>
        </div>
    </header> -->

    <main class="container">
        <h2 class="main-title">
            <?php if (isset($_GET['categorie'])): ?>
                Actualités - <?= htmlspecialchars($_GET['categorie']) ?>
            <?php else: ?>
                Les dernières actualités
            <?php endif; ?>
        </h2>

        <?php if (empty($news)): ?>
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3>Aucune actualité disponible</h3>
                <p>Il n'y a pas encore d'actualités dans cette catégorie.</p>
            </div>
        <?php else: ?>
            <div class="news-grid">
                <?php foreach ($news as $actu): ?>
                    <article class="news-card">
                        <h3 class="news-title"><?= htmlspecialchars($actu['titre']) ?></h3>
                        <div class="news-content"><?= htmlspecialchars($actu['contenu']) ?></div>
                        <div class="news-meta">
                            <span class="news-category"><?= htmlspecialchars($actu['categorie']) ?></span>
                            <time class="news-date"><?= $actu['date_publication'] ?></time>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="../../js/script.js"></script>
</body>
</html>

