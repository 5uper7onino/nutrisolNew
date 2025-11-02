export function initAjaxForms(){
    document.addEventListener("submit", async (e) => {
        if (!e.target.matches("form.ajax-form")) return;

        e.preventDefault();
        const form = e.target;
        const url = form.action;
        const formData = new FormData(form);

        try {
            const response = await fetch(url, {
                method: form.method || "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                redirect: "manual"
            });

            // Laravel devuelve 302 si hace redirect
            if (response.status === 302) {
                alert("La sesión ha expirado o Laravel redirigió. Intenta de nuevo.");
                return;
            }

            if (!response.ok) throw new Error("Error al guardar el usuario");

            // 🔹 Si devuelve JSON (creación/edición exitosa)
            const data = await response.json();
            alert(data.message || "Operación exitosa");

            // 🔹 Recarga la lista de usuarios
            const usuariosLink = document.querySelector('nav a[data-url$="usuarios"]');
            if (usuariosLink) usuariosLink.click();

        } catch (error) {
            alert("Error de red o servidor: " + error.message);
        }
    });
}

export function initUsuarios() {
    document.querySelectorAll('.btn-nuevo-usuario').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            alert('Nuevo usuario');
        });
    });

    document.querySelectorAll('.btn-editar-usuario').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = btn.dataset.id;
            alert('Editar usuario ID ' + id);
        });
    });
}