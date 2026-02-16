<header class="mb-0">
    <h2 class="fw-bold title">Tableau de bord<span style="color: var(--lime-color)">.</span></h2>
    <p class="text-muted small">Page pour consulter l'historique des dons.</p>
</header>

<main class="container mt-5">
    <section class="row g-5">
        <article class="col-md-12">
            <div class="don-card bg-white p-4 h-100 rounded shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <h3 class="fw-black mb-0">HISTORIQUE</h3>
                </div>
                <p class="mb-4">Récapitulatif des besoins et des dons.</p>

                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead class="text-muted small">
                            <tr>
                                <th>Villes</th>
                                <th>Besoin</th>
                                <th>Quantité demandée</th>
                                <th>Quantité donnée</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dashboard as $history) { ?>
                                <tr class="border-top">
                                    <td class="py-3"><?php echo $history['nomVille']; ?></td>
                                    <td class="py-3"><?php echo $history['nomArticle']; ?></td>
                                    <td class="py-3"><?php echo $history['qteDemandee']; ?></td>
                                    <td class="py-3 fw-bold"><?php echo $history['qteDonnee']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </section>
</main>