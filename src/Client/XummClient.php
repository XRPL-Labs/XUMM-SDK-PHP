<?php

namespace Xrpl\XummSdkPhp\Client;

use Xrpl\XummSdkPhp\Response\XummResponse;
use Xrpl\XummSdkPhp\ValueObject\Http\Request;
use Xrpl\XummSdkPhp\ValueObject\Http\UriParams;

interface XummClient
{
    public function get(Request $request, ?UriParams $uriParams = null): XummResponse;

    public function post(Request $request, string $jsonBody, ?UriParams $uriParams = null): XummResponse;

    public function delete(Request $request, UriParams $uriParams): XummResponse;
}
