describe('Writer tests', () => {
    // ONCE refresh the database
    before(() => {
        cy.refreshDatabase().seed('UserWithBooksSeeder')
    })

    beforeEach(() => {
        cy.login({name: 'Pim'})
        cy.visit('/writers')
    })

    it('writer with books has no delete button', () => {
        cy.get('.writer:nth-child(1) .buttons button.icon-button').should('have.length', 1)
    })

    it('can add a new writer', () => {
        // Open modal to add writer
        cy.get('#buttons-and-search .icon-button:first').click()

        // Enter writer name and hit add button (note we make a typo)
        cy.get('#writer_name').type('Stephem King')
        cy.contains('button', 'Add').click()

        cy.get('.writer').should('have.length', 6)
    })

    it('can edit a writer', () => {
        cy.get('.writer:nth-child(1) .buttons button.icon-button:nth-child(2)').click()
        cy.get('#writer_name').clear().type('Stephen King')
        cy.contains('button', 'Update').click()
    })

    it('can delete a writer', () => {
        cy.get('.writer:nth-child(1) .buttons button.icon-button:nth-child(1)').click()
        cy.contains('button', 'Delete').click()
        cy.get('.writer').should('have.length', 5)
    })
})
