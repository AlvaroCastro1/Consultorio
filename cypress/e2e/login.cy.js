describe('Pruebas para Login', () => {

  it('Inicio correcto', () => {
    // visitar la pagina
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php')
    // ingresar username y password
    cy.get('#username').type('gabito').should('have.value', 'gabito');
    cy.get('#password').type('qwe123qwe').should('have.value', 'qwe123qwe');
    //iniciar sesion desde el boton
    cy.get('#iniciar').click();
    //validar que el usuario haya iniciado sesion
    cy.contains('¡Bienvenido, gabito!').should('be.visible');
    //cerrar sesion
    cy.get('#cerrar').click();

  });

  it('Login con username válido y password inválida', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#username').type('gabito');
    cy.get('#password').type('passwordinvalida');
    cy.get('#iniciar').click();
    cy.contains('Nombre de usuario o contraseña incorrectos.').should('be.visible');
  });

  it('Login con username inválido y password válida', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#username').type('usuarioinvalido');
    cy.get('#password').type('qwe123qwe');
    cy.get('#iniciar').click();
    cy.contains('Nombre de usuario o contraseña incorrectos.').should('be.visible');
  });

  it('Login con username y password inválidos', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#username').type('usuarioinvalido');
    cy.get('#password').type('passwordinvalida');
    cy.get('#iniciar').click();
    cy.contains('Nombre de usuario o contraseña incorrectos.').should('be.visible');
  });

  it('Login con campos vacíos', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#iniciar').click();
    cy.title().should('eq', 'Login');
  });

  it('Login con solo username', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#username').type('gabito');
    cy.get('#iniciar').click();
    cy.title().should('eq', 'Login');
  });

  
  it('Login con solo password', () => {
    cy.visit('http://consultorio.cytech.com.mx/Login/login.php');
    cy.get('#password').type('qwe123qwe');
    cy.get('#iniciar').click();
    cy.title().should('eq', 'Login');
  });
})