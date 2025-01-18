<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion de Cryptomonnaies')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        /* Global body styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: linear-gradient(135deg, #2a2d34, #39424e);
            color: #fff;
            padding-top: 30px;
            box-shadow: 4px 0px 25px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .sidebar:hover {
            width: 270px;
        }

        .sidebar .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffbb33;
            text-align: center;
            margin-bottom: 30px;
            transition: color 0.3s ease-in-out;
        }

        .sidebar .navbar-brand:hover {
            color: #fff;
        }

        .sidebar .nav-item {
            margin-bottom: 15px;
        }

        .sidebar .nav-link {
            color: #aab2bd;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 12px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #4b5360;
            color: #fff;
            text-decoration: none;
        }

        .sidebar .nav-link.active {
            background-color: #ffbb33;
            color: white;
            border-left: 5px solid #22272e;
        }

        /* Submenu Styling */
        .submenu {
            display: none;
            list-style: none;
            padding-left: 20px;
            transition: all 0.3s ease-in-out;
        }

        .submenu .nav-link {
            font-size: 1rem;
            padding-left: 30px;
            transition: all 0.3s ease;
        }

        /* Profile Dropdown Styling */
        .profile-section {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            padding: 15px;
            background-color: #22272e;
            text-align: center;
            border-top: 1px solid #3a434f;
        }

        .profile-section .nav-link {
            font-size: 1rem;
            color: #aab2bd;
            transition: color 0.3s ease;
        }

        .profile-section .nav-link:hover {
            background-color: #4b5360;
            color: #ffbb33;
        }

        .profile-section .nav-link i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
            background-color: #ffffff;
            flex-grow: 1;
        }

        /* Footer */
        footer {
            background-color: #2a2d34;
            color: #aab2bd;
            padding: 20px 0;
            text-align: center;
            font-size: 0.9rem;
        }

        footer a {
            color: #ffbb33;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            text-decoration: underline;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="navbar-brand">CryptoManager</a>
        <ul class="nav flex-column">
            <!-- Cryptomonnaie Section -->
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="javascript:void(0);" data-target="cryptomonnaieSubmenu">
                    <i class="bi bi-currency-bitcoin fs-5"></i> Cryptomonnaie
                    <i class="bi bi-chevron-down fs-6"></i>
                </a>
                <ul class="submenu" id="cryptomonnaieSubmenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cryptos.liste') }}">
                            <i class="bi bi-list-ul fs-5"></i> Liste
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Portefeuille Section -->
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="javascript:void(0);" data-target="portefeuilleSubmenu">
                    <i class="bi bi-wallet fs-5"></i> Portefeuille
                    <i class="bi bi-chevron-down fs-6"></i>
                </a>
                <ul class="submenu" id="portefeuilleSubmenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('portefeuilles.form') }}">
                            <i class="bi bi-file-earmark-plus fs-5"></i> Création
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('portefeuilles.liste') }}">
                            <i class="bi bi-wallet2 fs-5"></i> Liste
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Transactions Section -->
            <li class="nav-item">
                <a class="nav-link submenu-toggle" href="javascript:void(0);" data-target="transactionSubmenu">
                    <i class="bi bi-wallet"></i> Transactions
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="submenu" id="transactionSubmenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.form') }}">
                            <i class="bi bi-plus-circle fs-5"></i> Création
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.vente', 1) }}">
                            <i class="bi bi-cash-stack fs-5"></i>Mes Ventes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.achat', 1) }}">
                            <i class="bi bi-cart fs-5"></i>Mes Achats
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.historique', 1) }}">
                            <i class="bi bi-cash-stack fs-5"></i>Historique transactions
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Profile Section -->
        <div class="profile-section">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-person-circle fs-5"></i> Mon Profil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear fs-5"></i> Paramètres
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-box-arrow-right fs-5"></i> Déconnexion
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} CryptoManager. Tous droits réservés. | <a href="#">Privacy Policy</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for Submenu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.submenu-toggle').forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const submenu = document.getElementById(targetId);
                    const isVisible = submenu.style.display === 'block';
                    submenu.style.display = isVisible ? 'none' : 'block';
                });
            });
        });
    </script>
</body>
</html>
