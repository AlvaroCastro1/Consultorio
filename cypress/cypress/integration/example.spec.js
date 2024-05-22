describe('Visitar Google', () => {
  it('Debería visitar la página principal de Google', () => {
    // Visitar la página principal de Google
    cy.visit('https://www.google.com/');

    // Verificar el título de la página
    cy.title().should('eq', 'Google');

  });
});