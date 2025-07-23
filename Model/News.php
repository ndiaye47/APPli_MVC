<?php
class News {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllNews($category = null) {
        $sql = "SELECT a.*, c.libelle as categorie_libelle 
                FROM Article a
                JOIN Categorie c ON a.categorie = c.id";
        
        $params = [];
        if ($category) {
            $sql .= " WHERE a.categorie = ?";
            $params[] = $category;
        }
        $sql .= " ORDER BY a.dateCreation DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNews($title, $content, $category) {
    try {
        // Validation supplémentaire des données
        if (empty($title) || empty($content) || empty($category)) {
            throw new InvalidArgumentException("Tous les champs sont obligatoires");
        }

        if (strlen($title) > 255) {
            throw new InvalidArgumentException("Le titre ne doit pas dépasser 255 caractères");
        }

        // Vérification que la catégorie existe
        $stmtCheck = $this->pdo->prepare("SELECT id FROM Categorie WHERE id = ?");
        $stmtCheck->execute([$category]);
        if (!$stmtCheck->fetch()) {
            throw new InvalidArgumentException("Catégorie invalide");
        }

        // Préparation de la requête avec des noms de colonnes explicites
        $stmt = $this->pdo->prepare("
            INSERT INTO Article 
            (titre, contenu, categorie, dateCreation, dateModification) 
            VALUES (:titre, :contenu, :categorie, NOW(), NOW())
        ");

        // Exécution avec des paramètres nommés pour plus de clarté
        $success = $stmt->execute([
            ':titre' => $title,
            ':contenu' => $content,
            ':categorie' => $category
        ]);

        // Vérification du succès de l'insertion
        if (!$success || $stmt->rowCount() === 0) {
            throw new RuntimeException("Échec de l'insertion dans la base de données");
        }

        // Retourne l'ID du nouvel article si besoin
        return $this->pdo->lastInsertId();

    } catch (PDOException $e) {
        // Journalisation de l'erreur
        error_log("Erreur lors de l'ajout de l'article: " . $e->getMessage());
        
        // Vous pourriez aussi logger des informations supplémentaires
        error_log("Données essayées - Titre: $title, Catégorie: $category");
        
        // Relancer l'exception pour que le contrôleur puisse la gérer
        throw new RuntimeException("Une erreur est survenue lors de l'ajout de l'article. Veuillez réessayer.");
    }
}
    public function getCategories() {
        $stmt = $this->pdo->prepare("SELECT * FROM Categorie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>