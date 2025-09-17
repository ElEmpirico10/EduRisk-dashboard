<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes | EduRisk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/ficha.css">
    
</head>
<body>
    <!-- Sidebar -->
     <?php include 'sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="main">
        <div class="main-header">
            <div>
                <h1>Fichas</h1>
                <p>Modulo para la creacion y seguimiento de ficha</p>
            </div>
            <button class="btn-crear" onclick="openModal('createModal')">
                <i class="fas fa-plus"></i>
                Agregar Ficha
            </button>
        </div>

        <div class="estudiantes-container">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Buscar ficha por nombre o codigo..." id="searchInput">
                <i class="fas fa-search search-icon"></i>
            </div>

            <table class="estudiantes-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        
                        <th>ficha</th>
                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="estudiantesTableBody">
                    <tr>
                        
                        <td>01</td>
                        <td>adso</td>
                        <td>2933470</td>
                        
                        
                       
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
                    
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Crear/Editar Estudiante -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Agregar Nueva Ficha</h2>
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
                            <label for="Ficha">Ficha *</label>
                            <input type="text" id="ficha" name="ficha" class="form-control" required>
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
                document.getElementById('apelido').value = 'cano';
                document.getElementById('documento').value = '12345678';
                document.getElementById('email').value = 'juan.perez@email.com';
                document.getElementById('tipo_documento').value = 'veneco';
               console.log(id)
                document.getElementById('password').value = '';
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