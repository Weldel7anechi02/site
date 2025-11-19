<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $cin = trim($_POST['cin']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Basic validation
    if (empty($nom) || empty($prenom) || empty($cin) || empty($phone) || empty($email) || empty($_POST['password'])) {
        $error = "All fields are required.";
    } elseif (!preg_match('/^\d{8}$/', $cin)) {
        $error = "CIN must be 8 digits.";
    } elseif (!preg_match('/^\d{8}$/', $phone)) {
        $error = "Phone must be 8 digits.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email.";
    } else {
        try {
            // Check if email or CIN exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR cin = ?");
            $stmt->execute([$email, $cin]);
            if ($stmt->rowCount() > 0) {
                $error = "Email or CIN already exists.";
            } else {
                // Insert user
                $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, cin, phone, email, password) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $cin, $phone, $email, $password]);
                
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['user_name'] = $nom . ' ' . $prenom;
                header("Location: articles.php?success=signup"); // Redirect to articles or home
                exit();
            }
        } catch (PDOException $e) {
            $error = "Signup failed: " . $e->getMessage();
        }
    }
}

// If error, redirect back with message (or handle in modal, but for simplicity, redirect)
if (isset($error)) {
    header("Location: accueil.php?error=" . urlencode($error));
    exit();
}
?>
