@subscribe
Feature: Subscribe to a payload
  Background:
    Given I have created a payload

  Scenario: Start/end a subscription with a callback
    When I subscribe to that payload
    And I receive a message '{"boop": false}'
    And I receive a message '{"signed": true}'
    Then my callback result should be returned
    And the subscription will have ended
