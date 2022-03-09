Feature: Get curated assets
  Background:
    Given I have provided valid credentials

  Scenario: Successfully fetch curated assets
    When I call "getCuratedAssets" on the Xumm SDK
    Then I will receive "curated assets"