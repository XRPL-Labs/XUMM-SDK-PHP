<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Xrpl\XummSdkPhp\Exception\Http\BadRequestException;
use Xrpl\XummSdkPhp\Exception\Http\NotFoundException;
use Xrpl\XummSdkPhp\Exception\Http\UnauthorizedException;
use Xrpl\XummSdkPhp\Exception\Payload\PayloadCancellationException;
use Xrpl\XummSdkPhp\Payload\CustomMeta;
use Xrpl\XummSdkPhp\Payload\Options;
use Xrpl\XummSdkPhp\Payload\Payload;
use Xrpl\XummSdkPhp\Payload\ReturnUrl;
use Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload;
use Xrpl\XummSdkPhp\Response\CuratedAssets\CuratedAssets;
use Xrpl\XummSdkPhp\Response\GetKycStatus\KycStatus;
use Xrpl\XummSdkPhp\Response\GetPayload\XummPayload;
use Xrpl\XummSdkPhp\Response\Rates\Rates;
use Xrpl\XummSdkPhp\Response\Transaction\XrplTransaction;
use Xrpl\XummSdkPhp\Response\VerifyUserTokens\UserTokenValidityRecord;
use Xrpl\XummSdkPhp\Response\VerifyUserTokens\UserTokenValidityRecordList;
use Xrpl\XummSdkPhp\XummSdk;
use Xrpl\XummSdkPhp\Response\XummResponse;
use \PHPUnit\Framework as Assert;
use Xrpl\XummSdkPhp\Exception\Http\XummBadResponseException;
use Xrpl\XummSdkPhp\Response\Pong\Pong;

/**
 * Defines application features from the specific context.
 */
final class FeatureContext implements Context
{
    private XummSdk $sdk;
    private ?XummResponse $result = null;
    private ?Throwable $exception = null;

    /**
     * Payload data
     */
    private ?Options $options = null;
    private ?CustomMeta $customMeta = null;

    /**
     * @Given I have provided valid credentials
     */
    public function validCredentials(): void {
        $this->sdk = new XummSdk(
            'aaaaaaaa-bbbb-cccc-dddd-1234567890ab',
            'cbbbbbbb-aaaa-cccc-dddd-1234567890ab'
        );
    }

    /**
     * @Given I have provided invalid credentials
     */
    public function invalidCredentials(): void {
        $this->sdk = new XummSdk('bogus', 'credentials');
    }

    /**
     * @When I call :method on the Xumm SDK
     */
    public function callSdk(string $method): void {
        try {
            $this->result = $this->sdk->{$method}();
        } catch (Throwable $e) {
            $this->exception = $e;
        }
    }

    /**
     * @When I call :method on the Xumm SDK with parameters :params
     */
    public function callSdkWithParams(string $method, ...$parameters): void {
        try {
            $this->result = $this->sdk->{$method}(...$parameters);
        } catch (Throwable $e) {
            $this->exception = $e;
        }
    }

    /**
     * @When /I create some payload options:/
     */
    public function createPayloadOptions(TableNode $tableNode): void
    {
        $hash = $tableNode->getHash();
        $data = array_shift($hash);

        $this->options = new Options(
            isset($data['submit']) ? (bool)$data['submit'] : null,
            isset($data['multisign']) ? (bool)$data['multisign'] : null,
            isset($data['expire']) ? (bool)$data['expire'] : null,
            isset($data['immutable']) ? (bool)$data['immutable'] : null,
            isset($data['forceAccount']) ? (bool)$data['forceAccount'] : null,
            $data['returnUrl'] ? new ReturnUrl(null, $data['returnUrl']) : null,
        );
    }

    /**
     * @Given /I add some custom meta data:/
     */
    public function addCustomMetaData(TableNode $tableNode)
    {
        $hash = $tableNode->getHash();
        $data = array_shift($hash);

        $this->customMeta = new CustomMeta(
            identifier: $data['identifier'] ?? null,
            instruction: $data['instruction'] ?? null,
            blob: $data['blob'] ? json_decode($data['blob'], true) : null,
        );
    }

    /**
     * @When I verify token :token
     */
    public function verifyToken(string $token): void
    {
        $this->result = $this->sdk->verifyUserToken($token);
    }

    /**
     * @When I verify tokens :tokens
     */
    public function verifyTokens(string $tokens): void
    {
        $tokens = explode(',', $tokens);
        $this->result = $this->sdk->verifyUserTokens(...$tokens);
    }

    /**
     * @Then it will have :count token records
     */
    public function willHaveTokenRecords(int $count): void
    {
        if (!$this->result instanceof UserTokenValidityRecordList) {
            throw new Exception('This step assumes a token validity record list was received.');
        }
        Assert\assertCount($count, $this->result->tokens);
    }

    /**
     * @When /I create a payload with body:/
     */
    public function createPayload(TableNode $tableNode): void
    {
        $data = $tableNode->getHash();

        $this->callSdkWithParams(
            'createPayload',
            new Payload(
                transactionBody: array_shift($data),
                options: $this->options,
                customMeta: $this->customMeta
            )
        );
    }

    /**
     * @Then I will receive :object
     */
    public function theyWillReceive(string $object): void
    {
        Assert\assertNull($this->exception);

        $expectedResult = match ($object) {
            'a created payload' => CreatedPayload::class,
            'a KYC status' => KycStatus::class,
            'a payload' => XummPayload::class,
            'an xlrp transaction' => XrplTransaction::class,
            'a token validity record' => UserTokenValidityRecord::class,
            'a token validity record list' => UserTokenValidityRecordList::class,
            'curated assets' => CuratedAssets::class,
            'pong' => Pong::class,
            'rates' => Rates::class,
        };

        Assert\assertInstanceOf($expectedResult, $this->result);
    }

    /**
     * @Then the result will be null
     */
    public function theResultWillBeNull(): void
    {
        Assert\assertNull($this->result);
    }

    /**
     * @Then an error of type ":error" will occur
     */
    public function responseException(string $error): void {
        Assert\assertNull($this->result);
        Assert\assertInstanceOf(XummBadResponseException::class, $this->exception);

        $expectedException = match ($error) {
            'payloadCancellation' => PayloadCancellationException::class,
            'badRequest' => BadRequestException::class,
            'notFound' => NotFoundException::class,
            'unauthorized' => UnauthorizedException::class,
        };

        Assert\assertInstanceOf($expectedException, $this->exception);
    }

    /**
     * @When I cancel the payload
     */
    public function cancelPayload(): void
    {
        $payload = $this->ensureCreatedPayload();

        try {
            $this->sdk->cancel($payload);
        } catch (Exception $e) {
            $this->result = null;
            $this->exception = $e;
        }
    }

    /**
     * @Then the payload will be cancelled
     */
    public function assertPayloadCanceled(): void
    {
        // TODO: assert this somehow D:
    }

    private function ensureCreatedPayload(): CreatedPayload
    {
        if (!$this->result instanceof CreatedPayload) {
            throw new \Exception('This step assumes a created payload');
        }

        return $this->result;
    }
}
