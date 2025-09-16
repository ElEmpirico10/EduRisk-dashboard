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
            <div>
                <h1>Examenes</h1>
                <p>Gestión de estudiantes del sistema educativo</p>
            </div>
            <button class="btn-crear" onclick="openModal('createModal')">
                <i class="fas fa-plus"></i>
                Agregar examen
            </button>
        </div>

        

        <!-- Tabla de exámenes -->
        <div class="table-container">

            <div class="search-bar">
                
                <input type="text" class='search-input' placeholder="Buscar exámenes..." id="search-input">
                <i class="fas fa-search search-icon"></i>
            </div>

            <table class="table" id="examenesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Examen</th>
                        
                        <th>Fecha de Creación</th>
                        <th>Fecha de fin</th>
                        <th>habilitado</th>
                        <th>Estado</th>
                        <th>Preguntas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="examenesTableBody">
                    <tr>
                        <td>001</td>
                        <td>Examen de Ingreso - Programación</td>
                        
                        <td>15/03/2024</td>
                        <td>19/03/2024</td>
                        <td><span class="status-badge status-inactivo">FALSE</span></td>
                        <td><span class="status-badge status-active">Activo</span></td>
                        <td>29/30</td>
                        
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
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para crear examen -->
    <div class="modal" id="createModal">
        <div class="modal-content">
             <div class="modal-header">
                <h2 id="modalTitle">Agregar Nuevo Examen</h2>
                <span class="close" onclick="closeModal('createModal')">&times;</span>
            </div>
            
            <div class="modal-body">
                <form id="crearExamenForm">
                    <div class="form-grid">
                    <div class="form-group">
                        <label for="nombreExamen">Nombre del Examen</label>
                        <input type="text" id="nombreExamen" name="nombreExamen" class="form-control" placeholder="Ej: Examen de Ingreso - Programación" required>
                    </div>

                    
                        <div class="form-group">
                            <label for="fechaCreacion">Fecha de Creación</label>
                            <input type="date" id="fechaCreacion" name="fechaCreacion" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="fechaFin">Fecha de Fin</label>
                            <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                        </div>
                    

                    
                        <div class="form-group">
                            <label for="numPreguntas">Número de Preguntas</label>
                            <input type="number" id="numPreguntas" name="numPreguntas" class="form-control" placeholder="30" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="habilitado" name="habilitado">
                            <label for="habilitado">Habilitar examen</label>
                        </div>
                    </div>
                    </div>
                
                </form>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarExamen()">
                    <i class="fas fa-save"></i> Crear Examen
                </button>
            </div>
            </div>

            
        </div>
    </div>

    <script>
        // Función de búsqueda
        document.getElementById('search-input').addEventListener('input', function(e) {
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

        // Cerrar modal al hacer clic en el overlay
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                closeModal('createModal');
            }
        });

        // Cerrar modal con la tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('createModal');
            }
        });

        // Función para guardar el examen
        function guardarExamen() {
            const form = document.getElementById('crearExamenForm');
            const formData = new FormData(form);
            
            // Validar campos requeridos
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Obtener datos del formulario
            const examenData = {
                nombre: formData.get('nombreExamen'),
                fechaCreacion: formData.get('fechaCreacion'),
                fechaFin: formData.get('fechaFin'),
                numPreguntas: formData.get('numPreguntas'),
                estado: formData.get('estado'),
                habilitado: document.getElementById('habilitado').checked,
                descripcion: formData.get('descripcion')
            };

            // Aquí iría la lógica para enviar los datos al servidor
            console.log('Datos del examen:', examenData);
            
            // Simular guardado exitoso
            alert('Examen creado exitosamente');
            closeModal('createModal');
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