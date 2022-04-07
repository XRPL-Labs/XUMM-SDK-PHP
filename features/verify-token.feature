@verify
Feature:
  Background:
    Given I have provided valid credentials

  Scenario: verify a single token
    When I verify token "691d5ae8-968b-44c8-8835-f25da1214f35"
    Then I will receive "a token validity record"

  Scenario: verify a single token that doesn't exist
    When I verify token "foo"
    Then the result will be null

  Scenario: verify multiple tokens
    When I verify tokens "691d5ae8-968b-44c8-8835-f25da1214f35,foo,b12b59a8-83c8-4bc0-8acb-1d1d743871f1"
    Then I will receive "a token validity record list"
    And it will have "2" token records
