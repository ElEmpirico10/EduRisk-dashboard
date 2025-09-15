<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámenes | EduRisk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/examen.css">
</head>
<body>
    <!-- Sidebar -->
     <?php include 'sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="main">
        <div class="main-header">
            <h1>Gestión de Exámenes</h1>
            <p>Administra y organiza todos los exámenes del sistema educativo</p>
        </div>

        <!-- Controles -->
        <div class="controls">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar exámenes..." id="searchInput">
            </div>
            <button class="btn-primary" onclick="crearExamen()">
                <i class="fas fa-plus"></i>
                Crear Examen
            </button>
        </div>

        <!-- Tabla de exámenes -->
        <div class="table-container">
            <table class="table" id="examenesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Examen</th>
                        <th>Programa</th>
                        <th>Fecha de Creación</th>
                        <th>Estado</th>
                        <th>Preguntas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="examenesTableBody">
                    <tr>
                        <td>001</td>
                        <td>Examen de Ingreso - Programación</td>
                        <td>Análisis y Desarrollo de Software</td>
                        <td>15/03/2024</td>
                        <td><span class="status-badge status-active">Activo</span></td>
                        <td>25</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="verExamen(1)" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" onclick="modificarExamen(1)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="eliminarExamen(1)" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Evaluación Deportiva</td>
                        <td>Entrenamiento Deportivo</td>
                        <td>12/03/2024</td>
                        <td><span class="status-badge status-active">Activo</span></td>
                        <td>20</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="verExamen(2)" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" onclick="modificarExamen(2)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="eliminarExamen(2)" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Examen de Seguridad Laboral</td>
                        <td>Seguridad y Salud en el Trabajo</td>
                        <td>10/03/2024</td>
                        <td><span class="status-badge status-inactive">Inactivo</span></td>
                        <td>30</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="verExamen(3)" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" onclick="modificarExamen(3)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="eliminarExamen(3)" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>Evaluación de Diseño</td>
                        <td>Diseño de Interiores</td>
                        <td>08/03/2024</td>
                        <td><span class="status-badge status-active">Activo</span></td>
                        <td>18</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="verExamen(4)" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" onclick="modificarExamen(4)" title="Modificar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="eliminarExamen(4)" title="Eliminar">
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
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableBody = document.getElementById('examenesTableBody');
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });

        // Función para crear examen
        function crearExamen() {
            alert('Función para crear un nuevo examen - Aquí se abriría el modal o formulario de creación');
        }

        // Función para ver examen (no hace nada por ahora)
        function verExamen(id) {
            console.log(`Ver examen con ID: ${id}`);
            // No hace nada por ahora como solicitaste
        }

        // Función para modificar examen
        function modificarExamen(id) {
            alert(`Modificar examen con ID: ${id} - Aquí se abriría el formulario de edición`);
        }

        // Función para eliminar examen
        function eliminarExamen(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este examen?')) {
                // Aquí iría la lógica para eliminar
                alert(`Examen con ID: ${id} eliminado (simulación)`);
                
                // Simular eliminación visual
                const rows = document.querySelectorAll('#examenesTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent.includes(id.toString().padStart(3, '0'))) {
                        row.style.transition = 'opacity 0.3s ease';
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.remove();
                        }, 300);
                    }
                });
            }
        }

        // Animaciones al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#examenesTableBody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.5s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>