<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Croquis interactivo del campus universitario con información sobre edificios y pasantías disponibles">
    <title>Croquis Interactivo del Campus</title>
    <style>
        /* Variables CSS para mantener consistencia */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
            --shadow: 0 4px 8px rgba(0,0,0,0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        /* Estilos generales */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            color: var(--dark-color);
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 10px;
            font-size: 2.2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1rem;
            max-width: 600px;
        }

        /* Contenedor principal del mapa */
        #map-container {
            position: relative;
            max-width: 1133px;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background-color: white;
            overflow: hidden;
            margin-bottom: 30px;
        }

        /* Imagen del mapa */
        #map-image {
            display: block;
            width: 100%;
            height: auto;
            transition: var(--transition);
        }

        /* Estilo base para las áreas interactivas */
        .building-area {
            position: absolute;
            background-color: rgba(52, 152, 219, 0.2);
            border: 2px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
        }

        /* Efecto al pasar el ratón sobre un área */
        .building-area:hover {
            background-color: rgba(52, 152, 219, 0.4);
            border-color: var(--secondary-color);
            transform: scale(1.02);
            z-index: 20;
        }

        /* Efecto cuando un área está activa (seleccionada) */
        .building-area.active {
            background-color: rgba(231, 76, 60, 0.3);
            border-color: var(--accent-color);
            z-index: 15;
        }

        /* Posicionamiento y tamaño de cada área de edificio */
        #SC { top: 21%; left: 44%; width: 10%; height: 8%; }
        #QB { top: 30%; left: 44%; width: 10%; height: 8%; }
        #EE { top: 16%; left: 59%; width: 15%; height: 9%; }
        #UTD { top: 31%; left: 56%; width: 12%; height: 7%; }
        #I { top: 48%; left: 63%; width: 15%; height: 7%; }
        #MM { top: 61%; left: 65%; width: 22%; height: 7%; }

        /* Estilo del Tooltip mejorado */
        #tooltip {
            position: fixed;
            background-color: rgba(44, 62, 80, 0.95);
            color: white;
            padding: 12px 16px;
            border-radius: var(--border-radius);
            font-size: 14px;
            pointer-events: none;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            max-width: 300px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border-left: 4px solid var(--secondary-color);
        }

        #tooltip h3 {
            margin: 0 0 8px 0;
            font-size: 16px;
            color: var(--light-color);
        }
        
        #tooltip p {
            margin: 5px 0;
            line-height: 1.4;
        }

        #tooltip .internship-count {
            color: var(--success-color);
            font-weight: bold;
        }

        /* Estilo de la ventana Modal mejorada */
        #modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
            backdrop-filter: blur(3px);
        }

        #modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border: none;
            width: 90%;
            max-width: 700px;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: fadeIn 0.4s;
            position: relative;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        #modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        #modal-close:hover,
        #modal-close:focus {
            color: var(--accent-color);
            transform: scale(1.2);
        }

        #modal-title {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        
        #modal-body {
            line-height: 1.6;
        }

        #modal-body ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #modal-body li {
            background-color: #f8f9fa;
            border-left: 4px solid var(--secondary-color);
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 4px;
            transition: var(--transition);
        }

        #modal-body li:hover {
            background-color: #e9ecef;
            transform: translateX(5px);
        }
        
        #modal-body li strong {
            color: var(--primary-color);
            font-size: 1.1em;
            display: block;
            margin-bottom: 5px;
        }

        .schedule-info {
            background-color: #e8f4fc;
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border-left: 4px solid var(--secondary-color);
        }

        /* Panel de información lateral para dispositivos grandes */
        #info-panel {
            display: none;
            position: fixed;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-y: auto;
            z-index: 1500;
            transition: transform 0.3s ease;
        }

        #info-panel.active {
            display: block;
            transform: translateX(0);
        }

        #info-panel h3 {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 10px;
        }

        /* Botón para mostrar/ocultar el panel de información */
        #toggle-info {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: var(--shadow);
            z-index: 1001;
            transition: var(--transition);
        }

        #toggle-info:hover {
            background-color: var(--secondary-color);
            transform: scale(1.1);
        }

        /* Lista de edificios para navegación rápida */
        #building-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            max-width: 800px;
        }

        .building-btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .building-btn:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }
            
            #map-container {
                margin-bottom: 20px;
            }
            
            #building-list {
                gap: 5px;
            }
            
            .building-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            #modal-content {
                margin: 10% auto;
                padding: 20px;
                width: 95%;
            }
            
            #info-panel {
                width: 100%;
                height: auto;
                bottom: 0;
                top: auto;
                max-height: 50vh;
            }
        }

        /* Mejoras de accesibilidad */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus styles para mejor accesibilidad */
        .building-area:focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 2px;
        }

        .building-btn:focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 2px;
        }
    </style>
