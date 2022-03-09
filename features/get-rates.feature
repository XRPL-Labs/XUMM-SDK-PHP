Feature: Get rates for a given currency code
  Background:
    Given I have provided valid credentials

  Scenario: Fetch rates for BTC
    When I call "getRates" on the Xumm SDK with parameters "BTC"
    Then I will receive "rates"

  Scenario: Fail to fetch rates for non-existent currency
    When I call "getRates" on the Xumm SDK with parameters "🥦"
    Then an error of type "badRequest" will occur