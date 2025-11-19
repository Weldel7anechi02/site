<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: accueil.php?error=" . urlencode("Vous devez être connecté pour voir l'historique des commandes."));
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch orders for the logged-in user
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des commandes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des commandes - ABC Construction</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1>ABC Construction</h1>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="articles.php">Articles</a></li>
                <li><a href="panier.php">Panier</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <h2>Historique des commandes</h2>
        <?php if (count($orders) === 0): ?>
            <p>Aucune commande trouvée.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <h3>Commande #<?php echo htmlspecialchars($order['id']); ?> - <?php echo htmlspecialchars($order['order_date']); ?></h3>
                    <p><strong>Nom:</strong> <?php echo htmlspecialchars($order['nom'] . ' ' . $order['prenom']); ?></p>
                    <p><strong>CIN:</strong> <?php echo htmlspecialchars($order['cin']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                    <p><strong>Adresse:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
                    <p><strong>Méthode de paiement:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                    <p><strong>Total:</strong> <?php echo htmlspecialchars($order['total']); ?> €</p>
                    <h4>Articles achetés:</h4>
                    <ul>
                        <?php
                        // Fetch order items for this order
                        $stmtItems = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                        $stmtItems->execute([$order['id']]);
                        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($items as $item):
                        ?>
                            <li>
                                <?php echo htmlspecialchars($item['item_title']); ?> -
                                Date: <?php echo htmlspecialchars($item['item_date']); ?> -
                                Prix: <?php echo htmlspecialchars($item['item_price']); ?> €
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2023 ABC Construction. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>
