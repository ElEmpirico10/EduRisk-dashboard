<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | EduRisk</title>
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
     <?php include 'sidebar.php'; ?>
    <!-- Contenido principal -->
    <div class="main">
        <div class="main-header">
            <h1>Panel de Administración</h1>
            <p>Gestión integral del sistema educativo a través de <strong>EduRisk</strong></p>
        </div>

        <!-- Tarjetas de estadísticas principales -->
        <div class="cards">
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Total Aspirantes</h3>
                </div>
                <div class="card-value">120</div>
                <div class="card-subtitle">
                    <i class="fas fa-arrow-up"></i>
                    +15 este mes
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Total de Exámenes Registrados</h3>
                </div>
                <div class="card-value">42</div>
                <div class="card-subtitle">
                    <i class="fas fa-arrow-up"></i>
                    +8 este mes
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Programas</h3>
                </div>
                <div class="card-value">4</div>
                <div class="card-subtitle">
                    <i class="fas fa-check-circle"></i>
                    Todos activos
                </div>
            </div>
        </div>

        <!-- Paneles de estadísticas adicionales -->
        <div class="stats-grid">
            <div class="stats-panel">
                <h3>Análisis de Riesgo de Deserción</h3>
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Análisis y Desarrollo de Software</span>
                        <span>15%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 15%"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Entrenamiento Deportivo</span>
                        <span>28%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 28%"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Seguridad y Salud en el Trabajo</span>
                        <span>22%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 22%"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Diseño de Interiores</span>
                        <span>35%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 35%"></div>
                    </div>
                </div>
                <div style="margin-top: 20px; padding: 15px; background: rgba(255, 193, 7, 0.1); border-radius: 8px; border-left: 4px solid #ffc107;">
                    <small style="color: #856404; font-weight: 500;">
                        <i class="fas fa-info-circle"></i> 
                        Porcentajes basados en análisis de respuestas de exámenes de ingreso
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animación de las barras de progreso al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Efecto hover en las tarjetas
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>