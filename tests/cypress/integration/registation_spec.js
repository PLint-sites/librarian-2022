describe('Register a user and add first book & writer', () => {
    // ONCE refresh the database
    before(() => {
        cy.refreshDatabase().seed()
    })

    it('Registers a user', () => {
        cy.visit('/register')
        
        cy.get('#name').type('Pim')
        cy.get('#email').type('pim@plint-sites.nl')
        cy.get('#password').type('password')
        cy.get('#password_confirmation').type('password')

        cy.contains('button', 'Register').click()

        // Test we are on the correct page (Welcome, Add your first book)
        cy.contains('h2', 'Welcome')
        cy.contains('p.subtitle', 'I am your personal librarian')

        // Fill out form to add first book
        cy.get('#form-container #book_title').type('Scar Tissue')
        cy.get('#form-container #writer_title').type('Anthony Kiedis')
        cy.get('#form-container #book_genre').select(3)
        cy.get('#form-container #book_owned').check()
        cy.get('#form-container #book_completed').check()

        cy.contains('button', 'Add').click()
    })
})
