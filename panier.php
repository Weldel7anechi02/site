<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - ABC Construction</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php session_start(); ?>
    <header>
<?php if (isset($_GET['success'])): ?>
<div class="message success">
<?php
if ($_GET['success'] == 'signup') echo 'Inscription réussie! Bienvenue.';
elseif ($_GET['success'] == 'login') echo 'Connexion réussie!';
elseif ($_GET['success'] == 'order') echo 'Commande passée avec succès!';
else echo 'Opération réussie!';
?>
</div>
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
            <h2>Votre Panier</h2>
            <div id="cart-buttons" style="display: none;">
                <button id="clear-cart" onclick="clearCart()">Vider le panier</button>
                <button id="place-order" onclick="openOrderForm()">Passer la commande</button>
            </div>
            <div id="cart-items">
                <!-- Cart items will be loaded here -->
            </div>
            <p id="empty-cart">Votre panier est vide.</p>
        </div>
    </main>

    <!-- Order Form Modal -->
    <div id="order-form-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeOrderForm()">&times;</span>
            <h2>Informations de commande</h2>
            <form id="order-form" action="save_order.php" method="POST">
                <input type="hidden" name="cart_items" id="cart_items">
                <label for="address">Adresse de livraison:</label>
                <textarea id="address" name="address" rows="3" required></textarea>

                <label>Méthode de paiement:</label>
                <div>
                    <input type="radio" id="cash" name="payment" value="Espèces" required>
                    <label for="cash">Espèces</label>
                </div>
                <div>
                    <input type="radio" id="card" name="payment" value="Carte bancaire" required>
                    <label for="card">Carte bancaire</label>
                </div>

                <button type="submit">Confirmer la commande</button>
            </form>
        </div>
    </div>

    <!-- Success Popup Modal -->
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSuccess()">&times;</span>
            <h2>Commande passée avec succès!</h2>
            <p>Votre commande a été confirmée. Merci pour votre achat!</p>
            <button onclick="closeSuccess()">Fermer</button>
        </div>
    </div>

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
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItems = document.getElementById('cart-items');
            const emptyCart = document.getElementById('empty-cart');
            const cartButtons = document.getElementById('cart-buttons');
            cartItems.innerHTML = '';
            let total = 0;
            if (cart.length === 0) {
                emptyCart.style.display = 'block';
                cartButtons.style.display = 'none';
            } else {
                emptyCart.style.display = 'none';
                cartButtons.style.display = 'block';
                cart.forEach((item, index) => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'cart-item';
                    itemDiv.innerHTML = `
                        <h3>${item.title}</h3>
                        <p>${item.date}</p>
                        <p>Prix: ${item.price}€</p>
                        <button onclick="removeFromCart(${index})">Retirer</button>
                    `;
                    cartItems.appendChild(itemDiv);
                    total += item.price;
                });
                const totalDiv = document.createElement('div');
                totalDiv.className = 'cart-total';
                totalDiv.innerHTML = `<h3>Total: ${total}€</h3>`;
                cartItems.appendChild(totalDiv);
            }
        }

        function removeFromCart(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function clearCart() {
            localStorage.setItem('cart', JSON.stringify([]));
            loadCart();
        }

        function openOrderForm() {
            document.getElementById('order-form-modal').style.display = 'block';
        }

        function closeOrderForm() {
            document.getElementById('order-form-modal').style.display = 'none';
        }

        function closeSuccess() {
            document.getElementById('success-modal').style.display = 'none';
            // Clear cart after order
            localStorage.setItem('cart', JSON.stringify([]));
            loadCart();
        }

        document.getElementById('order-form').addEventListener('submit', function(e) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart_items').value = JSON.stringify(cart);
            // Form will submit to save_order.php
        });

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


        window.onload = loadCart;

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
