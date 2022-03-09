@payload
Feature: Delete a payload
  Background: 
    Given I have provided valid credentials
    And I create a payload with body:
      |TransactionType|
      |SignIn         |

    Scenario: Delete a payload
      When I cancel the payload
      Then the payload will be cancelled
