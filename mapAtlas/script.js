document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const pays = urlParams.get('pays');

    if (pays) {
        loadLieuData(pays);
    }

    function loadLieuData(pays) {
        Papa.parse(`/mapAtlas/${pays}/${pays}.csv`, {
            download: true,
            header: true,
            complete: function(results) {
                const data = results.data[0];
                if (data) {
                    document.getElementById('lieuName').textContent = data.nom;
                    document.getElementById('lieuDescription').textContent = data.description;
                    document.getElementById('lieuPolitique').innerHTML = `<strong>Politique:</strong> ${data.Politique}`;
                    document.getElementById('lieuPopulation').innerHTML = `<strong>Population:</strong> ${data.Population}`;
                    document.getElementById('lieuCapital').innerHTML = `<strong>Capital:</strong> ${data.capital}`;
                    document.getElementById('lieuMonument').innerHTML = `<strong>Monument:</strong> ${data.Monument}`;
                    document.getElementById('lieuReligion').innerHTML = `<strong>Religion:</strong> ${data.religion}`;
                } else {
                    document.getElementById('lieuName').textContent = 'Pays non trouvé';
                }
            }
        });
    }
});
