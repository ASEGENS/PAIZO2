<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <div id="navbar-container"></div>

    <!-- Hero Section -->
    <section class="hero text-white text-center" style="background: url('img/atlasbg.webp') no-repeat center center; background-size: cover;">
        <div class="d-flex flex-column justify-content-center align-items-center h-100">
            <h1 class="display-3">Bienvenue dans l'univers d'Atlas</h1>
            <p class="lead">Découvrez les mystères et l'histoire riche de ce monde fantastique.</p>
        </div>
    </section>

    <!-- Global Timeline Section -->
    <section class="timeline-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Événements Majeurs</h2>
            <div id="globalTimeline" class="timeline">
                <!-- Timeline items will be inserted here by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Accordion Section -->
    <section class="accordion-section py-5" id="accordion-section">
        <div class="container">
            <h2 class="text-center mb-4">Le Lore d'Atlas</h2>
            <div class="accordion" id="mainAccordion">
                <!-- Main accordion sections will be inserted here by JavaScript -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function loadHTML(elementId, url) {
                return fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById(elementId).innerHTML = data;
                    });
            }

            // Charger la navbar et le footer
            Promise.all([
                loadHTML('navbar-container', 'navbar.php'),
                loadHTML('footer-container', 'footer.php')
            ]).then(() => {
                initializeAccordion();
                loadGlobalTimeline();
            });

            function initializeAccordion() {
                const csvFiles = {
                    'Concept': 'atlas/atlasConcepts.csv',
                    'Géographie': 'atlas/atlasGeographie.csv',
                    'Guilde': 'atlas/atlasGuildes.csv',
                    'Histoire': 'atlas/atlasHistoire.csv',
                    'Religion': 'atlas/atlasReligions.csv'
                };

                function parseCSV(file, callback) {
                    Papa.parse(file, {
                        download: true,
                        header: true,
                        complete: function(results) {
                            callback(results.data);
                        }
                    });
                }

                function createSubAccordion(data, parentId) {
                    const subAccordion = document.createElement('div');
                    subAccordion.className = 'accordion';
                    subAccordion.id = `subAccordion${parentId}`;

                    data.forEach((row, index) => {
                        const isFirst = index === 0;
                        const accordionItem = document.createElement('div');
                        accordionItem.className = 'accordion-item';
                        accordionItem.innerHTML = `
                            <h2 class="accordion-header" id="subHeading${parentId}-${index}">
                                <button class="accordion-button ${isFirst ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" data-bs-target="#subCollapse${parentId}-${index}" aria-expanded="${isFirst ? 'true' : 'false'}" aria-controls="subCollapse${parentId}-${index}">
                                    ${row.nom || row.title}
                                </button>
                            </h2>
                            <div id="subCollapse${parentId}-${index}" class="accordion-collapse collapse ${isFirst ? 'show' : ''}" aria-labelledby="subHeading${parentId}-${index}" data-bs-parent="#subAccordion${parentId}">
                                <div class="accordion-body">
                                    ${generateContent(row)}
                                </div>
                            </div>
                        `;
                        subAccordion.appendChild(accordionItem);
                    });

                    return subAccordion;
                }

                function generateContent(row) {
                    let content = '';
                    for (const [key, value] of Object.entries(row)) {
                        if (key !== 'nom' && key !== 'title' && key !== 'img') {
                            if (isValidURL(value)) {
                                content += `<p><strong>${key}:</strong> <a href="${value}" target="_blank">${value}</a></p>`;
                            } else {
                                content += `<p><strong>${key}:</strong> ${value}</p>`;
                            }
                        }
                    }
                    if (row.img) {
                        content += `<img src="img/MAP/${row.img}" alt="${row.nom || row.title}" class="img-fluid mb-3">`;
                    }
                    return content;
                }

                function isValidURL(string) {
                    try {
                        new URL(string);
                        return true;
                    } catch (_) {
                        return false;
                    }
                }

                const mainAccordion = document.getElementById('mainAccordion');

                for (const [section, file] of Object.entries(csvFiles)) {
                    parseCSV(file, function(data) {
                        const isFirst = mainAccordion.children.length === 0;
                        const accordionItem = document.createElement('div');
                        accordionItem.className = 'accordion-item';
                        const parentId = section.replace(/\s+/g, '');
                        accordionItem.innerHTML = `
                            <h2 class="accordion-header" id="heading${parentId}">
                                <button class="accordion-button ${isFirst ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${parentId}" aria-expanded="${isFirst ? 'true' : 'false'}" aria-controls="collapse${parentId}">
                                    ${section}
                                </button>
                            </h2>
                            <div id="collapse${parentId}" class="accordion-collapse collapse ${isFirst ? 'show' : ''}" aria-labelledby="heading${parentId}" data-bs-parent="#mainAccordion">
                                <div class="accordion-body">
                                    <!-- Sub accordion will be inserted here -->
                                </div>
                            </div>
                        `;

                        const subAccordion = createSubAccordion(data, parentId);
                        accordionItem.querySelector('.accordion-body').appendChild(subAccordion);
                        mainAccordion.appendChild(accordionItem);
                    });
                }
            }

            function loadGlobalTimeline() {
                Papa.parse('atlas/evenement.csv', {
                    download: true,
                    header: true,
                    complete: function(results) {
                        const data = results.data.filter(event => event.majeur === 'oui');
                        const timeline = document.getElementById('globalTimeline');
                        data.forEach(event => {
                            const timelineItem = document.createElement('div');
                            timelineItem.className = 'timeline-item';
                            timelineItem.innerHTML = `
                                <h5>${event.date} - ${event.nom}</h5>
                                <p>${event.description}</p>
                            `;
                            timeline.appendChild(timelineItem);
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>
