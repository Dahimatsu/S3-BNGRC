async function refreshRecap() {
    const btn = document.getElementById('btn-refresh');
    const btnText = document.getElementById('btn-text');

    btnText.innerText = 'Actualiser';

    try {
        const response = await fetch('/recapitulatif/ajax');
        const data = await response.json();

        document.getElementById('besoinTotal').innerText = data.besoinTotal + ' Ar';
        document.getElementById('besoinSatisfait').innerText = data.besoinSatisfait + ' Ar';
        document.getElementById('donsRecus').innerText = data.donsRecus + ' Ar';
        document.getElementById('donsDispatches').innerText = data.donsDispatches + ' Ar';
    } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
        alert('Impossible de charger les données financières.');
    }
}

document.addEventListener('DOMContentLoaded', refreshRecap);

document.getElementById('btn-refresh').addEventListener('click', refreshRecap);
