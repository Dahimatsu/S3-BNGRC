<header class="mb-0">
    <h2 class="fw-bold title">FAIRE UN DON<span style="color: var(--lime-color)">.</span></h2>
    <p class="text-muted small">Page de gestion des dons.</p>
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
                
                <a href="#"
                    class="btn-brutal btn-lime w-100 text-center text-decoration-none">
                    ENREGISTRER UN DON
                </a>
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
                
                <a href="#"
                    class="btn-brutal btn-lime w-100 text-center text-decoration-none">
                    DISTRIBUER LES DONS
                </a>
            </div>
        </article>
    </section>
    <section class="mt-5">
    <div class="brutalist-card bg-white p-4">
        <h3 class="fw-black mb-4 text-uppercase">ÉTAT DES STOCKS DISPONIBLES</h3>
        
        <div class="table-responsive">
            <table class="table table-brutal mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase">Article</th>
                        <th class="text-uppercase text-end">Quantité</th>
                        <th class="text-uppercase text-start">Unité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($globalStock)) { ?>
                            <tr>
                                <td colspan="3" class="text-center fw-bold py-4">AUCUN DON EN STOCK ACTUELLEMENT</td>
                            </tr>
                        <?php } else { ?>
                            <?php foreach ($globalStock as $item) { ?>
                                <tr>
                                    <td class="fw-bold">
                                        <?= formatText($item['nom']) ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="stock-number">
                                            <?= formatNumber($item['total_stock'] ?? 0) ?>
                                        </span>
                                    </td>
                                    <td class="text-start">
                                        <?= formatText($item['unite']) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>