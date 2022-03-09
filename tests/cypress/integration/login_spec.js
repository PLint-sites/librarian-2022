describe('Login a user with books', () => {
    // ONCE refresh the database
    before(() => {
        cy.refreshDatabase().seed('UserWithBooksSeeder')
    })

    beforeEach(() => {
        cy.intercept('POST', '/login').as('tryLogin')
        cy.visit('/').contains('a', 'Sign in').click()
    })

    it('Credentials should be valid', () => {
        cy.get('#email').type('pim@plint-sites.nl')
        cy.get('#password').type('password')
        cy.contains('button', 'Log in').click()

        cy.wait('@tryLogin')
        cy.contains('These credentials do not match our records')
    })

    it('Works with correct credentials', () => {
        cy.get('#email').type('pim@plint-sites.com')
        cy.get('#password').type('password')
        cy.contains('button', 'Log in').click()

        cy.wait('@tryLogin')

        cy.contains('Your books')
    })

    it('Already signed in should be redirected', () => {
        cy.get('#email').type('pim@plint-sites.com')
        cy.get('#password').type('password')
        cy.contains('button', 'Log in').click()

        cy.wait('@tryLogin')

        cy.visit('/login') // gets redirected to /books because already logged in

        cy.contains('Your books')
    })

    it('Infinite scroll works', () => {
        cy.get('#email').type('pim@plint-sites.com')
        cy.get('#password').type('password')
        cy.contains('button', 'Log in').click()

        // cy.wait('@tryLogin')

        // We get redirected to the booklist

        // Check that number of books pn the page is 20
        cy.get('#booklist > div').should('have.length', 20)

        // Scroll footer into view
        cy.get('footer').scrollIntoView()

        // More books are loaded => number of books should be 40 now...
        cy.get('#booklist > div').should('have.length', 40)

    })

})