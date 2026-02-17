<?php
if (!isset($page)) {
    Flight::redirect('/404');
}

if (empty($_SESSION['user']) === true) {
    Flight::redirect('/login');
}

$page = $page ?? 'home';
$title = $title ?? '';
$user = $_SESSION['user'] ?? '';

$cspNonce = Flight::get('csp_nonce');

$links = [
    ['href' => '/accueil', 'label' => 'Accueil'],
    ['href' => '/besoin', 'label' => 'Besoins'],
    ['href' => '/don', 'label' => 'Dons'],
    ['href' => '/dashboard', 'label' => 'Dashboard'],
    ['href' => '/recapitulatif', 'label' => 'Récapitulatif'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Fan'AMPY | <?= $title ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/home-style.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/typography.css" />
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap/icons/bootstrap-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/bootstrap/css/bootstrap.min.css" />
    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js" defer nonce="<?= formatText($cspNonce) ?>"></script>
    <?php if($page === 'recapitulatif') { ?>
        <script src="/assets/js/recap-ajax.js" defer nonce="<?= formatText($cspNonce) ?>"></script>
    <?php } ?>
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-1" href="/accueil">
            <img src="/assets/images/logo.png" style="width: 20px; height: 20px" alt="Logo Fan'AMPY" class="logo-custom">
            <span class="text-white">Fan'<span class=" fw-bold footer-lime-text">AMPY</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <?php foreach ($links as $link) {
                    $isActive = (
                            strtolower($page) === strtolower($link['label']) ||
                            ($page === 'home' && $link['label'] === 'Accueil')
                    ) ? 'active' : '';
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive ?>" href="<?= $link['href'] ?>">
                            <?= $link['label'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="dropdown">
                <button class="btn btn-lime dropdown-toggle" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-fill me-2"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="profileMenu">
                    <li><a class="dropdown-item" href="/profil"><?= formatText($user['email']) ?></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="/logout">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<main class="container">
    <?php require 'pages/' . $page . '.php'; ?>
</main>

<footer class="footer-custom py-4 mt-auto">
    <div class="container">
        <div class="row">
            <a class="col-md-6 navbar-brand fw-bold fs-4 d-flex align-items-center gap-1" href="/accueil">
                <img src="/assets/images/logo.png" style="width: 20px; height: 20px" alt="Logo Fan'AMPY" class="logo-custom">
                <span class="text-white">Fan'<span class=" fw-bold footer-lime-text">AMPY</span></span>
            </a>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-3">
                    <a href="https://github.com/Dahimatsu/S3-BNGRC" target="_blank" rel="noopener noreferrer" class="footer-lime-text fs-4"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 border-secondary">
        <div class="text-center d-flex flex-column gap-2">
            <p class="small mb-0"><i class="bi bi-c-circle"></i> Février 2026 - Fan'AMPY</p>
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 gap-md-4">
                <p class="small mb-0">RAVELOMANANTSOA Tony Mahefa - ETU004054</p>
                <p class="small mb-0 d-none d-md-block">|</p>
                <p class="small mb-0">RAKOTOBE Joshua Riki - ETU004155</p>
                <p class="small mb-0 d-none d-md-block">|</p>
                <p class="small mb-0">ANDRIANOARIMANANA Youssi - ETU004387</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>