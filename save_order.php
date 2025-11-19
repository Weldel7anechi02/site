<?php
session_start();
include 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: accueil.php?error=" . urlencode("Vous devez être connecté pour passer une commande."));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: print current database name and tables
    try {
        $stmtDb = $pdo->query("SELECT DATABASE() as dbname");
        $dbname = $stmtDb->fetch(PDO::FETCH_ASSOC)['dbname'];
        echo "Connected to database: " . $dbname . "<br>";

        $stmtTables = $pdo->query("SHOW TABLES");
        $tables = $stmtTables->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables in database: " . implode(", ", $tables) . "<br>";
    } catch (PDOException $e) {
        echo "Error fetching database info: " . $e->getMessage() . "<br>";
    }

    $user_id = $_SESSION['user_id'];
    $address = trim($_POST['address']);
    $payment_method = $_POST['payment'];
    $cart_items = json_decode($_POST['cart_items'], true);

    if (empty($address) || empty($payment_method) || empty($cart_items)) {
        echo "Données de commande invalides.<br>";
        exit();
    }

    // Get user details
    try {
        $stmt = $pdo->prepare("SELECT nom, prenom, cin, email FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Utilisateur non trouvé.<br>";
            exit();
        }

        $nom = $user['nom'];
        $prenom = $user['prenom'];
        $cin = $user['cin'];
        $email = $user['email'];

        // Calculate total
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'];
        }

        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, nom, prenom, cin, email, address, payment_method, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'confirmed')");
        $stmt->execute([$user_id, $nom, $prenom, $cin, $email, $address, $payment_method, $total]);
        $order_id = $pdo->lastInsertId();

        // Insert order items
        $stmt2 = $pdo->prepare("INSERT INTO order_items (order_id, item_title, item_date, item_price) VALUES (?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $stmt2->execute([$order_id, $item['title'], $item['date'], $item['price']]);
        }

        // Redirect to success
        header("Location: panier.php?success=order");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de la sauvegarde de la commande: " . $e->getMessage() . "<br>";
        exit();
    }
} else {
    header("Location: panier.php");
    exit();
}
?>
