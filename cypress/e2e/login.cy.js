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

  })
})