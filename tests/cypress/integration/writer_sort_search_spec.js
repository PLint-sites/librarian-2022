
describe('Writer sorting', () => {
    // ONCE refresh the database
    before(() => {
        cy.refreshDatabase().seed('HardcodedWriters')
    })

    beforeEach(() => {
        cy.login({name: 'Pim'})
        cy.visit('/writers')
    })

    it('can sort', () => {
        cy.get('#buttons-and-search > button.icon-button:nth-child(2)').click()
        cy.get('.writer:nth-child(1)').should('contain', 'Albert Kees')

        cy.get('#buttons-and-search > button.icon-button:nth-child(3)').click()
        cy.get('.writer:nth-child(1)').should('contain', 'Zieder')

        cy.get('#buttons-and-search > button.icon-button:nth-child(4)').click()
        cy.get('.writer:nth-child(1)').should('contain', 'Barry')
    })

    it('can search', () => {
        cy.get('.writer').should('have.length', 5)
        cy.get('#search-container input').type('Barry')
        cy.get('.writer').should('have.length', 1)

        cy.get('#search-container button').click()
        cy.get('.writer').should('have.length', 5)
    })
})