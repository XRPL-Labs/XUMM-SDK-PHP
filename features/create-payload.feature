@payload
Feature: Create a payload
  Background:
    Given I have provided valid credentials

  Scenario: create a valid payload
    Given I create some payload options:
    |submit|multisign|expire|returnUrl           |
    |1    |0         |1     |https://example.corg|
    And I add some custom meta data:
    |identifier                          |instruction   |blob          |
    |a6da5dc1-9fc2-4739-960c-5c2ce928ad4e|Please pay me?| {"foo":"bar"}|
    When I create a payload with body:
    |TransactionType|
    |SignIn         |
    Then I will receive "a created payload"

  Scenario: create an invalid payload
    When I create a payload with body:
    |TransactionFoo |
    |hi             |
    Then an error of type "badRequest" will occur