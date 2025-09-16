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
            <button class="btn-crear" onclick="openModal('createModal')">
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

    <!-- Modal para crear pregunta -->
<div class="modal" id="createModal">
  <div class="modal-content">
    <!-- Encabezado -->
    <div class="modal-header">
      <h2 id="modalTitle">Agregar Nueva Pregunta</h2>
      <span class="close" onclick="closeModal('createModal')">&times;</span>
    </div>

    <!-- Cuerpo -->
    <div class="modal-body">
      <form id="crearPreguntaForm">
        <div class="form-grid">
          <!-- Texto de la pregunta -->
          <div class="form-group full-width">
            <label for="textoPregunta">Texto de la Pregunta</label>
            <textarea
              id="textoPregunta"
              name="textoPregunta"
              class="form-control"
              rows="3"
              placeholder="Escribe aquí el enunciado de la pregunta"
              required
            ></textarea>
          </div>

          <!-- Tipo de pregunta -->
          <div class="form-group">
            <label for="tipoPregunta">Tipo de Pregunta</label>
            <select
              id="tipoPregunta"
              name="tipoPregunta"
              class="form-control"
              required
            >
              <option value="">Selecciona un tipo</option>
              <option value="opcion-unica">Selección única (A, B, C...)</option>
              <option value="multiple">Selección múltiple</option>
              <option value="libre">Respuesta libre</option>
            </select>
          </div>

          <!-- Programa asignado -->
          <div class="form-group ">
            <label for="programaPregunta">Programa Asignado</label>
            <select
              id="programaPregunta"
              name="programaPregunta"
              class="form-control"
              required
            >
              <option value="">Selecciona el programa</option>
              <option value="analisis-desarrollo">
                Análisis y Desarrollo de Software
              </option>
              <option value="entrenamiento-deportivo">
                Entrenamiento Deportivo
              </option>
              <option value="seguridad-salud">
                Seguridad y Salud en el Trabajo
              </option>
              <option value="diseno-interiores">
                Diseño de Interiores
              </option>
            </select>
          </div>

          <!-- Contenido (según el tipo) -->
          <div class="form-group full-width">
            <label for="contenidoPregunta"
              >Contenido de la Pregunta (opciones o texto según el
              tipo)</label
            >
            <textarea
              id="contenidoPregunta"
              name="contenidoPregunta"
              class="form-control"
              rows="3"
              placeholder="Ejemplo: A) Opción 1&#10;B) Opción 2&#10;C) Opción 3"
            ></textarea>
          </div>

          
        </div>
      </form>

      <!-- Footer -->
      <div class="modal-footer">
        
        <button
          type="button"
          class="btn btn-primary"
          onclick="guardarPregunta()"
        >
          <i class="fas fa-save"></i> Guardar Pregunta
        </button>
      </div>
    </div>
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
        
    </script>
</body>
</html>