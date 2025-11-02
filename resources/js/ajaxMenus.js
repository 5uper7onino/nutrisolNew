export function initAjaxMenus(){
    const main = document.getElementById("main-content");
    const menuLinks = document.querySelectorAll("nav a[data-url]");

    // 🔹 Fade-in inicial
    requestAnimationFrame(() => main.classList.add("show"));

    // 🔹 Cargar contenido por AJAX al hacer clic en los menús
    menuLinks.forEach(link => {
        link.addEventListener("click", async (e) => {
            e.preventDefault();
            const url = link.dataset.url;
            const name = link.textContent.trim();

            // No hace nada si no hay URL o es "#"
            if (!url || url === "#") return;

            // Fade-out
            main.classList.remove("show");

            setTimeout(async () => {
                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    if (!response.ok) throw new Error("Error al cargar la vista");

                    const html = await response.text();
                    main.innerHTML = html;

                    // Inicializa lógica específica del módulo
                    if (typeof initUsuarios === "function") initUsuarios();

                } catch (error) {
                    main.innerHTML = `
                        <div class="p-6 text-center text-red-600">
                            <h2 class="text-xl font-semibold">Error al cargar <span class="text-gray-700">${name}</span></h2>
                            <p class="text-sm">${error.message}</p>
                        </div>
                    `;
                }

                // Forzar reflow y aplicar fade-in
                void main.offsetWidth;
                main.classList.add("show");
            }, 400); // igual al tiempo del CSS
        });
    });
}