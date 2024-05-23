# Pruebas de usuario final

## ¿Cómo ejecuto las pruebas localmente?

- Necesariamente necesitas tener docker instalado o en su defecto, instalar una version de cypress:
    - Cypress:        13.10.0+
    - Node:   20.13.1+
- Porsteriormente debes estar en la carpeta raiz del proyecto

```bash
docker run -it --rm -v $(pwd)/cypress:/e2e/cypress -v $(pwd)/cypress.config.js:/e2e/cypress.config.js -w /e2e cypress/included:latest run
```