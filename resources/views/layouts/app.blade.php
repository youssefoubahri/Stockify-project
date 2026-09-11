<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion de Stock')</title>
    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden;
        }

        /* Sidebar Réduite (70px fixe) */
        .sidebar {
            width: 70px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #0f172a;
            color: #fff;
            padding-top: 1.25rem;
            z-index: 1000;
            transition: width 0.3s ease;
            overflow: hidden;
            white-space: nowrap;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        /* Agrandissement au survol */
        .sidebar:hover {
            width: 240px;
        }

        /* Conteneur Logo */
        .sidebar .logo-container {
            display: flex;
            align-items: center;
            height: 45px;
            margin-bottom: 1.5rem;
        }

        .sidebar .logo-icon {
            min-width: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
        }

        .sidebar .logo-text {
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar:hover .logo-text {
            opacity: 1;
        }

        /* Liens de Navigation & Transitions Sidebar */
        .sidebar .nav-link {
            color: #94a3b8;
            height: 48px;
            padding: 0;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            margin: 0.25rem 0.4rem;
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
            position: relative;
        }

        .sidebar .nav-link i {
            min-width: 60px;
            text-align: center;
            font-size: 1.3rem;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .sidebar .nav-link span {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar:hover .nav-link span {
            opacity: 1;
        }

        /* Effet au survol des items */
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(59, 130, 246, 0.15);
            transform: translateX(2px);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.15) rotate(-3deg);
            color: #38bdf8;
        }

        /* Lien actif */
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #1e293b;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-link.active:hover {
            transform: none;
        }

        .sidebar .nav-link.active i {
            color: #38bdf8;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
            background-color: #38bdf8;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 8px rgba(56, 189, 248, 0.6);
        }

        /* Zone de contenu principal */
        .main-content {
            margin-left: 70px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        /* Style Général des Cartes & Badges */
        .card {
            border: none !important;
            border-radius: 0.75rem !important;
            background-color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden !important;
        }

        .badge-soft-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-soft-success {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 1.25rem;
        }

        /* Animations d'entrée des cartes KPI */
        .stat-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeSlideUp 0.5s ease-out forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.15s; }
        .stat-card:nth-child(3) { animation-delay: 0.25s; }

        @keyframes fadeSlideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style de la carte KPI interne et effet au survol */
        .stat-card .card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card .card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }

        /* Bordure latérale des indicateurs KPI */
        .card-kpi-primary::before,
        .card-kpi-danger::before,
        .card-kpi-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            z-index: 2;
        }

        .card-kpi-primary::before { background-color: #0d6efd; }
        .card-kpi-danger::before { background-color: #dc3545; }
        .card-kpi-success::before { background-color: #198754; }

        /* Animation Pulse au chargement des icônes */
        @keyframes pulseOnLoad {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.15);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Style des icônes circulaires */
        .icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            transition: transform 0.2s ease;
            animation: pulseOnLoad 0.6s ease-out forwards;
        }

        .stat-card:hover .icon-circle {
            transform: scale(1.08) rotate(-4deg);
        }

        /* Animation "Pop-in" pour les badges de quantité */
        .qty-badge {
            display: inline-block;
            animation: popIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.6);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Boutons du header & actions principales */
        .btn-primary {
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(59, 130, 246, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Animation d'apparition progressive des lignes du tableau */
        .table-row-fade {
            opacity: 0;
            animation: rowFadeIn 0.5s ease forwards;
        }

        @keyframes rowFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Unique -->
    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="bi bi-box-seam text-primary"></i>
            </div>
            <span class="logo-text">Stockify</span>
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" title="Accueil">
                <i class="bi bi-house-door-fill"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" title="Produits">
                <i class="bi bi-grid-fill"></i>
                <span>Produits</span>
            </a>
            <a href="{{ route('movements.index') }}" class="nav-link {{ request()->routeIs('movements.*') ? 'active' : '' }}" title="Mouvements">
                <i class="bi bi-arrow-down-up"></i>
                <span>Mouvements</span>
            </a>
        </nav>
    </div>

    <!-- Contenu Principal -->
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>