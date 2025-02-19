<?php
require_once '../config/database.php';
require_once '../controllers/ContatoController.php';

// Configuração da conexão com o banco de dados
class Database {
    private static $host = 'localhost';
    private static $db_name = 'cadastros_alphacode';
    private static $username = 'root';
    private static $password = '';
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

$contatoController = new ContatoController();
$contatos = $contatoController->index();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['salvar'])) {
        $contatoController->store($_POST);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['editar'])) {
        $contatoController->update($_POST);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['excluir'])) {
        $contatoController->destroy($_POST['id']);
        header("Location: index.php");
        exit();
    }
}
?>
