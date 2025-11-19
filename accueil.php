<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - ABC Construction</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php session_start(); ?>
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
                    <li><a href="#accueil">Accueil</a></li>
                    <li><a href="#contact">Contact</a></li>
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

    <section id="hero">
        <div class="container">
            <h2>Bienvenue chez ABC Construction</h2>
            <p>Votre partenaire de confiance pour tous vos projets de construction et rénovation.</p>
            <a href="#contact" class="btn">Contactez-nous</a>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <h2>Nos Services</h2>
            <div class="services-grid">
                <div class="service">
                    <i class="fas fa-home"></i>
                    <h3>Construction Neuve</h3>
                    <p>Réalisation de bâtiments résidentiels et commerciaux de A à Z.</p>
                </div>
                <div class="service">
                    <i class="fas fa-tools"></i>
                    <h3>Rénovation</h3>
                    <p>Modernisation et rénovation de vos espaces existants.</p>
                </div>
                <div class="service">
                    <i class="fas fa-bolt"></i>
                    <h3>Travaux Spéciaux</h3>
                    <p>Électricité, plomberie, et autres travaux spécialisés.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <h2>À Propos de Nous</h2>
            <p>Avec plus de 20 ans d'expérience, ABC Construction s'engage à fournir des services de qualité supérieure. Notre équipe d'experts est dédiée à la réalisation de vos projets dans les délais et le budget convenus.</p>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <h2>Contactez-nous</h2>
            <form action="#" method="post">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn">Envoyer</button>
            </form>
        </div>
    </section>

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
