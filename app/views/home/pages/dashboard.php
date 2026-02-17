<header class="mb-5">
    <h2 class="fw-black title text-uppercase">Tableau de bord<span style="color: var(--lime-color)">.</span></h2>
    <p class="text-muted small">Historique complet des besoins et des distributions par ville.</p>
</header>

<section>
    <h3>Historique d'achat</h3>
    <div class="table-responsive">
    <table class="table table-hover border-dark align-middle">
        <thead class="bg-dark text-white border-bottom border-4 border-dark">
            <tr class="text-uppercase fw-black small">
                <th class="py-3 px-3">Date</th>
                <th class="py-3">Ville</th>
                <th class="py-3">Article</th>
                <th class="py-3 text-end">PU</th>
                <th class="py-3 text-end">Quantité</th>
                <th class="py-3 text-end px-3">Montant Total</th>
            </tr>
        </thead>
        <tbody class="fw-bold bg-white">
            <?php foreach ($achats as $achat) { ?>
                    <tr class="border-bottom border-2">
                        <td class="py-3 px-3 small"><?= date('d/m/Y', strtotime($achat['date_achat'])) ?></td>
                        <td class="py-3"><?= formatText($achat['nomVille']) ?></td>
                        <td class="py-3"><?= formatText($achat['nomArticle']) ?></td>
    
                        <td class="py-3 text-end text-muted">
                            <?= formatNumber($achat['pu']) ?> <span class="small">Ar</span>
                        </td>
    
                        <td class="py-3 text-end">
                            <?= formatNumber($achat['quantite']) ?> <span
                                class="small opacity-50"><?= formatText($achat['unite']) ?></span>
                        </td>
                        <td class="py-3 text-end px-3">
                            <span class="text-primary"><?= formatNumber($achat['montant_total']) ?> Ar</span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<section class="mt-5">
    <h3>Historique de distribution</h3>
    <div class="table-responsive">
        <table class="table table-hover border-dark align-middle">
            <thead class="bg-light border-bottom border-4 border-dark">
                <tr class="text-uppercase fw-black small">
                    <th class="py-3">Villes</th>
                    <th class="py-3">Article</th>
                    <th class="py-3 text-end">Objectif</th>
                    <th class="py-3 text-end">Distribué</th>
                    <th class="py-3 text-center">Progression</th>
                    <th class="py-3 text-center">État</th>
                </tr>
            </thead>
            <tbody class="fw-bold">
                <?php foreach ($dashboard as $history) {
                    $demande = (float) $history['qteDemandee'];
                    $donnee = (float) $history['qteDonnee'];
                    $unite = formatText($history['unite']);
                
                    $pourcentage = ($demande > 0) ? ($donnee / $demande) * 100 : ($donnee > 0 ? 100 : 0);
                    $termine = ($pourcentage >= 100);
                    ?>
                    <tr class="border-bottom border-2">
                        <td class="py-3"><?= formatText($history['nomVille']) ?></td>
                        <td class="py-3"><?= formatText($history['nomArticle']) ?></td>
            
                        <td class="py-3 text-end text-muted small">
                            <?= formatNumber($demande) ?> <span class="ms-1"><?= $unite ?></span>
                        </td>
                        <td class="py-3 text-end">
                            <?= formatNumber($donnee) ?> <span class="ms-1"><?= $unite ?></span>
                        </td>
            
                        <td class="py-3 text-center" style="min-width: 150px;">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="me-2 small fw-black"><?= round($pourcentage) ?>%</span>
                                <div class="progress rounded-0 border border-2 border-dark w-100"
                                    style="height: 12px; background: #fff;">
                                    <div class="progress-bar <?= $termine ? 'bg-success' : 'bg-lime' ?>" role="progressbar"
                                        style="width: <?= min(100, $pourcentage) ?>%; background-color: <?= $termine ? '#198754' : 'var(--lime-color)' ?> !important; border-right: 2px solid #000;">
                                    </div>
                                </div>
                            </div>
                        </td>
            
                        <td class="py-3 text-end">
                            <?php if ($termine) { ?>
                                <span class="bg-success px-2 border-2 border-dark">Complété</span>
                            <?php } else { ?>
                                <span class=" text-dark px-2 border-2 border-dark">
                                    <?= formatNumber(max(0, $demande - $donnee)) ?>         <?= $unite ?> RESTANT
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>