</head>
<body>

    <h1>Croquis Interactivo del Campus</h1>
    <p class="subtitle">Haz clic en cualquier edificio para ver las pasantías disponibles o pasa el cursor para obtener información rápida</p>

    <!-- Lista de botones para navegación rápida -->
    <div id="building-list">
        <button class="building-btn" data-id="SC">Sistemas y Computación</button>
        <button class="building-btn" data-id="QB">Química y Bioquímica</button>
        <button class="building-btn" data-id="EE">Eléctrica y Electrónica</button>
        <button class="building-btn" data-id="UTD">Aulas Generales UTD</button>
        <button class="building-btn" data-id="I">Ingeniería Industrial</button>
        <button class="building-btn" data-id="MM">Mecánica y Mecatrónica</button>
    </div>

    <div id="map-container">
        <img id="map-image" src="Captura de pantalla 2025-09-23 164627.jpg" alt="Croquis del campus universitario con edificios marcados">
        
        <!-- Áreas interactivas con etiquetas ARIA para accesibilidad -->
        <div class="building-area" id="SC" data-id="SC" role="button" aria-label="Edificio de Sistemas y Computación, haz clic para más información"></div>
        <div class="building-area" id="QB" data-id="QB" role="button" aria-label="Edificio de Química y Bioquímica, haz clic para más información"></div>
        <div class="building-area" id="EE" data-id="EE" role="button" aria-label="Edificio de Eléctrica y Electrónica, haz clic para más información"></div>
        <div class="building-area" id="UTD" data-id="UTD" role="button" aria-label="Aulas Generales UTD, haz clic para más información"></div>
        <div class="building-area" id="I" data-id="I" role="button" aria-label="Edificio de Ingeniería Industrial, haz clic para más información"></div>
        <div class="building-area" id="MM" data-id="MM" role="button" aria-label="Edificio de Mecánica y Mecatrónica, haz clic para más información"></div>
    </div>

    <div id="tooltip"></div>

    <!-- Botón para mostrar/ocultar panel de información -->
    <button id="toggle-info" aria-label="Mostrar u ocultar información general">ℹ️</button>

    <!-- Panel de información lateral -->
    <div id="info-panel">
        <h3>Información General del Campus</h3>
        <p>Este croquis interactivo te permite explorar los diferentes edificios del campus y descubrir las pasantías disponibles en cada uno.</p>
        <p><strong>Instrucciones:</strong></p>
        <ul>
            <li>Pasa el cursor sobre cualquier edificio para ver información rápida</li>
            <li>Haz clic en un edificio para ver detalles completos de las pasantías</li>
            <li>Usa los botones de arriba para navegar rápidamente a un edificio específico</li>
        </ul>
        <p><strong>Horario general de atención:</strong> Lunes a Viernes, 7:00 - 20:00</p>
    </div>

    <!-- Ventana Modal -->
    <div id="modal" role="dialog" aria-labelledby="modal-title" aria-modal="true">
        <div id="modal-content">
            <span id="modal-close" aria-label="Cerrar ventana">&times;</span>
            <h2 id="modal-title"></h2>
            <div id="modal-body"></div>
        </div>
    </div>

    <script>
        // --- BASE DE DATOS DE LOS EDIFICIOS ---
        const buildingData = {
            SC: {
                name: "Sistemas y Computación",
                schedule: "09:00 - 17:00",
                description: "Edificio dedicado a las tecnologías de la información y ciencias de la computación.",
                internships: [
                    { name: "Desarrollo Web Full-Stack", time: "Lunes y Miércoles, 10:00 - 12:00", instructor: "Dr. Alan Turing" },
                    { name: "Inteligencia Artificial Aplicada", time: "Martes y Jueves, 14:00 - 16:00", instructor: "Dra. Ada Lovelace" },
                    { name: "Seguridad Informática", time: "Viernes, 09:00 - 12:00", instructor: "Ing. Kevin Mitnick" }
                ]
            },
            QB: {
                name: "Química y Bioquímica",
                schedule: "08:00 - 16:00",
                description: "Centro de investigación y docencia en ciencias químicas y biológicas.",
                internships: [
                    { name: "Análisis de Muestras Biológicas", time: "Lunes y Viernes, 09:00 - 11:00", instructor: "Dra. Marie Curie" },
                    { name: "Química Orgánica Avanzada", time: "Martes y Jueves, 11:00 - 13:00", instructor: "Dr. Louis Pasteur" }
                ]
            },
            EE: {
                name: "Eléctrica y Electrónica",
                schedule: "08:30 - 18:00",
                description: "Edificio especializado en ingeniería eléctrica, electrónica y telecomunicaciones.",
                internships: [
                    { name: "Sistemas de Control Automático", time: "Miércoles, 15:00 - 18:00", instructor: "Ing. Nikola Tesla" },
                    { name: "Diseño de Circuitos Integrados", time: "Jueves, 09:00 - 12:00", instructor: "Dr. Thomas Edison" },
                    { name: "Telecomunicaciones y Redes", time: "Martes, 16:00 - 18:00", instructor: "Ing. Alexander Graham Bell" }
                ]
            },
            UTD: {
                name: "Aulas Generales UTD",
                schedule: "07:00 - 20:00",
                description: "Espacio multidisciplinario para clases y actividades académicas generales.",
                internships: [
                    { name: "Metodología de la Investigación", time: "Lunes, 18:00 - 20:00", instructor: "Lic. Carl Sagan" },
                    { name: "Cálculo Avanzado", time: "Miércoles y Viernes, 07:00 - 09:00", instructor: "Dr. Isaac Newton" }
                ]
            },
            I: {
                name: "Ingeniería Industrial",
                schedule: "08:00 - 19:00",
                description: "Centro de formación en optimización de procesos y gestión industrial.",
                internships: [
                    { name: "Optimización de Procesos", time: "Lunes y Miércoles, 11:00 - 13:00", instructor: "Ing. Henry Ford" },
                    { name: "Logística y Cadena de Suministro", time: "Martes y Jueves, 16:00 - 18:00", instructor: "M.C. Taiichi Ohno" }
                ]
            },
            MM: {
                name: "Mecánica y Mecatrónica",
                schedule: "07:30 - 18:30",
                description: "Edificio especializado en ingeniería mecánica, automatización y robótica.",
                internships: [
                    { name: "Diseño Asistido por Computadora (CAD)", time: "Viernes, 14:00 - 17:00", instructor: "Ing. Karl Benz" },
                    { name: "Robótica y Automatización", time: "Martes, 08:00 - 11:00", instructor: "Dr. James Watt" },
                    { name: "Termodinámica Aplicada", time: "Jueves, 12:00 - 14:00", instructor: "Ing. Rudolf Diesel" }
                ]
            }
        };

        // --- LÓGICA DE INTERACTIVIDAD MEJORADA ---

        document.addEventListener('DOMContentLoaded', () => {
            const areas = document.querySelectorAll('.building-area');
            const buildingButtons = document.querySelectorAll('.building-btn');
            const tooltip = document.getElementById('tooltip');
            const modal = document.getElementById('modal');
            const modalClose = document.getElementById('modal-close');
            const modalTitle = document.getElementById('modal-title');
            const modalBody = document.getElementById('modal-body');
            const toggleInfo = document.getElementById('toggle-info');
            const infoPanel = document.getElementById('info-panel');
            const mapImage = document.getElementById('map-image');

            let activeBuilding = null;

            // --- Función para mostrar información de un edificio ---
            function showBuildingInfo(buildingId) {
                const data = buildingData[buildingId];
                if (!data) return;

                // Resaltar el área del edificio
                areas.forEach(area => area.classList.remove('active'));
                const area = document.getElementById(buildingId);
                if (area) area.classList.add('active');
                
                activeBuilding = buildingId;
            }

            // --- Función para ocultar información del edificio ---
            function hideBuildingInfo() {
                areas.forEach(area => area.classList.remove('active'));
                activeBuilding = null;
            }

            // --- Lógica para el Tooltip (al pasar el ratón) ---
            areas.forEach(area => {
                area.addEventListener('mouseover', (event) => {
                    const buildingId = event.target.dataset.id;
                    const data = buildingData[buildingId];

                    if (data) {
                        tooltip.innerHTML = `
                            <h3>${data.name}</h3>
                            <p>${data.description}</p>
                            <p><span class="internship-count">${data.internships.length} pasantías</span> disponibles</p>
                            <p><strong>Horario del edificio:</strong> ${data.schedule}</p>
                            <p><em>Haz clic para más detalles</em></p>
                        `;
                        tooltip.style.visibility = 'visible';
                        tooltip.style.opacity = '1';
                    }
                });

                area.addEventListener('mousemove', (event) => {
                    tooltip.style.left = (event.pageX + 15) + 'px';
                    tooltip.style.top = (event.pageY + 15) + 'px';
                });

                area.addEventListener('mouseout', () => {
                    tooltip.style.visibility = 'hidden';
                    tooltip.style.opacity = '0';
                });

                // --- Lógica para el Modal (al hacer clic) ---
                area.addEventListener('click', (event) => {
                    const buildingId = event.target.dataset.id;
                    openModal(buildingId);
                });

                // Soporte para teclado (accesibilidad)
                area.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        const buildingId = event.target.dataset.id;
                        openModal(buildingId);
                    }
                });
            });

            // --- Función para abrir el modal ---
            function openModal(buildingId) {
                const data = buildingData[buildingId];
                if (!data) return;

                showBuildingInfo(buildingId);
                
                modalTitle.textContent = `Pasantías - ${data.name}`;
                
                let modalContent = `
                    <div class="schedule-info">
                        <p><strong>Horario del edificio:</strong> ${data.schedule}</p>
                        <p>${data.description}</p>
                    </div>
                `;
                
                if (data.internships.length > 0) {
                    let internshipListHTML = '<h3>Pasantías disponibles:</h3><ul>';
                    data.internships.forEach(internship => {
                        internshipListHTML += `
                            <li>
                                <strong>${internship.name}</strong><br>
                                <strong>Horario:</strong> ${internship.time}<br>
                                <strong>Imparte:</strong> ${internship.instructor}
                            </li>
                        `;
                    });
                    internshipListHTML += '</ul>';
                    modalContent += internshipListHTML;
                } else {
                    modalContent += '<p>Actualmente no hay pasantías disponibles en este edificio.</p>';
                }
                
                modalBody.innerHTML = modalContent;
                modal.style.display = 'block';
                
                // Enfocar el botón de cerrar para mejor accesibilidad
                modalClose.focus();
            }

            // --- Lógica para los botones de navegación rápida ---
            buildingButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const buildingId = button.dataset.id;
                    openModal(buildingId);
                });
            });

            // --- Lógica para cerrar el Modal ---
            modalClose.addEventListener('click', () => {
                modal.style.display = 'none';
                hideBuildingInfo();
            });

            window.addEventListener('click', (event) => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    hideBuildingInfo();
                }
            });

            // Cerrar modal con tecla Escape
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    modal.style.display = 'none';
                    hideBuildingInfo();
                }
            });

            // --- Lógica para el panel de información ---
            toggleInfo.addEventListener('click', () => {
                infoPanel.classList.toggle('active');
                toggleInfo.setAttribute('aria-expanded', infoPanel.classList.contains('active'));
            });

            // Cerrar panel de información al hacer clic fuera
            document.addEventListener('click', (event) => {
                if (!infoPanel.contains(event.target) && event.target !== toggleInfo && infoPanel.classList.contains('active')) {
                    infoPanel.classList.remove('active');
                    toggleInfo.setAttribute('aria-expanded', 'false');
                }
            });

            // --- Efectos de imagen al interactuar ---
            areas.forEach(area => {
                area.addEventListener('mouseenter', () => {
                    mapImage.style.filter = 'brightness(0.95)';
                });
                
                area.addEventListener('mouseleave', () => {
                    mapImage.style.filter = 'brightness(1)';
                });
            });
        });
    </script>

</body>
</html>