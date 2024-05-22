// @ts-check
/* eslint-env mocha */
describe('todos API', () => {

  it('loads the initial items', () => {
    getItems()
      .should('deep.eq', initialItems)
  })

})
