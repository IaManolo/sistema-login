document.addEventListener('DOMContentLoaded', () => {
    const claveInput = document.getElementById('clave');
    const feedback = document.getElementById('passwordFeedback');
    const correoInput = document.getElementById('correo');
    const correoFeedback = document.getElementById('correoFeedback');
    const imagenInput = document.getElementById('imagen');
    const preview = document.getElementById('preview');
    const submitBtn = document.querySelector('button[type="submit"]');

    // Validación de contraseña segura
   claveInput.addEventListener('input', () => {
    const clave = claveInput.value;

    document.getElementById('req-length').textContent = clave.length >= 8 ? "✅ Mínimo 8 caracteres" : "❌ Mínimo 8 caracteres";
    document.getElementById('req-length').style.color = clave.length >= 8 ? "green" : "red";

    const hasUpper = /[A-Z]/.test(clave);
    document.getElementById('req-uppercase').textContent = hasUpper ? "✅ Al menos una mayúscula" : "❌ Al menos una mayúscula";
    document.getElementById('req-uppercase').style.color = hasUpper ? "green" : "red";

    const hasNumber = /\d/.test(clave);
    document.getElementById('req-number').textContent = hasNumber ? "✅ Al menos un número" : "❌ Al menos un número";
    document.getElementById('req-number').style.color = hasNumber ? "green" : "red";

    const hasSymbol = /[\W_]/.test(clave);
    document.getElementById('req-symbol').textContent = hasSymbol ? "✅ Al menos un símbolo" : "❌ Al menos un símbolo";
    document.getElementById('req-symbol').style.color = hasSymbol ? "green" : "red";
});


    // Verificación de correo por AJAX
    correoInput.addEventListener('blur', () => {
        const correo = correoInput.value;
        if (!correo) return;

        fetch('../controllers/check_email.php?correo=' + encodeURIComponent(correo))
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    correoFeedback.textContent = "⚠️ El correo ya está registrado";
                    correoFeedback.style.color = "red";
                    correoInput.classList.add('error');
                    submitBtn.disabled = true;
                } else {
                    correoFeedback.textContent = "✔️ Correo disponible";
                    correoFeedback.style.color = "green";
                    correoInput.classList.remove('error');
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                correoFeedback.textContent = "❌ Error al verificar el correo";
                correoFeedback.style.color = "red";
                correoInput.classList.add('error');
                submitBtn.disabled = true;
            });
    });

    // Vista previa de imagen subida
    imagenInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            preview.src = reader.result;
        };
        reader.readAsDataURL(file);
    });
});
