export function enableDynamicLoading(containerSelector = 'body', mainSelector = '#main-content') {
    const container = document.querySelector(containerSelector);
    const main = document.querySelector(mainSelector);

    container.addEventListener('click', async (e) => {
        const el = e.target.closest('a, [data-url]');
        console.log("Elemento clicado:", el);
        if (!el) return; // No es un enlace ni tiene data-url

        const url = el.dataset.url || el.getAttribute('href');
        if (!url || url === '#' || url.startsWith('javascript:')) return;

        e.preventDefault();

        // Fade-out
        main.classList.remove('show');

        setTimeout(async () => {
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok){
                    if (response.status === 401) {
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error(`Error al cargar la vista (${response.status})`);
                }
                const html = await response.text();
                main.innerHTML = html;
                if (typeof initFullCalendar === 'function') initFullCalendar();
                // 🔹 Si existen inicializadores específicos, se ejecutan
                if (typeof window.initUsuarios === 'function') initUsuarios();
                if (typeof window.initMenus === 'function') initMenus();

            } catch (error) {
                console.error(error);
                main.innerHTML = `
                    <div class="p-6 text-center text-red-600">
                        <h2 class="text-xl font-semibold">
                            Error al cargar el recurso
                        </h2>
                        <p class="text-sm">${error.message}</p>
                    </div>
                `;
            }

            // Reflow + Fade-in
            void main.offsetWidth;
            main.classList.add('show');
        }, 400);
    });
}



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

                    if (!response.ok) throw new Error("fdsfdsdfsdfsdfsdfsdfsdf vista");

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
