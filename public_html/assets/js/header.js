function createHeader(navItems) {
    const configUrl = "../configuracion/config/configurations.json";
    fetch(configUrl)
        .then((response) => response.json())
        .then((data) => {
            const logoPath = data.logo; // Ruta del logotipo

            // Crear la estructura del navbar
            const navbar = document.createElement("nav");
            navbar.className = "navbar navbar-expand-lg navbar-light bg-primary-custom";

            const container = document.createElement("div");
            container.className = "container-fluid"; // Usar container-fluid para adaptabilidad

            // Elemento de marca con logotipo y nombre del sitio
            const brand = document.createElement("a");
            brand.className = "navbar-brand";
            brand.href = "../../index.php";

            // Agregar el logotipo
            if (logoPath) {
                const logo = document.createElement("img");
                logo.src = logoPath;
                logo.alt = "Logotipo";
                logo.style.maxHeight = "40px"; // Tamaño ajustado para el logotipo
                logo.style.borderRadius = "50%"; // Forma redonda para un toque amigable
                brand.appendChild(logo);
            }

            // Texto del nombre del sitio
            const siteName = document.createElement("span");
            siteName.textContent = "Consultorio Pediátrico";
            siteName.style.marginLeft = "10px"; // Espacio entre logotipo y texto
            siteName.style.color = "#ffffff"; // Color blanco para el texto
            siteName.style.fontWeight = "bold"; // Fuente en negrita
            brand.appendChild(siteName);

            container.appendChild(brand);

            // Botón de colapso para dispositivos móviles
            const toggle = document.createElement("button");
            toggle.className = "navbar-toggler";
            toggle.setAttribute("type", "button");
            toggle.setAttribute("data-bs-toggle", "collapse");
            toggle.setAttribute("data-bs-target", "#navbarNav");
            toggle.setAttribute("aria-controls", "navbarNav");
            toggle.setAttribute("aria-expanded", "false");
            toggle.setAttribute("aria-label", "Toggle navigation");
            toggle.innerHTML = '<span class="navbar-toggler-icon"></span>'; // Icono del botón

            container.appendChild(toggle);

            // Sección de elementos de navegación
            const collapse = document.createElement("div");
            collapse.className = "collapse navbar-collapse";
            collapse.id = "navbarNav";

            const navList = document.createElement("ul");
            navList.className = "navbar-nav ms-auto"; // Alineación a la derecha para elementos de navegación
            navList.style.fontSize = "16px"; // Tamaño de fuente ligeramente mayor para mejor legibilidad

            navItems.forEach((item) => {
                const navItem = document.createElement("li");
                navItem.className = "nav-item";

                const link = document.createElement("a");
                link.className = "nav-link"; // Clase para enlaces de navegación
                link.href = item.uri;
                link.textContent = item.name;

                navItem.appendChild(link);
                navList.appendChild(navItem);
            });

            collapse.appendChild(navList); // Añadir la lista de navegación al collapse

            container.appendChild(collapse); // Añadir el collapse al container

            navbar.appendChild(container); // Añadir el container al navbar

            // Inyectar el header en el DOM
            document.body.prepend(navbar); // Agregar al inicio del cuerpo
        })
        .catch((error) => {
            console.error("Error al cargar la configuración:", error);
        });
}

document.addEventListener("DOMContentLoaded", function() {
    // Ruta del archivo JSON
    const configUrl = "../../configuracion/config/configurations.json";

    // Cargar el archivo JSON para obtener el favicon
    fetch(configUrl)
        .then((response) => response.json())
        .then((data) => {
            if (data.logo) {
                // Obtener la ruta del favicon desde el JSON
                const faviconUrl = data.logo;

                // Configurar el favicon en la sección <head>
                let favicon = document.querySelector("link[rel='icon']");

                if (!favicon) {
                    // Si no existe, crear uno
                    favicon = document.createElement("link");
                    favicon.rel = "icon";
                    favicon.type = "image/x-icon"; // Cambia según el tipo de archivo
                    document.querySelector("head").appendChild(favicon);
                }

                // Establecer la ruta del favicon
                favicon.href = faviconUrl;
            }
        })
        .catch((error) => {
            console.error("Error al cargar el configurations.json:", error);
        });
});
