<?php
// Configurar zona horaria
date_default_timezone_set('America/Mexico_City'); // Ajusta a tu zona horaria
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        .header-container {
            background: linear-gradient(to right, #1a73e8, #34a853);
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .datetime-container {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 0.9rem;
        }

        .date-display, .time-display {
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .marquee-container {
            background: rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            margin-top: 10px;
            overflow: hidden;
        }

        .marquee {
            white-space: nowrap;
            animation: marquee 30s linear infinite;
            color: #ffffff;
            font-size: 0.9rem;
        }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .logo-text:hover {
            text-shadow: 0 0 10px rgba(255,255,255,0.5);
            transform: translateY(-1px);
        }

        .header-controls {
            display: flex;
            gap: 15px;
        }

        .header-button {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .header-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .datetime-container {
                flex-direction: column;
                gap: 10px;
            }

            .header-controls {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header class="header-container">
        <div class="header-top">
            <div class="logo-container">
                <a href="index.php" class="logo-text">
                    <i class="fas fa-video"></i>
                    HLS Stream Recorder
                </a>
            </div>

            <div class="datetime-container">
                <div class="date-display">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDate"><?php echo date('d/m/Y'); ?></span>
                </div>
                <div class="time-display">
                    <i class="fas fa-clock"></i>
                    <span id="currentTime"><?php echo date('H:i:s'); ?></span>
                </div>
            </div>

            <div class="header-controls">
                <a href="faq.php" class="header-button">
                    <i class="fas fa-question-circle"></i>
                    FAQ
                </a>
                <a href="tutorial.php" class="header-button">
                    <i class="fas fa-book"></i>
                    Tutorial
                </a>
                <a href="https://github.com/sabalero23/hls-stream-recorder" class="header-button" target="_blank">
                    <i class="fab fa-github"></i>
                    GitHub
                </a>
            </div>
        </div>

        <div class="marquee-container">
            <div class="marquee">
                🎥 Bienvenido a HLS Stream Recorder - Graba y gestiona tus streams HLS con facilidad 
                📊 Almacenamiento disponible: 10GB por usuario 
                🔄 Actualización automática de calidad 
                💾 Grabación en formato WebM optimizado 
                🎉 Nueva versión 1.0.0 disponible 
                📱 Compatible con todos los dispositivos
            </div>
        </div>
    </header>

    <script>
        // Actualizar fecha y hora en tiempo real
        function updateDateTime() {
            const now = new Date();
            
            // Actualizar fecha
            const dateOptions = { day: '2-digit', month: '2-digit', year: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('es-ES', dateOptions);
            
            // Actualizar hora
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('es-ES', timeOptions);
        }

        // Actualizar cada segundo
        setInterval(updateDateTime, 1000);

        // Función para pausar/reanudar la marquesina al pasar el mouse
        document.querySelector('.marquee-container').addEventListener('mouseover', function() {
            document.querySelector('.marquee').style.animationPlayState = 'paused';
        });

        document.querySelector('.marquee-container').addEventListener('mouseout', function() {
            document.querySelector('.marquee').style.animationPlayState = 'running';
        });

        // Crear efecto de ondulación en los botones
        document.querySelectorAll('.header-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                ripple.classList.add('ripple');
                
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>