Feature: Viewing the shop homepage
    As a visitor
    I want to view the shop homepage
    So that I can browse products

    @shop_homepage
    @javascript
    Scenario: Viewing the shop homepage
        When I view the shop homepage
        Then the shop homepage should be displayed
