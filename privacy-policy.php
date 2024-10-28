<?php
// privacy-policy.php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - HLS Stream Recorder</title>
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
        <h1>Política de Privacidad</h1>

        <div class="last-updated">
            Última actualización: <?php echo date('d/m/Y'); ?>
        </div>

        <div class="toc policy-section">
            <h2>Contenido</h2>
            <ul>
                <li><a href="#introduccion">1. Introducción</a></li>
                <li><a href="#recopilacion">2. Información que Recopilamos</a></li>
                <li><a href="#uso">3. Uso de la Información</a></li>
                <li><a href="#almacenamiento">4. Almacenamiento y Seguridad</a></li>
                <li><a href="#derechos">5. Derechos del Usuario</a></li>
                <li><a href="#cookies">6. Uso de Cookies</a></li>
                <li><a href="#compartir">7. Compartir Información</a></li>
                <li><a href="#menores">8. Menores de Edad</a></li>
                <li><a href="#cambios">9. Cambios en la Política</a></li>
                <li><a href="#contacto">10. Contacto</a></li>
            </ul>
        </div>

        <section id="introduccion" class="policy-section">
            <h2>1. Introducción</h2>
            <p>Esta Política de Privacidad describe cómo HLS Stream Recorder ("nosotros", "nuestro" o "la aplicación") recopila, usa y protege la información personal que usted proporciona al utilizar nuestra aplicación.</p>
            
            <div class="highlight-box">
                <p><strong>Importante:</strong> Al utilizar nuestra aplicación, usted acepta las prácticas descritas en esta política.</p>
            </div>
        </section>

        <section id="recopilacion" class="policy-section">
            <h2>2. Información que Recopilamos</h2>
            
            <h3>2.1 Información proporcionada directamente</h3>
            <ul>
                <li>URLs de streams</li>
                <li>Información de sesión</li>
                <li>Grabaciones realizadas</li>
                <li>Configuraciones personalizadas</li>
            </ul>

            <h3>2.2 Información recopilada automáticamente</h3>
            <ul>
                <li>Dirección IP</li>
                <li>Tipo de navegador</li>
                <li>Sistema operativo</li>
                <li>Estadísticas de uso</li>
                <li>Registros de errores</li>
            </ul>

            <table>
                <tr>
                    <th>Tipo de Dato</th>
                    <th>Propósito</th>
                    <th>Retención</th>
                </tr>
                <tr>
                    <td>URLs de streams</td>
                    <td>Reproducción y grabación</td>
                    <td>30 días</td>
                </tr>
                <tr>
                    <td>Grabaciones</td>
                    <td>Almacenamiento de contenido</td>
                    <td>30 días</td>
                </tr>
                <tr>
                    <td>Logs de acceso</td>
                    <td>Seguridad y diagnóstico</td>
                    <td>7 días</td>
                </tr>
            </table>
        </section>

        <section id="uso" class="policy-section">
            <h2>3. Uso de la Información</h2>
            <p>Utilizamos la información recopilada para:</p>
            
            <ul>
                <li>Proporcionar y mantener el servicio</li>
                <li>Mejorar la experiencia del usuario</li>
                <li>Analizar el rendimiento del sistema</li>
                <li>Prevenir usos indebidos</li>
                <li>Cumplir con obligaciones legales</li>
            </ul>

            <div class="warning-box">
                <p><strong>Aviso:</strong> No utilizamos la información personal para fines publicitarios ni la compartimos con terceros con fines comerciales.</p>
            </div>
        </section>

        <section id="almacenamiento" class="policy-section">
            <h2>4. Almacenamiento y Seguridad</h2>
            
            <h3>4.1 Medidas de Seguridad</h3>
            <ul>
                <li>Encriptación de datos en tránsito y en reposo</li>
                <li>Acceso restringido a servidores</li>
                <li>Monitoreo continuo de seguridad</li>
                <li>Respaldos regulares</li>
                <li>Protocolos de seguridad actualizados</li>
            </ul>

            <h3>4.2 Ubicación del Almacenamiento</h3>
            <p>Los datos se almacenan en servidores seguros ubicados en [País/Región], cumpliendo con las regulaciones locales de protección de datos.</p>
        </section>

        <section id="derechos" class="policy-section">
            <h2>5. Derechos del Usuario</h2>
            <p>Usted tiene derecho a:</p>
            
            <ul>
                <li>Acceder a sus datos personales</li>
                <li>Rectificar datos incorrectos</li>
                <li>Eliminar sus datos</li>
                <li>Limitar el procesamiento</li>
                <li>Portabilidad de datos</li>
                <li>Oponerse al procesamiento</li>
            </ul>

            <div class="highlight-box">
                <p>Para ejercer estos derechos, contacte con nosotros a través de info@cellcomweb.com.ar.</p>
            </div>
        </section>

        <section id="cookies" class="policy-section">
            <h2>6. Uso de Cookies</h2>
            
            <h3>6.1 Tipos de Cookies</h3>
            <table>
                <tr>
                    <th>Tipo</th>
                    <th>Propósito</th>
                    <th>Duración</th>
                </tr>
                <tr>
                    <td>Esenciales</td>
                    <td>Funcionamiento básico</td>
                    <td>Sesión</td>
                </tr>
                <tr>
                    <td>Preferencias</td>
                    <td>Configuración de usuario</td>
                    <td>1 año</td>
                </tr>
                <tr>
                    <td>Estadísticas</td>
                    <td>Análisis de uso</td>
                    <td>30 días</td>
                </tr>
            </table>
        </section>

        <section id="compartir" class="policy-section">
            <h2>7. Compartir Información</h2>
            <p>No compartimos información personal excepto:</p>
            
            <ul>
                <li>Por requerimiento legal</li>
                <li>Para proteger derechos legales</li>
                <li>Con proveedores de servicios esenciales</li>
            </ul>
        </section>

        <section id="menores" class="policy-section">
            <h2>8. Menores de Edad</h2>
            <p>No recopilamos intencionalmente información de menores de 16 años. Si detectamos información de menores, la eliminaremos inmediatamente.</p>
        </section>

        <section id="cambios" class="policy-section">
            <h2>9. Cambios en la Política</h2>
            <p>Nos reservamos el derecho de modificar esta política. Los cambios serán notificados a través de la aplicación.</p>
        </section>

        <section id="contacto" class="policy-section">
            <h2>10. Contacto</h2>
            <p>Para cualquier consulta sobre esta política:</p>
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