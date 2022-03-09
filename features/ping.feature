Feature: ping the Xumm API
  Scenario: Successful ping
    Given I have provided valid credentials
    When I call "ping" on the Xumm SDK
    Then I will receive "pong"

  Scenario: Unauthorized
    Given I have provided invalid credentials
    When I call "ping" on the Xumm SDK
    Then an error of type "unauthorized" will occur