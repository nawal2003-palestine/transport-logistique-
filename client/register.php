<?php
include '../includes/header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO clients(nom, email, telephone, password) VALUES(?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $tel, $password]);
        
        $_SESSION['success_message'] = "Inscription réussie!";
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
    <title>Inscription Client | T9el.ma</title>
    <style>
        /* Reset et Base */
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

        /* Nouveau style pour le header */
        .main-header {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            font-size: 2rem;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2C5D8C;
        }

        .main-nav {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #2C3E50;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #2C5D8C;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #2C5D8C;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Conteneur Principal */
        .register-container {
            flex: 1;
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            position: relative;
            margin: 2rem auto;
        }
        
        /* Illustration */
        .register-illustration {
            flex: 1;
            background: linear-gradient(135deg, #2C5D8C 0%, #3A7DB8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
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
            max-width: 80%;
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
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .register-title {
            font-size: 2.5rem;
            color: #2C5D8C;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .title-icon {
            font-size: 2.8rem;
        }
        
        .register-subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
        
        /* Styles de Formulaire */
        .form-elegant {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .form-group {
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }
        
        .form-input:focus {
            border-color: #2C5D8C;
            background-color: white;
            outline: none;
            box-shadow: 0 5px 15px rgba(44, 93, 140, 0.1);
        }
        
        .form-group label {
            position: absolute;
            left: 45px;
            top: 15px;
            color: #999;
            transition: all 0.3s;
            pointer-events: none;
            background: white;
            padding: 0 5px;
        }
        
        .form-input:focus + label,
        .form-input:not(:placeholder-shown) + label {
            top: -10px;
            left: 35px;
            font-size: 0.8rem;
            color: #2C5D8C;
        }
        
        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        /* Bouton */
        .btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2C5D8C 0%, #3A7DB8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(44, 93, 140, 0.4);
            margin-top: 20px;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(44, 93, 140, 0.6);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .register-illustration {
                padding: 40px 20px;
            }
            
            .register-form {
                padding: 40px;
            }
            
            .register-title {
                font-size: 2rem;
            }

            .header-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .main-nav {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <div class="logo-container">
                <span class="logo-icon">🚚</span>
                <span class="logo-text">T9el.ma</span>
            </div>
            <nav class="main-nav">
                <a href="../index.php" class="nav-link">Accueil</a>
                <a href="register.php" class="nav-link">Inscription</a>
                <a href="login.php" class="nav-link">Connexion</a>
            </nav>
        </div>
    </header>

    <div class="register-container">
        <!-- Illustration -->
        <div class="register-illustration">
            <div class="illustration-circle"></div>
            <img src="../outils/img/register-illustration.png" alt="Inscription Client" class="illustration-img">
        </div>
        
        <!-- Formulaire -->
        <div class="register-form">
            <h2 class="register-title">
                <span class="title-icon">👋</span>
                <span>Créez votre compte</span>
            </h2>
            
            <p class="register-subtitle">Rejoignez la communauté T9el.ma en 1 minute</p>
            
            <?php if(isset($error_message)): ?>
                <div class="alert alert-error" style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="form-elegant">
                <div class="form-group">
                    <input type="text" id="nom" name="nom" class="form-input" placeholder=" " required>
                    <label for="nom">Nom complet</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-input" placeholder=" " required>
                    <label for="email">Adresse email</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="tel" id="tel" name="tel" class="form-input" placeholder=" " required>
                    <label for="tel">Téléphone</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-input" placeholder=" " required>
                    <label for="password">Mot de passe</label>
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
                    <span>S'inscrire gratuitement</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 10px;">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </form>
            
            <div class="register-footer" style="text-align: center; margin-top: 30px; color: #666;">
                <p>Déjà membre? <a href="login.php" style="color: #2C5D8C; font-weight: 600; text-decoration: none;">Connectez-vous</a></p>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>







ou bien : 






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client | T9el.ma</title>
    <style>
        /* Reset et Base */
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

        /* Nouveau style pour le header */
        .main-header {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            font-size: 2rem;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2C5D8C;
        }

        .main-nav {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #2C3E50;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #2C5D8C;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #2C5D8C;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Conteneur Principal */
        .register-container {
            flex: 1;
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            position: relative;
            margin: 2rem auto;
        }
        
        /* Illustration */
        .register-illustration {
            flex: 1;
            background: linear-gradient(135deg, #2C5D8C 0%, #3A7DB8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
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
            max-width: 80%;
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
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .register-title {
            font-size: 2.5rem;
            color: #2C5D8C;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .title-icon {
            font-size: 2.8rem;
        }
        
        .register-subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
        
        /* Styles de Formulaire */
        .form-elegant {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .form-group {
            position: relative;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }
        
        .form-input:focus {
            border-color: #2C5D8C;
            background-color: white;
            outline: none;
            box-shadow: 0 5px 15px rgba(44, 93, 140, 0.1);
        }
        
        .form-group label {
            position: absolute;
            left: 45px;
            top: 15px;
            color: #999;
            transition: all 0.3s;
            pointer-events: none;
            background: white;
            padding: 0 5px;
        }
        
        .form-input:focus + label,
        .form-input:not(:placeholder-shown) + label {
            top: -10px;
            left: 35px;
            font-size: 0.8rem;
            color: #2C5D8C;
        }
        
        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        /* Bouton */
        .btn-register {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2C5D8C 0%, #3A7DB8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(44, 93, 140, 0.4);
            margin-top: 20px;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(44, 93, 140, 0.6);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .register-illustration {
                padding: 40px 20px;
            }
            
            .register-form {
                padding: 40px;
            }
            
            .register-title {
                font-size: 2rem;
            }

            .header-container {
                flex-direction: column;
                gap: 0.5rem;
            }

            .main-nav {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <div class="logo-container">
                <span class="logo-icon">👩🏻‍💼👨‍💼</span>
                <span class="logo-text">T9el.ma</span>
            </div>
            <nav class="main-nav">
                <a href="../index.html" class="nav-link">Accueil</a>
                <a href="register.php" class="nav-link">Inscription</a>
                <a href="login.php" class="nav-link">Connexion</a>
                <a href="search-drivers.php" class="nav-link">Chercher chaufeure</a>
            </nav>
        </div>
    </header>

    <div class="register-container">
        <!-- Illustration -->
        <div class="register-illustration">
            <div class="illustration-circle"></div>
            <img src="../outils/img/register-illustration.png" alt="Inscription Client" class="illustration-img">
        </div>
        
        <!-- Formulaire -->
        <div class="register-form">
            <h2 class="register-title">
                <span class="title-icon">👋</span>
                <span>Créez votre compte</span>
            </h2>
            
            <p class="register-subtitle">Rejoignez la communauté T9el.ma en 1 minute</p>
            
            <?php if(isset($error_message)): ?>
                <div class="alert alert-error" style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #c62828;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="form-elegant">
                <div class="form-group">
                    <input type="text" id="nom" name="nom" class="form-input" placeholder=" " required>
                    <label for="nom">Nom complet</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-input" placeholder=" " required>
                    <label for="email">Adresse email</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="tel" id="tel" name="tel" class="form-input" placeholder=" " required>
                    <label for="tel">Téléphone</label>
                    <div class="form-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-input" placeholder=" " required>
                    <label for="password">Mot de passe</label>
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
                    <span>S'inscrire gratuitement</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left: 10px;">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </form>
            
            <div class="register-footer" style="text-align: center; margin-top: 30px; color: #666;">
                <p>Déjà membre? <a href="login.php" style="color: #2C5D8C; font-weight: 600; text-decoration: none;">Connectez-vous</a></p>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>
