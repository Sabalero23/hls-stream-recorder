<footer style="background: white; padding: 20px 0; margin-top: auto; box-shadow: 0 -2px 4px rgba(0,0,0,0.1);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div>
                <h3 style="color: var(--primary-color); margin-bottom: 10px;">HLS Stream Recorder</h3>
                <p style="color: #666;">&copy; <?php echo date('Y'); ?> Todos los derechos reservados</p>
            </div>
            
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Enlaces Útiles</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="tutorial.php" style="color: #666; text-decoration: none;">Tutorial</a></li>
                    <li><a href="privacy-policy.php" onclick="showPrivacyPolicy()" style="color: #666; text-decoration: none;">Política de Privacidad</a></li>
                    <li><a href="terms.php" onclick="showTerms()" style="color: #666; text-decoration: none;">Términos de Uso</a></li>
                </ul>
            </div>
            
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Información Técnica</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="color: #666;">Versión: 1.0.0</li>
                    <li style="color: #666;">HLS.js: 1.4.12</li>
                    <li style="color: #666;">PHP: <?php echo phpversion(); ?></li>
                </ul>
            </div>
            
            <div>
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Soporte</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="mailto:info@cellcomweb.com.ar" style="color: #666; text-decoration: none;">Contacto</a></li>
                    <li><a href="faq.php" onclick="showFAQ()" style="color: #666; text-decoration:none;">FAQ</a></li>
                    <li><a href="https://github.com/sabalero23/hls-stream-recorder" style="color: #666; text-decoration: none;">GitHub</a></li>
                </ul>
            </div>
        </div>
        
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #666;">
            <p>Desarrollado con <i class="fas fa-heart" style="color: #ff4444;"></i> por Sabalero23</p>
            <p style="font-size: 0.9em; margin-top: 5px;">
                Usando: HLS.js, PHP <?php echo phpversion(); ?>, MySQL <?php echo mysqli_get_client_info(); ?>
            </p>
        </div>
    </div>

    <!-- Modal para Política de Privacidad -->
    <div id="privacyModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000;">
        <div style="background: white; max-width: 600px; margin: 50px auto; padding: 20px; border-radius: 10px; max-height: 80vh; overflow-y: auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Política de Privacidad</h2>
            <div style="color: #666; line-height: 1.6;">
                <p>Esta política de privacidad describe cómo se recopila y utiliza la información en HLS Stream Recorder.</p>
                <!-- Agregar más contenido de política de privacidad -->
            </div>
            <button onclick="closeModal('privacyModal')" style="background: var(--primary-color); color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                Cerrar
            </button>
        </div>
    </div>

    <!-- Modal para Términos de Uso -->
    <div id="termsModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000;">
        <div style="background: white; max-width: 600px; margin: 50px auto; padding: 20px; border-radius: 10px; max-height: 80vh; overflow-y: auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Términos de Uso</h2>
            <div style="color: #666; line-height: 1.6;">
                <p>Al utilizar HLS Stream Recorder, aceptas los siguientes términos y condiciones...</p>
                <!-- Agregar más contenido de términos de uso -->
            </div>
            <button onclick="closeModal('termsModal')" style="background: var(--primary-color); color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                Cerrar
            </button>
        </div>
    </div>

    <!-- Modal para FAQ -->
    <div id="faqModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000;">
        <div style="background: white; max-width: 600px; margin: 50px auto; padding: 20px; border-radius: 10px; max-height: 80vh; overflow-y: auto;">
            <h2 style="color: var(--primary-color); margin-bottom: 20px;">Preguntas Frecuentes</h2>
            <div style="color: #666; line-height: 1.6;">
                <h3>¿Qué es un stream HLS?</h3>
                <p>HLS (HTTP Live Streaming) es un protocolo de streaming adaptativo...</p>
                
                <h3>¿Cuánto espacio tengo disponible?</h3>
                <p>Cada usuario dispone de 10GB de almacenamiento...</p>
                
                <h3>¿Qué formatos puedo grabar?</h3>
                <p>El sistema graba en formato WebM con códecs VP8 y Opus...</p>
                
                <!-- Agregar más preguntas frecuentes -->
            </div>
            <button onclick="closeModal('faqModal')" style="background: var(--primary-color); color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 20px; cursor: pointer;">
                Cerrar
            </button>
        </div>
    </div>

    <script>
        function showPrivacyPolicy() {
            document.getElementById('privacyModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function showTerms() {
            document.getElementById('termsModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function showFAQ() {
            document.getElementById('faqModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Cerrar modales con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"]').forEach(modal => {
                    modal.style.display = 'none';
                });
                document.body.style.overflow = 'auto';
            }
        });

        // Cerrar modales al hacer clic fuera
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>
</footer>