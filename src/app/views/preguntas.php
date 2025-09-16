<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas | EduRisk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/preguntas.css">
</head>
<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="main">
        <div class="main-header">
            <div>
                <h1>Preguntas</h1>
                <p>Gestión de preguntas del sistema educativo</p>
            </div>
            <button class="btn-crear" onclick="crearPregunta()">
                <i class="fas fa-plus"></i>
                Agregar pregunta
            </button>
        </div>

        <!-- Tabla de preguntas -->
        <div class="table-container">
            <div class="search-filter-container">
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Buscar preguntas..." id="search-input">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="filter-container">
                    <select class="filter-select" id="tipo-filter">
                        <option value="">Todos los tipos</option>
                        <option value="Selección múltiple">Selección múltiple</option>
                        <option value="Verdadero/Falso">Verdadero/Falso</option>
                        <option value="Texto libre">Texto libre</option>
                        <option value="Completar">Completar</option>
                    </select>
                </div>
            </div>

            <table class="table" id="preguntasTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pregunta</th>
                        <th>Tipo de Pregunta</th>
                        <th>Materia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="preguntasTableBody">
                    <tr>
                        <td>001</td>
                        <td class="pregunta-text">¿Cuál es el resultado de 2 + 2 en programación básica?</td>
                        <td><span class="tipo-pregunta">Selección múltiple</span></td>
                        <td>Programación</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="verPregunta(1)" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" onclick="modificarPregunta(1)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="eliminarPregunta(1)" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Función de búsqueda
        document.getElementById('search-input').addEventListener('input', function(e) {
            filterTable();
        });

        // Función de filtro por tipo
        document.getElementById('tipo-filter').addEventListener('change', function(e) {
            filterTable();
        });

        function filterTable() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const filterType = document.getElementById('tipo-filter').value.toLowerCase();
            const tableBody = document.getElementById('preguntasTableBody');
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                const tipo = row.cells[2].textContent.toLowerCase();
                
                const matchesSearch = text.includes(searchTerm);
                const matchesFilter = filterType === '' || tipo.includes(filterType);
                
                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        function crearPregunta() {
            alert('Función para crear una nueva pregunta');
        }

        function verPregunta(id) {
            console.log(`Ver pregunta con ID: ${id}`);
        }

        function modificarPregunta(id) {
            alert(`Modificar pregunta con ID: ${id}`);
        }

        function eliminarPregunta(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta pregunta?')) {
                alert(`Pregunta con ID: ${id} eliminada`);
            }
        }
    </script>
</body>
</html>