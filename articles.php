<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - ABC Construction</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
session_start();
include 'config.php';
?>
    <header>
<?php if (isset($_GET['success'])): ?>
<div class="message success"><?php echo $_GET['success'] == 'signup' ? 'Inscription réussie! Bienvenue.' : 'Connexion réussie!'; ?></div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
<div class="message error">Erreur: <?php echo htmlspecialchars($_GET['error']); ?></div>
<?php endif; ?>
        <div class="container">
            <h1>ABC Construction</h1>
            <nav>
                <ul>
                    <li><a href="accueil.php">Accueil</a></li>
                    <li><a href="accueil.php#contact">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="articles.php">Articles</a></li>
                        <li><a href="panier.php">Panier</a></li>
                        <li><a href="historique.php">Historique</a></li>
                        <li><a href="logout.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="#" onclick="openLoginForm()">Connexion</a></li>
                        <li><a href="#" onclick="openSignupForm()">S'inscrire</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h2>Nos Produits</h2>
            <div class="articles-grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM articles");
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($articles as $article) {
                    echo '<article>';
                    if (!empty($article['image_url'])) {
                        echo '<img src="' . htmlspecialchars($article['image_url']) . '" alt="' . htmlspecialchars($article['title']) . '">';
                    } else {
                        echo '<img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image">';
                    }
                    echo '<h3>' . htmlspecialchars($article['title']) . '</h3>';
                    echo '<p class="price">Prix: ' . htmlspecialchars($article['price']) . '€</p>';
                    echo '<p>' . htmlspecialchars($article['description']) . '</p>';
                    echo '<button class="add-to-cart" onclick="addToCart(\'' . addslashes($article['title']) . '\', \'' . addslashes($article['date']) . '\', ' . $article['price'] . ')">Ajouter au panier</button>';
                    echo '</article>';
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Login Modal -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLoginForm()">&times;</span>
            <h2>Connexion</h2>
            <form id="login-form" action="login.php" method="POST">
                <label for="login-email">Email:</label>
                <input type="email" id="login-email" name="email" required>

                <label for="login-password">Mot de passe:</label>
                <input type="password" id="login-password" name="password" required>

                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>

    <!-- Signup Modal -->
    <div id="signup-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSignupForm()">&times;</span>
            <h2>S'inscrire</h2>
            <form id="signup-form" action="signup.php" method="POST">
                <label for="signup-nom">Nom:</label>
                <input type="text" id="signup-nom" name="nom" required>

                <label for="signup-prenom">Prénom:</label>
                <input type="text" id="signup-prenom" name="prenom" required>

                <label for="signup-cin">CIN:</label>
                <input type="text" id="signup-cin" name="cin" pattern="\d{8}" title="Le CIN doit contenir exactement 8 chiffres" required>

                <label for="signup-phone">Numéro de téléphone:</label>
                <input type="tel" id="signup-phone" name="phone" pattern="\d{8}" title="Le numéro de téléphone doit contenir exactement 8 chiffres" required>

                <label for="signup-email">Email:</label>
                <input type="email" id="signup-email" name="email" required>

                <label for="signup-password">Mot de passe:</label>
                <input type="password" id="signup-password" name="password" required>

                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2023 ABC Construction. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        function addToCart(title, date, price) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({title, date, price});
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('L\'article a été ajouté à votre panier avec succès!');
        }

        function openLoginForm() {
            document.getElementById('login-modal').style.display = 'block';
        }

        function closeLoginForm() {
            document.getElementById('login-modal').style.display = 'none';
        }

        function openSignupForm() {
            document.getElementById('signup-modal').style.display = 'block';
        }

        function closeSignupForm() {
            document.getElementById('signup-modal').style.display = 'none';
        }

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.message');
            messages.forEach(function(msg) {
                msg.style.display = 'none';
            });
        }, 5000);

    </script>
</body>
</html>
