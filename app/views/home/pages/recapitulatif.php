<header class="mb-5 col-12 d-flex flex-wrap align-items-start justify-content-between">
    <div class="col-6">
        <h2 class="fw-black title text-uppercase">Récapitulation Financière<span style="color: var(--lime-color)">.</span>
        </h2>
        <p class="text-muted small">Suivi global des flux financiers.</p>
    </div>
    <div class="d-flex justify-content-end col-6">
        <button id="btn-refresh" class="btn-brutal btn-lime text-uppercase px-4">
            <span id="btn-text">Actualiser</span>
        </button>
    </div>
</header>

<main class="container">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="brutalist-card bg-white p-4 h-100">
                <span class="small fw-black text-uppercase opacity-50 d-block mb-2">Besoins Totaux</span>
                <h2 id="besoinTotal" class="fw-black display-5 mb-0">-- Ar</h2>
                <div class="mt-3 small text-muted">Valeur monétaire de tous les besoins déclarés par les villes.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="brutalist-card bg-lime p-4 h-100">
                <span class="small fw-black text-uppercase d-block mb-2">Besoins Satisfaits</span>
                <h2 id="besoinSatisfait" class="fw-black display-5 mb-0">-- Ar</h2>
                <div class="mt-3 small fw-bold">Montant total des ressources déjà envoyées ou achetées.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="brutalist-card bg-white p-4 h-100">
                <span class="small fw-black text-uppercase opacity-50 d-block mb-2">Dons Reçus (Cash)</span>
                <h2 id="donsRecus" class="fw-black display-5 mb-0">-- Ar</h2>
                <div class="mt-3 small text-muted">Total des fonds entrés.</div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="brutalist-card bg-dark text-white p-4 h-100">
                <span class="small fw-black text-uppercase d-block mb-2">Dons Dépensés</span>
                <h2 id="donsDispatches" class="fw-black display-5 mb-0" style="color: var(--lime-color)">-- Ar</h2>
                <div class="mt-3 small opacity-75">Argent envoyé aux villes + achats effectués pour les sinistrés.</div>
            </div>
        </div>
    </div>
</main>