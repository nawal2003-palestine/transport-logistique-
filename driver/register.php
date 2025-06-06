<?php
// Ne pas inclure header.php car nous l'intégrons directement
// include '../includes/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);
    $permis = htmlspecialchars($_POST['permis']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO chauffeurs(nom, email, telephone, num_permis, password) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $tel, $permis, $password]);
        
        $_SESSION['success_message'] = "Inscription chauffeur réussie!";
        header('Location: login.php');
        exit();
    } catch(PDOException $e) {
        $error_message = "Erreur: ".$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Chauffeur | T9el.ma</title>
    <style>
        /* Styles de base - Cohérents avec le reste du site */
        :root {
            --primary: #2C5D8C;
            --primary-light: #3A7DB8;
            --secondary: #E67E22;
            --light: #F5F7FA;
            --dark: #2C3E50;
            --white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .main-header {
            background-color: var(--white);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 2rem;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .main-nav {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Conteneur principal */
        .register-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        /* Carte d'inscription */
        .register-card {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
            display: flex;
        }

        /* Illustration */
        .register-illustration {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .illustration-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            top: -50px;
            right: -50px;
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            z-index: 2;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Formulaire */
        .register-form {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .title-icon {
            font-size: 2rem;
        }

        .register-subtitle {
            color: var(--dark);
            opacity: 0.8;
            margin-bottom: 2rem;
        }

        /* Styles de formulaire */
        .form-elegant {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        .form-input:focus {
            border-color: var(--primary);
            background-color: var(--white);
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 93, 140, 0.2);
        }

        .form-label {
            position: absolute;
            left: 3.5rem;
            top: 1rem;
            color: #999;
            transition: all 0.3s;
            pointer-events: none;
            background: var(--white);
            padding: 0 0.5rem;
        }

        .form-input:focus + .form-label,
        .form-input:not(:placeholder-shown) + .form-label {
            top: -0.6rem;
            left: 2.5rem;
            font-size: 0.8rem;
            color: var(--primary);
        }

        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        /* Bouton */
        .btn-register {
            background: linear-gradient(135deg, var(--secondary) 0%, #F39C12 100%);
            color: var(--white);
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(230, 126, 34, 0.6);
        }

        /* Footer */
        .register-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--dark);
        }

        .login-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* Message d'erreur */
        .alert-error {
            background: #ffebee;
            color: #c62828;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #c62828;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .register-card {
                flex-direction: column;
            }
            
            .register-illustration {
                padding: 2rem 1rem;
            }
            
            .register-form {
                padding: 2rem;
            }
            
            .register-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <a href="../index.php" class="logo">
                <span class="logo-icon">🚛</span>
                <span class="logo-text">T9el.ma</span>
            </a>
            <nav class="main-nav">
                <a href="../index.html" class="nav-link">Accueil</a>
                <a href="registerdriver.php" class="nav-link">Devenir chauffeur</a>
                <a href="logindriver.php" class="nav-link">Connexion</a>
            </nav>
        </div>
    </header>

    <main class="register-container">
        <div class="register-card">
            <!-- Illustration -->
            <div class="register-illustration">
                <div class="illustration-circle"></div>
                <img src="../outils/img/driver-illustration.png" alt="Inscription Chauffeur" class="illustration-img">
            </div>
            
            <!-- Formulaire -->
            <div class="register-form">
                <h1 class="register-title">
                    <span class="title-icon">👋</span>
                    <span>Devenir chauffeur partenaire</span>
                </h1>
                
                <p class="register-subtitle">Rejoignez la plateforme de transport la plus fiable du Maroc</p>
                
                <?php if(isset($error_message)): ?>
                    <div class="alert-error"><?= $error_message ?></div>
                <?php endif; ?>
                
                <form method="POST" class="form-elegant">
                    <div class="form-group">
                        <input type="text" id="nom" name="nom" class="form-input" placeholder=" " required>
                        <label for="nom" class="form-label">Nom complet</label>
                        <div class="form-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-input" placeholder=" " required>
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="form-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="tel" id="tel" name="tel" class="form-input" placeholder=" " required>
                        <label for="tel" class="form-label">Téléphone</label>
                        <div class="form-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" id="permis" name="permis" class="form-input" placeholder=" " required>
                        <label for="permis" class="form-label">Numéro de permis</label>
                        <div class="form-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21h6"></path>
                                <path d="M8 21V8l4-4 4 4v13"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-input" placeholder=" " required>
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="form-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <button type="button" class="toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        <span>Devenir partenaire</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
                
                <div class="register-footer">
                    <p>Déjà partenaire? <a href="login.php" class="login-link">Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Change icon
                this.innerHTML = type === 'password' ? 
                    '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>' :
                    '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
            });
        });

        // Animation des icônes au focus
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.querySelector('.form-icon').style.color = '#2C5D8C';
            });
            
            input.addEventListener('blur', function() {
                this.parentNode.querySelector('.form-icon').style.color = '#999';
            });
        });
    </script>
</body>
</html>
