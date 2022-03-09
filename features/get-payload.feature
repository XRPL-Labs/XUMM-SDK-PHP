@payload
Feature: Fetch a payload
  Background: 
    Given I have provided valid credentials
  
  Scenario: fetch by payload UUID
    When I call "getPayload" on the Xumm SDK with parameters "00000000-0000-4839-af2f-f794874a80b0"
    Then I will receive "a payload"
    
  Scenario: attempt to fetch a non-existent payload
    When I call "getPayload" on the Xumm SDK with parameters "🥦"
    Then an error of type "notFound" will occur
    
  Scenario: fetch by custom UUID
    When I call "getPayloadByCustomId" on the Xumm SDK with parameters "some-id"
    Then I will receive "a payload"
