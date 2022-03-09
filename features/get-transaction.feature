Feature: Get rates for a given currency code
  Background:
    Given I have provided valid credentials

  Scenario: Fetch a transaction
    When I call "getTransaction" on the Xumm SDK with parameters "A17E4DEAD62BF705D9B73B4EAD2832F1C55C6C5A0067327A45E497FD8D31C0E3"
    Then I will receive "an xlrp transaction"

  Scenario: Attempt to fetch a transaction that doesn't exist
    When I call "getTransaction" on the Xumm SDK with parameters "🥦"
    Then an error of type "notFound" will occur
