### Clonar un Repositorio

```bash
git clone https://github.com/AlvaroCastro1/Consultorio.git
```

### Creación de Ramas

```bash
# Crea una nueva rama y colocarse en ella
git checkout -b nombre_de_la_rama
```

### Hacer Cambios y Commit
Una vez que hagas cambios en el código

```bash
# Muestra el estado del repositorio
git status

# Añade archivos al ecenario para despues subir
git add nombre_del_archivo

# O para añadir todos los cambios
git add .

# Haz un commit con un mensaje descriptivo
git commit -m "Descripción del cambio"
```

### Publicar Cambios en el Repositorio Remoto
Para compartir tus cambios con el repositorio remoto, debes hacer un push:

```bash
# Publicar rama en el repositorio
git push origin nombre_de_la_rama
```

### Crear Pull Requests (PR)
Un pull request es una solicitud para fusionar una rama en otra.
estos son los pasos:

1. **Sube tu rama** al repositorio remoto.
2. **Abre la página del repositorio** en la plataforma de GitHub
3. **Encuentra tu rama** selecciona "Crear Pull Request"
4. **Proporciona un título y una descripción** del pull request.
5. **Selecciona la rama de destino** (siempre es `develop`).
6. **Envía el pull request** para revisión (añade a tu jefe de area).

### Fusionar Ramas
Una vez que un pull request ha sido revisado y aprobado, puedes fusionarlo con la rama de destino.


### Buenas Prácticas
- **Commits pequeños y descriptivos**: Intenta hacer commits pequeños y agrega un mensaje que describa el cambio.
- **Usa ramas para cada función o corrección de errores**: Esto te permite trabajar sin afectar el código principal.
- **Realiza pull requests para revisión**: Antes de fusionar, es útil tener la revisión de otro desarrollador.
- **Actualiza tu rama con frecuencia**: Mantén tu rama sincronizada con el último código del repositorio remoto.