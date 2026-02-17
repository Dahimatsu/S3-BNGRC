<header class="mb-0">
    <h2 class="fw-bold title">SAISIE DE BESOIN<span style="color: var(--lime-color)">.</span></h2>
    <p class="text-muted small">Inserer les besoins d'une ville.</p>
</header>
<main class="container mt-5">
    <section class="row g-5">
        <article class="col-md-12 ">
            <div class="don-card bg-white p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <h3 class="fw-black mb-0">FORMULAIRE</h3>
                </div>
                <p class="mb-4">Saisir les nouveaux besoins.</p>
            <form action="/besoin/save" method="post">
                <select name="id_ville" class="form-select mb-3" required>
                    <option value="" selected disabled>Choisir une ville</option>
                    <?php foreach ($villes as $ville): ?>
                        <option value="<?= $ville['id'] ?>">
                            <?= formatText($ville['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="id_article" class="form-select brutalist-input mb-3" required>
                    <option value="" selected disabled>Choisir un article</option>
                    <?php foreach ($articles as $article): ?>
                        <option value="<?= $article['id'] ?>">
                            <?= formatText($article['nom']) ?> (<?= formatText($article['unite']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="quantite" class="form-control mb-5" placeholder="Quantité de besoin">
                
                <button type="submit" class="btn-brutal btn-lime w-100">ENREGISTRER LE BESOIN</button>

            </form>
            </div>
        </article>
    </section>
</main>