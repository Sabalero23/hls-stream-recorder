
<?php
// terms.php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos de Uso - HLS Stream Recorder</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --background-color: #f0f2f5;
            --text-color: #333;
            --border-radius: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .policy-section {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1, h2, h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }

        h2 {
            font-size: 1.8em;
            margin-top: 30px;
        }

        h3 {
            font-size: 1.3em;
            color: var(--secondary-color);
        }

        p, ul, ol {
            margin-bottom: 15px;
        }

        ul, ol {
            padding-left: 20px;
        }

        .highlight-box {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid var(--secondary-color);
        }

        .warning-box {
            background: #fff3e0;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #ff9800;
        }

        .last-updated {
            text-align: right;
            color: #666;
            font-style: italic;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .toc {
            background: #f8f9fa;
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
        }

        .toc ul {
            list-style: none;
            padding-left: 0;
        }

        .toc li {
            margin-bottom: 10px;
        }

        .toc a {
            color: var(--text-color);
            text-decoration: none;
        }

        .toc a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<header>
<?php include 'header.php'; ?>
</header>
<body>
    <div class="container">
        <h1>Términos de Uso</h1>

        <div class="last-updated">
            Última actualización: <?php echo date('d/m/Y'); ?>
        </div>

        <div class="toc policy-section">
            <h2>Contenido</h2>
            <ul>
                <li><a href="#aceptacion">1. Aceptación de Términos</a></li>
                <li><a href="#servicio">2. Descripción del Servicio</a></li>
                <li><a href="#cuenta">3. Cuenta de Usuario</a></li>
                <li><a href="#uso">4. Uso Aceptable</a></li>
                <li><a href="#contenido">5. Contenido y Derechos</a></li>
                <li><a href="#limitaciones">6. Limitaciones de Uso</a></li>
                <li><a href="#responsabilidad">7. Responsabilidad</a></li>
                <li><a href="#terminacion">8. Terminación</a></li>
                <li><a href="#modificaciones">9. Modificaciones</a></li>
                <li><a href="#general">10. Disposiciones Generales</a></li>
            </ul>
        </div>

        <section id="aceptacion" class="policy-section">
            <h2>1. Aceptación de Términos</h2>
            <p>Al acceder y utilizar HLS Stream Recorder, usted acepta estar legalmente vinculado por estos términos.</p>
            
            <div class="warning-box">
                <p><strong>Importante:</strong> Si no está de acuerdo con estos términos, no utilice la aplicación.</p>
            </div>
        </section>

        <section id="servicio" class="policy-section">
            <h2>2. Descripción del Servicio</h2>
            
            <h3>2.1 Funcionalidades</h3>
            <ul>
                <li>Reproducción de streams HLS</li>
                <li>Grabación de contenido</li>
                <li>Almacenamiento temporal</li>
                <li>Gestión de grabaciones</li>
                <li>Descarga de contenido</li>
            </ul>

            <h3>2.2 Limitaciones del Servicio</h3>
            <table>
                <tr>
                    <th>Recurso</th>
                    <th>Límite</th>
                    <th>Período</th>
                </tr>
                <tr>
                    <td>Almacenamiento</td>
                    <td>10GB</td>
                    <td>Por usuario</td>
                </tr>
                <tr>
                    <td>Grabaciones simultáneas</td>
                    <td>1</td>
                    <td>Por sesión</td>
                </tr>
                <tr>
                    <td>Retención de archivos</td>
                    <td>30 días</td>
                    <td>Máximo</td>
                </tr>
            </table>
        </section>

        <section id="cuenta" class="policy-section">
            <h2>3. Cuenta de Usuario</h2>
            
            <h3>3.1 Registro</h3>
            <ul>
                <li>Información precisa y actualizada</li>
                <li>Credenciales seguras</li>
                <li>Confidencialidad de la cuenta</li>
                <li>Una cuenta por usuario</li>
            </ul>

            <h3>3.2 Responsabilidades</h3>
            <p>Usted es responsable de:</p>
            <ul>
                <li>Mantener la seguridad de su cuenta</li>
                <li>Todas las actividades bajo su cuenta</li>
                <li>Notificar cualquier uso no autorizado</li>
                <li>Actualizar su información</li>
            </ul>

            <div class="warning-box">
                <p><strong>Aviso:</strong> El uso compartido de cuentas está estrictamente prohibido.</p>
            </div>
        </section>

        <section id="uso" class="policy-section">
            <h2>4. Uso Aceptable</h2>
            
            <h3>4.1 Usos Permitidos</h3>
            <ul>
                <li>Grabación de contenido propio</li>
                <li>Contenido con derechos autorizados</li>
                <li>Uso personal o educativo</li>
                <li>Streams públicos autorizados</li>
            </ul>

            <h3>4.2 Usos Prohibidos</h3>
            <ul>
                <li>Contenido ilegal o no autorizado</li>
                <li>Violación de derechos de autor</li>
                <li>Distribución no autorizada</li>
                <li>Uso comercial sin licencia</li>
                <li>Manipulación del sistema</li>
                <li>Ingeniería inversa</li>
            </ul>

            <div class="highlight-box">
                <p>El incumplimiento puede resultar en la terminación inmediata de la cuenta.</p>
            </div>
        </section>

        <section id="contenido" class="policy-section">
            <h2>5. Contenido y Derechos</h2>
            
            <h3>5.1 Propiedad Intelectual</h3>
            <p>El usuario es responsable de asegurar que tiene los derechos necesarios para:</p>
            <ul>
                <li>Grabar el contenido</li>
                <li>Almacenar las grabaciones</li>
                <li>Distribuir el contenido</li>
                <li>Usar el contenido según lo previsto</li>
            </ul>

            <h3>5.2 Nuestros Derechos</h3>
            <p>HLS Stream Recorder se reserva el derecho a:</p>
            <ul>
                <li>Eliminar contenido infractor</li>
                <li>Suspender cuentas sospechosas</li>
                <li>Reportar actividades ilegales</li>
                <li>Modificar o terminar el servicio</li>
            </ul>
        </section>

        <section id="limitaciones" class="policy-section">
            <h2>6. Limitaciones de Uso</h2>
            
            <h3>6.1 Restricciones Técnicas</h3>
            <ul>
                <li>Límites de ancho de banda</li>
                <li>Tamaño máximo de archivos</li>
                <li>Formatos soportados</li>
                <li>Duración de grabaciones</li>
            </ul>

            <h3>6.2 Restricciones de Acceso</h3>
            <p>No está permitido:</p>
            <ul>
                <li>Usar VPNs para evadir restricciones</li>
                <li>Automatizar grabaciones masivas</li>
                <li>Compartir acceso a la cuenta</li>
                <li>Modificar el cliente web</li>
            </ul>
        </section>

        <section id="responsabilidad" class="policy-section">
            <h2>7. Responsabilidad</h2>
            
            <h3>7.1 Limitación de Responsabilidad</h3>
            <p>No somos responsables de:</p>
            <ul>
                <li>Pérdida de datos</li>
                <li>Interrupciones del servicio</li>
                <li>Daños indirectos</li>
                <li>Uso indebido del servicio</li>
                <li>Contenido de terceros</li>
            </ul>

            <h3>7.2 Indemnización</h3>
            <p>El usuario acepta indemnizar y mantener indemne a HLS Stream Recorder por:</p>
            <ul>
                <li>Violaciones de estos términos</li>
                <li>Uso indebido del servicio</li>
                <li>Infracciones de derechos</li>
                <li>Reclamaciones de terceros</li>
            </ul>
        </section>

        <section id="terminacion" class="policy-section">
            <h2>8. Terminación</h2>
            
            <h3>8.1 Por el Usuario</h3>
            <ul>
                <li>Cancelación en cualquier momento</li>
                <li>Eliminación de datos</li>
                <li>Exportación de contenido</li>
            </ul>

            <h3>8.2 Por HLS Stream Recorder</h3>
            <p>Podemos terminar el servicio por:</p>
            <ul>
                <li>Violación de términos</li>
                <li>Actividad sospechosa</li>
                <li>Requerimiento legal</li>
                <li>Cese del servicio</li>
            </ul>
        </section>

        <section id="modificaciones" class="policy-section">
            <h2>9. Modificaciones</h2>
            <p>Nos reservamos el derecho de modificar estos términos:</p>
            <ul>
                <li>Con notificación previa</li>
                <li>Efectivo tras la publicación</li>
                <li>Uso continuado implica aceptación</li>
            </ul>

            <div class="highlight-box">
                <p>Revise periódicamente los términos para conocer las actualizaciones.</p>
            </div>
        </section>

        <section id="general" class="policy-section">
            <h2>10. Disposiciones Generales</h2>
            
            <h3>10.1 Ley Aplicable</h3>
            <p>Estos términos se rigen por las leyes de [País/Jurisdicción].</p>

            <h3>10.2 Resolución de Disputas</h3>
            <ul>
                <li>Negociación amistosa</li>
                <li>Mediación</li>
                <li>Arbitraje vinculante</li>
                <li>Jurisdicción exclusiva</li>
            </ul>

            <h3>10.3 Divisibilidad</h3>
            <p>Si alguna disposición se declara inválida, el resto permanece en vigor.</p>

            <h3>10.4 Contacto</h3>
            <p>Para consultas sobre estos términos:</p>
            <ul>
                <li>Email: info@cellcomweb.com.ar</li>
                <li>Teléfono: +543482549555</li>
                <li>Dirección: Calle 9 Nro 539</li>
                <li>Ciudad: Avellaneda</li>
                <li>Provincia: Santa Fe</li>
                <li>Pais: Argentina</li>
            </ul>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>