<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Digital - Liverpool</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --text-color: #333;
            --border-radius: 8px;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --primary-color: #34495e;
            --secondary-color: #2980b9;
            --accent-color: #c0392b;
            --light-color: #2c3e50;
            --dark-color: #ecf0f1;
            --text-color: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light-color);
            color: var(--text-color);
            transition: var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
        }

        .theme-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .container {
            display: flex;
            flex: 1;
            padding: 1rem;
            gap: 1rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .map-container {
            flex: 3;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .map-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: var(--transition);
        }

        .buildings-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 300px;
        }

        .buildings-list {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1rem;
            overflow-y: auto;
            max-height: 500px;
        }

        .building-item {
            padding: 0.8rem;
            margin-bottom: 0.5rem;
            background-color: var(--light-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .building-item:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateX(5px);
            border-left-color: var(--accent-color);
        }

        .building-item.active {
            background-color: var(--secondary-color);
            color: white;
            border-left-color: var(--accent-color);
        }

        .filters {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .filter-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
        }

        .popup {
            position: absolute;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1rem;
            z-index: 10;
            max-width: 250px;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition);
        }

        .popup.active {
            opacity: 1;
            pointer-events: all;
        }

        .popup h3 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .building-interior {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: none;
            flex-direction: column;
            padding: 1rem;
            z-index: 5;
        }

        .building-interior.active {
            display: flex;
        }

        .interior-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }

        .back-button {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .back-button:hover {
            background-color: var(--primary-color);
        }

        .floor-plan {
            display: flex;
            flex: 1;
            gap: 1rem;
        }

        .classrooms-left, .classrooms-right {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }

        .stairs {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            background-color: #f5f5f5;
            border-radius: var(--border-radius);
            font-weight: bold;
        }

        .classroom {
            padding: 1rem;
            background-color: var(--light-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .classroom:hover {
            background-color: var(--secondary-color);
            color: white;
        }

        .classroom-details {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: var(--border-radius);
            display: none;
        }

        .classroom-details.active {
            display: block;
        }

        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .buildings-panel {
                max-width: 100%;
            }
            
            .buildings-list {
                max-height: 200px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Campus Digital - Liverpool</h1>
        <button class="theme-toggle" id="themeToggle">🌙</button>
    </header>

    <div class="container">
        <div class="map-container" id="mapContainer">
            <img src="assets/croquis.png" alt="Croquis del Campus" class="map-image" id="campusMap">
            
            <div class="popup" id="buildingPopup">
                <h3 id="popupTitle">Edificio</h3>
                <p id="popupRooms">Número de aulas: </p>
            </div>

            <div class="building-interior" id="buildingInterior">
                <div class="interior-header">
                    <h2 id="interiorTitle">Edificio</h2>
                    <button class="back-button" id="backButton">Volver al mapa</button>
                </div>
                
                <div class="floor-plan">
                    <div class="classrooms-left" id="classroomsLeft">
                        <!-- Salones izquierda generados por JS -->
                    </div>
                    
                    <div class="stairs">
                        Escaleras
                    </div>
                    
                    <div class="classrooms-right" id="classroomsRight">
                        <!-- Salones derecha generados por JS -->
                    </div>
                </div>
                
                <div class="classroom-details" id="classroomDetails">
                    <h3 id="classroomName">Salón</h3>
                    <p id="classroomClass">Clase: </p>
                    <p id="classroomTeacher">Maestro: </p>
                </div>
            </div>
        </div>

        <div class="buildings-panel">
            <div class="filters">
                <input type="text" class="filter-input" id="filterInput" placeholder="Filtrar por edificio...">
            </div>
            
            <div class="buildings-list" id="buildingsList">
                <!-- Lista de edificios generada por JS -->
            </div>
        </div>
    </div>

    <footer>
        <p>Plataforma Digital del Campus Liverpool - © 2023</p>
    </footer>

    <script>
        // Datos de ejemplo para los edificios y salones
        const campusData = {
            buildings: [
                {
                    id: "sc",
                    name: "SISTEMAS Y CONDUTACIÓN",
                    code: "SC",
                    rooms: 12,
                    description: "Aulas SE"
                },
                {
                    id: "qb",
                    name: "QUÍMICA Y BIOCUÑICA",
                    code: "QB",
                    rooms: 9,
                    description: "Aulas QB"
                },
                {
                    id: "ee",
                    name: "LECTRICA ELECTRÓNICA",
                    code: "EE",
                    rooms: 7,
                    description: "Aula de la Cabeza"
                },
                {
                    id: "utd",
                    name: "QUÍMICA Y BIOCUÑICA",
                    code: "UTD",
                    rooms: 9,
                    description: "Aulas UTD 1-9"
                },
                {
                    id: "i",
                    name: "INDUSTRIAL",
                    code: "I",
                    rooms: 12,
                    description: "Aulas 1-12"
                },
                {
                    id: "mm",
                    name: "MECÁNICA Y MECAN DÓLICA",
                    code: "MM",
                    rooms: 15,
                    description: "Mecánica y Mecan Dólica"
                }
            ]
        };

        // Datos de ejemplo para las clases
        const classData = {
            "sc": [
                { room: "SC-101", className: "Sistemas Operativos", teacher: "Dr. Rodríguez" },
                { room: "SC-102", className: "Redes de Computadoras", teacher: "Dra. Martínez" },
                { room: "SC-103", className: "Bases de Datos", teacher: "Ing. López" },
                { room: "SC-104", className: "Programación Avanzada", teacher: "Mtro. García" },
                { room: "SC-105", className: "Inteligencia Artificial", teacher: "Dr. Hernández" },
                { room: "SC-106", className: "Seguridad Informática", teacher: "Dra. Pérez" },
                { room: "SC-107", className: "Arquitectura de Computadoras", teacher: "Ing. Sánchez" }
            ],
            "qb": [
                { room: "QB-201", className: "Química Orgánica", teacher: "Dr. Vargas" },
                { room: "QB-202", className: "Bioquímica General", teacher: "Dra. Flores" },
                { room: "QB-203", className: "Análisis Instrumental", teacher: "QFB. Ramírez" },
                { room: "QB-204", className: "Química Inorgánica", teacher: "Dra. Torres" },
                { room: "QB-205", className: "Biología Molecular", teacher: "Dr. Cruz" },
                { room: "QB-206", className: "Microbiología", teacher: "Dra. Reyes" },
                { room: "QB-207", className: "Genética", teacher: "Dr. Morales" }
            ],
            "ee": [
                { room: "EE-301", className: "Circuitos Eléctricos", teacher: "Ing. Ortega" },
                { room: "EE-302", className: "Electrónica Digital", teacher: "Dra. Silva" },
                { room: "EE-303", className: "Sistemas de Control", teacher: "Dr. Mendoza" },
                { room: "EE-304", className: "Máquinas Eléctricas", teacher: "Ing. Rojas" },
                { room: "EE-305", className: "Instalaciones Eléctricas", teacher: "Mtro. Castro" },
                { room: "EE-306", className: "Electrónica de Potencia", teacher: "Dra. Guzmán" }
            ],
            "utd": [
                { room: "UTD-401", className: "Termodinámica", teacher: "Dr. Navarro" },
                { room: "UTD-402", className: "Mecánica de Fluidos", teacher: "Dra. Jiménez" },
                { room: "UTD-403", className: "Transferencia de Calor", teacher: "Ing. Ruiz" },
                { room: "UTD-404", className: "Operaciones Unitarias", teacher: "Dr. Medina" },
                { room: "UTD-405", className: "Ingeniería de Reactores", teacher: "Dra. Herrera" },
                { room: "UTD-406", className: "Control de Procesos", teacher: "Mtro. Vega" }
            ],
            "i": [
                { room: "I-501", className: "Procesos de Manufactura", teacher: "Ing. Paredes" },
                { room: "I-502", className: "Logística y Cadena de Suministro", teacher: "Dra. Campos" },
                { room: "I-503", className: "Gestión de Calidad", teacher: "Dr. Salazar" },
                { room: "I-504", className: "Ergonomía", teacher: "Dra. Ríos" },
                { room: "I-505", className: "Planeación de la Producción", teacher: "Ing. Miranda" },
                { room: "I-506", className: "Simulación de Sistemas", teacher: "Mtro. Núñez" }
            ],
            "mm": [
                { room: "MM-601", className: "Mecánica de Materiales", teacher: "Dr. Espinoza" },
                { room: "MM-602", className: "Diseño Mecánico", teacher: "Dra. Acosta" },
                { room: "MM-603", className: "Vibraciones Mecánicas", teacher: "Ing. Valdez" },
                { room: "MM-604", className: "Mecánica de Fluidos", teacher: "Dr. Cortés" },
                { room: "MM-605", className: "Termodinámica Aplicada", teacher: "Dra. León" },
                { room: "MM-606", className: "Elementos Finitos", teacher: "Mtro. Méndez" },
                { room: "MM-607", className: "Robótica", teacher: "Ing. Orozco" }
            ]
        };

        // Elementos DOM
        const buildingsList = document.getElementById('buildingsList');
        const mapContainer = document.getElementById('mapContainer');
        const campusMap = document.getElementById('campusMap');
        const buildingPopup = document.getElementById('buildingPopup');
        const popupTitle = document.getElementById('popupTitle');
        const popupRooms = document.getElementById('popupRooms');
        const buildingInterior = document.getElementById('buildingInterior');
        const interiorTitle = document.getElementById('interiorTitle');
        const backButton = document.getElementById('backButton');
        const classroomsLeft = document.getElementById('classroomsLeft');
        const classroomsRight = document.getElementById('classroomsRight');
        const classroomDetails = document.getElementById('classroomDetails');
        const classroomName = document.getElementById('classroomName');
        const classroomClass = document.getElementById('classroomClass');
        const classroomTeacher = document.getElementById('classroomTeacher');
        const filterInput = document.getElementById('filterInput');
        const themeToggle = document.getElementById('themeToggle');

        // Variables de estado
        let currentBuilding = null;
        let popupTimeout;

        // Inicializar la aplicación
        function init() {
            renderBuildingsList();
            setupEventListeners();
        }

        // Renderizar la lista de edificios
        function renderBuildingsList(filter = '') {
            buildingsList.innerHTML = '';
            
            campusData.buildings
                .filter(building => 
                    building.name.toLowerCase().includes(filter.toLowerCase()) ||
                    building.code.toLowerCase().includes(filter.toLowerCase())
                )
                .forEach(building => {
                    const buildingItem = document.createElement('div');
                    buildingItem.className = 'building-item';
                    buildingItem.dataset.id = building.id;
                    buildingItem.innerHTML = `
                        <strong>${building.code}</strong> - ${building.name}
                        <br><small>${building.description}</small>
                    `;
                    buildingsList.appendChild(buildingItem);
                });
        }

        // Configurar event listeners
        function setupEventListeners() {
            // Eventos para los elementos de edificio
            buildingsList.addEventListener('click', (e) => {
                const buildingItem = e.target.closest('.building-item');
                if (buildingItem) {
                    const buildingId = buildingItem.dataset.id;
                    selectBuilding(buildingId);
                }
            });

            buildingsList.addEventListener('mouseover', (e) => {
                const buildingItem = e.target.closest('.building-item');
                if (buildingItem) {
                    const buildingId = buildingItem.dataset.id;
                    showBuildingPopup(buildingId, buildingItem);
                }
            });

            buildingsList.addEventListener('mouseout', () => {
                hideBuildingPopup();
            });

            // Evento para el botón de volver
            backButton.addEventListener('click', () => {
                hideBuildingInterior();
            });

            // Evento para el filtro
            filterInput.addEventListener('input', (e) => {
                renderBuildingsList(e.target.value);
            });

            // Evento para el toggle del tema
            themeToggle.addEventListener('click', toggleTheme);
        }

        // Mostrar popup del edificio
        function showBuildingPopup(buildingId, element) {
            const building = campusData.buildings.find(b => b.id === buildingId);
            if (!building) return;

            popupTitle.textContent = building.name;
            popupRooms.textContent = `Número de aulas: ${building.rooms}`;
            
            // Posicionar el popup
            const rect = element.getBoundingClientRect();
            const containerRect = mapContainer.getBoundingClientRect();
            
            buildingPopup.style.top = `${rect.top - containerRect.top}px`;
            buildingPopup.style.left = `${rect.right - containerRect.left + 10}px`;
            
            buildingPopup.classList.add('active');
            
            // Limpiar timeout anterior
            if (popupTimeout) clearTimeout(popupTimeout);
        }

        // Ocultar popup del edificio
        function hideBuildingPopup() {
            popupTimeout = setTimeout(() => {
                buildingPopup.classList.remove('active');
            }, 300);
        }

        // Seleccionar un edificio (hacer clic)
        function selectBuilding(buildingId) {
            const building = campusData.buildings.find(b => b.id === buildingId);
            if (!building) return;

            currentBuilding = building;
            
            // Actualizar elementos activos
            document.querySelectorAll('.building-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`.building-item[data-id="${buildingId}"]`).classList.add('active');
            
            // Mostrar vista interior del edificio
            showBuildingInterior();
        }

        // Mostrar vista interior del edificio
        function showBuildingInterior() {
            if (!currentBuilding) return;
            
            interiorTitle.textContent = currentBuilding.name;
            
            // Renderizar salones
            renderClassrooms();
            
            // Animación de zoom
            campusMap.style.transform = 'scale(1.1)';
            campusMap.style.opacity = '0.7';
            
            setTimeout(() => {
                buildingInterior.classList.add('active');
                campusMap.style.transform = 'scale(1)';
                campusMap.style.opacity = '1';
            }, 300);
        }

        // Ocultar vista interior del edificio
        function hideBuildingInterior() {
            buildingInterior.classList.remove('active');
            classroomDetails.classList.remove('active');
            
            // Restablecer elementos activos
            document.querySelectorAll('.building-item').forEach(item => {
                item.classList.remove('active');
            });
        }

        // Renderizar salones del edificio
        function renderClassrooms() {
            if (!currentBuilding) return;
            
            classroomsLeft.innerHTML = '';
            classroomsRight.innerHTML = '';
            
            const classrooms = classData[currentBuilding.id] || [];
            
            // 7 salones a la izquierda
            for (let i = 0; i < 7; i++) {
                const classroom = classrooms[i] || { room: `Salón ${i+1}`, className: 'Disponible', teacher: 'Por asignar' };
                
                const classroomElement = document.createElement('div');
                classroomElement.className = 'classroom';
                classroomElement.textContent = classroom.room;
                classroomElement.dataset.room = classroom.room;
                classroomElement.dataset.className = classroom.className;
                classroomElement.dataset.teacher = classroom.teacher;
                
                classroomElement.addEventListener('click', showClassroomDetails);
                classroomsLeft.appendChild(classroomElement);
            }
            
            // 6 salones a la derecha
            for (let i = 7; i < 13; i++) {
                const classroom = classrooms[i] || { room: `Salón ${i+1}`, className: 'Disponible', teacher: 'Por asignar' };
                
                const classroomElement = document.createElement('div');
                classroomElement.className = 'classroom';
                classroomElement.textContent = classroom.room;
                classroomElement.dataset.room = classroom.room;
                classroomElement.dataset.className = classroom.className;
                classroomElement.dataset.teacher = classroom.teacher;
                
                classroomElement.addEventListener('click', showClassroomDetails);
                classroomsRight.appendChild(classroomElement);
            }
        }

        // Mostrar detalles del salón
        function showClassroomDetails(e) {
            const room = e.target.dataset.room;
            const className = e.target.dataset.className;
            const teacher = e.target.dataset.teacher;
            
            classroomName.textContent = room;
            classroomClass.textContent = `Clase: ${className}`;
            classroomTeacher.textContent = `Maestro: ${teacher}`;
            
            classroomDetails.classList.add('active');
        }

        // Cambiar entre modo claro y oscuro
        function toggleTheme() {
            const currentTheme = document.body.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                document.body.removeAttribute('data-theme');
                themeToggle.textContent = '🌙';
            } else {
                document.body.setAttribute('data-theme', 'dark');
                themeToggle.textContent = '☀️';
            }
        }

        // Inicializar la aplicación cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>