Feature: Viewing the admin dashboard
    As an administrator
    I want to view the administration dashboard
    So that I can manage the store

    @admin_dashboard
    @javascript
    Scenario: Viewing the administration dashboard as a logged in administrator
        Given I am logged in as "sylius@example.com" administrator
        When I open administration dashboard
        Then I should see the administration dashboard
