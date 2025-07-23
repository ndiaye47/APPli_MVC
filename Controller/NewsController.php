<?php
require_once 'Model/News.php';
require_once 'db.php';
class NewsController {
    private $newsModel;

    public function __construct(PDO $pdo) {
        $this->newsModel = new News($pdo);
    }

    public function index() {
        $category = isset($_GET['categorie']) ? (int)$_GET['categorie'] : null;
        $news = $this->newsModel->getAllNews($category);
        $categories = $this->newsModel->getCategories();
        require 'View/news/index.php';
    }

    public function add() {
        $message = '';
        $categories = $this->newsModel->getCategories();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
            $content = filter_input(INPUT_POST, 'contenu', FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_POST, 'categorie', FILTER_VALIDATE_INT);

            if ($title && $content && $category) {
                if ($this->newsModel->addNews($title, $content, $category)) {
                    $message = "Actualité ajoutée avec succès !";
                } else {
                    $message = "Erreur lors de l'ajout de l'actualité.";
                }
            } else {
                $message = "Tous les champs sont obligatoires et doivent être valides.";
            }
        }
        require 'View/news/add.php';
    }
}
?>