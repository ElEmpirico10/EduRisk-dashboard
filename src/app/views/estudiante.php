<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes | EduRisk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/estudiante.css">
    
</head>
<body>
    <!-- Sidebar -->
     <?php include 'sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="main">
        <div class="main-header">
            <div>
                <h1>Estudiantes</h1>
                <p>Gestión de estudiantes del sistema educativo</p>
            </div>
            <button class="btn-crear" onclick="openModal('createModal')">
                <i class="fas fa-plus"></i>
                Agregar Estudiante
            </button>
        </div>

        <div class="estudiantes-container">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Buscar estudiante por nombre, documento o programa..." id="searchInput">
                <i class="fas fa-search search-icon"></i>
            </div>

            <table class="estudiantes-table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Documento</th>
                        <th>Programa</th>
                        <th>Estado</th>
                        <th>Fecha Ingreso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="estudiantesTableBody">
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">JD</div>
                                <div class="student-details">
                                    <h4>Juan David Pérez</h4>
                                    <p>juan.perez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td>12345678</td>
                        <td>Análisis y Desarrollo de Software</td>
                        <td><span class="status-badge status-activo">Activo</span></td>
                        <td>15/01/2024</td>
                        <td>
                            <div class="actions-buttons">
                                <button class="btn-action btn-edit" onclick="editStudent(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteStudent(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">MG</div>
                                <div class="student-details">
                                    <h4>María González</h4>
                                    <p>maria.gonzalez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td>87654321</td>
                        <td>Diseño de Interiores</td>
                        <td><span class="status-badge status-activo">Activo</span></td>
                        <td>20/02/2024</td>
                        <td>
                            <div class="actions-buttons">
                                <button class="btn-action btn-edit" onclick="editStudent(2)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteStudent(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">CR</div>
                                <div class="student-details">
                                    <h4>Carlos Rodríguez</h4>
                                    <p>carlos.rodriguez@email.com</p>
                                </div>
                            </div>
                        </td>
                        <td>11223344</td>
                        <td>Entrenamiento Deportivo</td>
                        <td><span class="status-badge status-inactivo">Inactivo</span></td>
                        <td>10/03/2024</td>
                        <td>
                            <div class="actions-buttons">
                                <button class="btn-action btn-edit" onclick="editStudent(3)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteStudent(3)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear/Editar Estudiante -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Agregar Nuevo Estudiante</h2>
                <span class="close" onclick="closeModal('createModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="studentForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido *</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="documento">Documento *</label>
                            <input type="text" id="documento" name="documento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control">
                        </div>
                        <div class="form-group full-width">
                            <label for="email">Correo Electrónico *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="programa">Programa *</label>
                            <select id="programa" name="programa" class="form-control" required>
                                <option value="">Seleccionar programa</option>
                                <option value="analisis-desarrollo">Análisis y Desarrollo de Software</option>
                                <option value="entrenamiento-deportivo">Entrenamiento Deportivo</option>
                                <option value="seguridad-salud">Seguridad y Salud en el Trabajo</option>
                                <option value="diseño-interiores">Diseño de Interiores</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_ingreso">Fecha de Ingreso *</label>
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Cancelar</button>
                <button type="button" class="btn-primary" onclick="saveStudent()">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        let editingStudentId = null;

        // Funciones del Modal
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
        }

        function resetForm() {
            document.getElementById('studentForm').reset();
            document.getElementById('modalTitle').textContent = 'Agregar Nuevo Estudiante';
            editingStudentId = null;
        }

        // Función para editar estudiante
        function editStudent(id) {
            editingStudentId = id;
            document.getElementById('modalTitle').textContent = 'Editar Estudiante';
            
            // Aquí cargarías los datos del estudiante desde tu base de datos
            // Por ahora, datos de ejemplo
            if (id === 1) {
                document.getElementById('nombre').value = 'Juan David';
                document.getElementById('apellido').value = 'Pérez';
                document.getElementById('documento').value = '12345678';
                document.getElementById('email').value = 'juan.perez@email.com';
                document.getElementById('telefono').value = '3001234567';
                document.getElementById('programa').value = 'analisis-desarrollo';
                document.getElementById('fecha_ingreso').value = '2024-01-15';
                document.getElementById('direccion').value = 'Calle 123 #45-67';
            }
            
            openModal('createModal');
        }

        // Función para eliminar estudiante
        function deleteStudent(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este estudiante?')) {
                // Aquí implementarías la lógica para eliminar el estudiante
                console.log('Eliminando estudiante con ID:', id);
                alert('Estudiante eliminado correctamente');
                // Recargar la tabla
            }
        }

        // Función para guardar estudiante
        function saveStudent() {
            const form = document.getElementById('studentForm');
            const formData = new FormData(form);
            
            // Validación básica
            if (!form.checkValidity()) {
                alert('Por favor, completa todos los campos obligatorios');
                return;
            }

            // Aquí implementarías la lógica para guardar en la base de datos
            console.log('Guardando estudiante:', Object.fromEntries(formData));
            
            if (editingStudentId) {
                alert('Estudiante actualizado correctamente');
            } else {
                alert('Estudiante creado correctamente');
            }
            
            closeModal('createModal');
            // Aquí recargarías la tabla con los nuevos datos
        }

        // Función de búsqueda
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('#estudiantesTableBody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    resetForm();
                }
            });
        }

        // Establecer fecha actual por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha_ingreso').value = today;
        });
    </script>
</body>
</html>