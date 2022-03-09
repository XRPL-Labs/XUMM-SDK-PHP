@kyc
Feature: Fetch a KYC status
  Background:
    Given I have provided valid credentials

    Scenario: Fetch KYC status for a user account
      When I call "getKycStatusForAccount" on the Xumm SDK with parameters "some-account-id"
      Then I will receive "a KYC status"

    Scenario: Fetch KYC status for non-existent user account
      When I call "getKycStatusForAccount" on the Xumm SDK with parameters "🥦"
      Then an error of type "notFound" will occur

    Scenario: Fetch KYC status by user token
      When I call "getKycStatusByUserToken" on the Xumm SDK with parameters "some-user-token"
      Then I will receive "a KYC status"