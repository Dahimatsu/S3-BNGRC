<?php if (isset($flash)){ ?>
    <div class="alert-brutal <?= $flash['type'] === 'error' ? 'alert-error' : 'alert-success' ?> mb-5">
        <div class="d-flex align-items-center">
            <span class="flash-icon me-3">
                <?= $flash['type'] === 'error' ? '✖' : '✔' ?>
            </span>
            <span class="fw-black text-uppercase">
                <?= htmlspecialchars($flash['text']) ?>
            </span>
        </div>
    </div>
<?php } ?>
<header class="mb-0">
    <h2 class="fw-bold title">FAIRE UN DON<span style="color: var(--lime-color)">.</span></h2>
    <p class="text-muted small">Suivi des collectes et distributions pour les sinistrés.</p>
</header>
<main class="container mt-5">
    <section class="row g-5">
        <article class="col-md-6">
            <div class="don-card bg-white p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge-brutal badge-in me-3">IN</span>
                    <h3 class="fw-black mb-0">RÉCEPTION</h3>
                </div>
                <p class="text-uppercase small fw-bold">Entrée en stock global</p>
                <p class="mb-4">Saisir les nouveaux dons reçus.</p>

                <button type="button" class="btn-brutal btn-lime w-100 text-center text-uppercase"
                    data-bs-toggle="modal" data-bs-target="#modalReception">
                    ENREGISTRER UN DON
                </button>
            </div>
        </article>

        <article class="col-md-6">
            <div class="don-card bg-white p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge-brutal badge-out me-3">OUT</span>
                    <h3 class="fw-black mb-0">DISTRIBUTION</h3>
                </div>
                <p class="text-uppercase small fw-bold">Affectation aux sinistrés</p>
                <p class="mb-4">Attribuer les dons disponibles aux besoins saisis par ville.</p>

                <button type="button" 
                        class="btn-brutal btn-lime w-100 text-center text-uppercase" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalDistribution">
                    DISTRIBUER LES DONS
                </button>
            </div>
        </article>
    </section>
    <section class="mt-5 mb-5">
        <h3 class="fw-black mb-4 text-uppercase">STOCKS ACTUELS</h3>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($globalStock)) { ?>
                <div class="col-12">
                    <div class="brutalist-card bg-white p-4 text-center">
                        <h4 class="fw-bold m-0">AUCUN DON EN STOCK</h4>
                    </div>
                </div>
            <?php } else { ?>
                <?php foreach ($globalStock as $item) { ?>
                    <div class="col">
                        <div class="stock-card h-100 p-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="article-info">
                                    <span class="text-uppercase small fw-black d-block text-muted">Article</span>
                                    <h4 class="fw-black mb-0 text-uppercase"><?= formatText($item['nom']) ?></h4>
                                </div>

                                <div class="quantity-info text-end">
                                    <span class="text-uppercase small fw-black d-block text-muted">Disponible</span>
                                    <div class="d-flex align-items-baseline justify-content-end">
                                        <span class="stock-value me-2"><?= formatNumber($item['total_stock'] ?? 0) ?></span>
                                        <span class="badge-brutal-mini"><?= formatText($item['unite']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>

    <div class="modal fade" id="modalReception" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content brutalist-modal">
                <header class="modal-header border-bottom-4 d-flex justify-content-between align-items-center">
                    <h3 class="fw-black mb-0">NOUVEAU DON</h3>
                    <button type="button" class="btn-close-brutal" data-bs-dismiss="modal">X</button>
                </header>
                <form action="/don/reception" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="label-brutal">TYPE D'ARTICLE</label>
                            <select name="id_article" class="form-select brutalist-input" required>
                                <option value="" selected disabled>Choisir un article</option>
                                <?php foreach ($articles as $article) { ?>
                                    <option value="<?= $article['id'] ?>">
                                        <?= formatText($article['nom']) ?> (<?= formatText($article['unite']) ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
    
                        <div class="mb-4">
                            <label class="label-brutal">QUANTITÉ REÇUE</label>
                            <input type="number" step="0.01" name="quantite" class="form-control brutalist-input"
                                placeholder="0.00" min="0" required>
                        </div>
    
                        <div class="mb-2">
                            <label class="label-brutal">DATE DE RÉCEPTION</label>
                            <input type="date" name="date_reception" class="form-control brutalist-input"
                                value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn-brutal btn-lime w-100">CONFIRMER LA RÉCEPTION</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDistribution" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content brutalist-modal border-out">
            <form action="/don/distribution" method="POST" class="p-4">
                <header class="modal-header border-bottom-4 d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-black mb-0">DISTRIBUER UN DON</h3>
                    <button type="button" class="btn-close-brutal" data-bs-dismiss="modal">X</button>
                </header>

                <div class="modal-body p-0">
                    <div class="mb-4">
                        <label class="label-brutal mb-3">1. CHOISIR LA VILLE DESTINATAIRE</label>
                        <div class="row g-2">
                            <?php foreach ($villes as $v) { ?>
                                    <div class="col-md-4">
                                        <label class="brutalist-radio-card">
                                            <input type="radio" name="id_ville" value="<?= $v['id'] ?>" required>
                                            <div class="radio-content p-2 text-center">
                                                <span class="fw-bold text-uppercase"><?= htmlspecialchars($v['nom']) ?></span>
                                            </div>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
    
                        <div class="mb-4">
                            <label class="label-brutal mb-3">2. CHOISIR L'ARTICLE À DONNER</label>
                            <div class="row g-2">
                                <?php foreach ($articles as $a) { ?>
                                    <div class="col-md-4">
                                        <label class="brutalist-radio-card card-blue">
                                            <input type="radio" name="id_article" value="<?= $a['id'] ?>" required>
                                            <div class="radio-content p-2 text-center">
                                                <span class="fw-bold text-uppercase"><?= htmlspecialchars($a['nom']) ?></span>
                                                <small class="d-block text-muted"><?= htmlspecialchars($a['unite']) ?></small>
                                            </div>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label class="label-brutal">3. QUANTITÉ À DISTRIBUER</label>
                            <input type="number" step="0.01" name="quantite" class="form-control brutalist-input"
                                placeholder="0.00" min="0.01" required>
                            <p class="text-muted small mt-2">⚠️ Le système vérifiera automatiquement si le stock est
                                suffisant.</p>
                        </div>
                    </div>
    
                    <button type="submit" class="btn-brutal btn-lime w-100 mt-3">VALIDER LA DISTRIBUTION</button>
                </form>
            </div>
        </div>
    </div>
</main>