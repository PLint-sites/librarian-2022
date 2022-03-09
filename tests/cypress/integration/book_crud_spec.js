describe('Book tests', () => {
    // ONCE refresh the database
    before(() => {
        cy.refreshDatabase().seed('UserWithBooksSeeder')
    })

    beforeEach(() => {
        cy.login({name: 'Pim'})
        cy.visit('/books')
    })

    it('can add a new book', () => {
        // Open modal to add writer
        cy.get('.button-and-search .icon-button:first').click()

        // Enter writer name and hit add button (note we make a typo)
        cy.get('#book_title').type('Ik mis je')
        cy.get('#book_writer').select(1)
        cy.get('#book_genre').select(2)
        cy.contains('button', 'Add').click()

        cy.get('.book').should('contain', 'Ik mis je')

        cy.get('#page-title').should('contain', '201')
    })

    it('can edit a book', () => {
        cy.get('.book:nth-child(1) .title button.icon-button:last').click()
        cy.get('#book_title').clear().type('Ik wil je')
        cy.contains('button', 'Update').click()

        cy.get('.book').should('contain', 'Ik wil je')
    })

    it('can search a book', () => {
        cy.get('.button-and-search input[type="text"]').type('wil je')

        cy.get('.book').should('have.length', 1)
    })

    it('can delete a book', () => {
        cy.get('.book:nth-child(1) .title button.icon-button:first').click()
        cy.contains('button', 'Delete').click()

        cy.get('#page-title').should('contain', '200')
    })

})