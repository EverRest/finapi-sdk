<?php
declare(strict_types=1);

namespace App;

use Articus\DataTransfer as DT;
use OpenAPIGenerator\APIClient as OAGAC;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * finAPI Access
 * <strong>RESTful API for Account Information Services (AIS) and Payment Initiation Services (PIS)</strong>  The following pages give you some general information on how to use our APIs.<br/> The actual API services documentation then follows further below. You can use the menu to jump between API sections. <br/> <br/> This page has a built-in HTTP(S) client, so you can test the services directly from within this page, by filling in the request parameters and/or body in the respective services, and then hitting the TRY button. Note that you need to be authorized to make a successful API call. To authorize, refer to the 'Authorization' section of the API, or just use the OAUTH button that can be found near the TRY button. <br/>  <h2 id=\"general-information\">General information</h2>  <h3 id=\"general-error-responses\"><strong>Error Responses</strong></h3> When an API call returns with an error, then in general it has the structure shown in the following example:  <pre> {   \"errors\": [     {       \"message\": \"Interface 'FINTS_SERVER' is not supported for this operation.\",       \"code\": \"BAD_REQUEST\",       \"type\": \"TECHNICAL\"     }   ],   \"date\": \"2020-11-19 16:54:06.854\",   \"requestId\": \"selfgen-312042e7-df55-47e4-bffd-956a68ef37b5\",   \"endpoint\": \"POST /api/v1/bankConnections/import\",   \"authContext\": \"1/21\",   \"bank\": \"DEMO0002 - finAPI Test Redirect Bank\" } </pre>  If an API call requires an additional authentication by the user, HTTP code 510 is returned and the error response contains the additional \"multiStepAuthentication\" object, see the following example:  <pre> {   \"errors\": [     {       \"message\": \"Es ist eine zusätzliche Authentifizierung erforderlich. Bitte geben Sie folgenden Code an: 123456\",       \"code\": \"ADDITIONAL_AUTHENTICATION_REQUIRED\",       \"type\": \"BUSINESS\",       \"multiStepAuthentication\": {         \"hash\": \"678b13f4be9ed7d981a840af8131223a\",         \"status\": \"CHALLENGE_RESPONSE_REQUIRED\",         \"challengeMessage\": \"Es ist eine zusätzliche Authentifizierung erforderlich. Bitte geben Sie folgenden Code an: 123456\",         \"answerFieldLabel\": \"TAN\",         \"redirectUrl\": null,         \"redirectContext\": null,         \"redirectContextField\": null,         \"twoStepProcedures\": null,         \"photoTanMimeType\": null,         \"photoTanData\": null,         \"opticalData\": null,         \"opticalDataAsReinerSct\": false       }     }   ],   \"date\": \"2019-11-29 09:51:55.931\",   \"requestId\": \"selfgen-45059c99-1b14-4df7-9bd3-9d5f126df294\",   \"endpoint\": \"POST /api/v1/bankConnections/import\",   \"authContext\": \"1/18\",   \"bank\": \"DEMO0001 - finAPI Test Bank\" } </pre>  An exception to this error format are API authentication errors, where the following structure is returned:  <pre> {   \"error\": \"invalid_token\",   \"error_description\": \"Invalid access token: cccbce46-xxxx-xxxx-xxxx-xxxxxxxxxx\" } </pre>  <h3 id=\"general-paging\"><strong>Paging</strong></h3> API services that may potentially return a lot of data implement paging. They return a limited number of entries within a \"page\". Further entries must be fetched with subsequent calls. <br/><br/> Any API service that implements paging provides the following input parameters:<br/> &bull; \"page\": the number of the page to be retrieved (starting with 1).<br/> &bull; \"perPage\": the number of entries within a page. The default and maximum value is stated in the documentation of the respective services.  A paged response contains an additional \"paging\" object with the following structure:  <pre> {   ...   ,   \"paging\": {     \"page\": 1,     \"perPage\": 20,     \"pageCount\": 234,     \"totalCount\": 4662   } } </pre>  <h3 id=\"general-internationalization\"><strong>Internationalization</strong></h3> The finAPI services support internationalization which means you can define the language you prefer for API service responses. <br/><br/> The following languages are available: German, English, Czech, Slovak. <br/><br/> The preferred language can be defined by providing the official HTTP <strong>Accept-Language</strong> header. <br/><br/> finAPI reacts on the official iso language codes &quot;de&quot;, &quot;en&quot;, &quot;cs&quot; and &quot;sk&quot; for the named languages. Additional subtags supported by the Accept-Language header may be provided, e.g. &quot;en-US&quot;, but are ignored. <br/> If no Accept-Language header is given, German is used as the default language. <br/><br/> Exceptions:<br/> &bull; Bank login hints and login fields are only available in the language of the bank and not being translated.<br/> &bull; Direct messages from the bank systems typically returned as BUSINESS errors will not be translated.<br/> &bull; BUSINESS errors created by finAPI directly are available in German and English.<br/> &bull; TECHNICAL errors messages meant for developers are mostly in English, but also may be translated.  <h3 id=\"general-request-ids\"><strong>Request IDs</strong></h3> With any API call, you can pass a request ID via a header with name \"X-Request-Id\". The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. <br/><br/> If you don't pass a request ID for a call, finAPI will generate a random ID internally. <br/><br/> The request ID is always returned back in the response of a service, as a header with name \"X-Request-Id\". <br/><br/> We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.  <h3 id=\"general-overriding-http-methods\"><strong>Overriding HTTP methods</strong></h3> Some HTTP clients do not support the HTTP methods PATCH or DELETE. If you are using such a client in your application, you can use a POST request instead with a special HTTP header indicating the originally intended HTTP method. <br/><br/> The header's name is <strong>X-HTTP-Method-Override</strong>. Set its value to either <strong>PATCH</strong> or <strong>DELETE</strong>. POST Requests having this header set will be treated either as PATCH or DELETE by the finAPI servers. <br/><br/> Example: <br/><br/> <strong>X-HTTP-Method-Override: PATCH</strong><br/> POST /api/v1/label/51<br/> {\"name\": \"changed label\"}<br/><br/> will be interpreted by finAPI as:<br/><br/> PATCH /api/v1/label/51<br/> {\"name\": \"changed label\"}<br/>  <h3 id=\"general-user-metadata\"><strong>User metadata</strong></h3> With the migration to PSD2 APIs, a new term called \"User metadata\" (also known as \"PSU metadata\") has been introduced to the API. This user metadata aims to inform the banking API if there was a real end-user behind an HTTP request or if the request was triggered by a system (e.g. by an automatic batch update). In the latter case, the bank may apply some restrictions such as limiting the number of HTTP requests for a single consent. Also, some operations may be forbidden entirely by the banking API. For example, some banks do not allow issuing a new consent without the end-user being involved. Therefore, it is certainly necessary and obligatory for the customer to provide the PSU metadata for such operations. <br/><br/> As finAPI does not have direct interaction with the end-user, it is the client application's responsibility to provide all the necessary information about the end-user. This must be done by sending additional headers with every request triggered on behalf of the end-user. <br/><br/> At the moment, the following headers are supported by the API:<br/> &bull; \"PSU-IP-Address\" - the IP address of the user's device.<br/> &bull; \"PSU-Device-OS\" - the user's device and/or operating system identification.<br/> &bull; \"PSU-User-Agent\" - the user's web browser or other client device identification.  <h3 id=\"general-faq\"><strong>FAQ</strong></h3> <strong>Is there a finAPI SDK?</strong> <br/> Currently we do not offer a native SDK, but there is the option to generate an SDK for almost any target language via OpenAPI. Use the 'Download SDK' button on this page for SDK generation. <br/> <br/> <strong>How can I enable finAPI's automatic batch update?</strong> <br/> Currently there is no way to set up the batch update via the API. Please contact support@finapi.io for this. <br/> <br/> <strong>Why do I need to keep authorizing when calling services on this page?</strong> <br/> This page is a \"one-page-app\". Reloading the page resets the OAuth authorization context. There is generally no need to reload the page, so just don't do it and your authorization will persist.
 * The version of the OpenAPI document: 1.162.0
 */
class ApiClient extends OAGAC\AbstractApiClient
{
    //region changeClientCredentials
    /**
     * Change client credentials
     * @param \App\DTO\ChangeClientCredentialsParameterData $parameters
     * @param \App\DTO\ChangeClientCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function changeClientCredentialsRaw(
        \App\DTO\ChangeClientCredentialsParameterData $parameters,
        \App\DTO\ChangeClientCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/changeClientCredentials', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Change client credentials
     * @param \App\DTO\ChangeClientCredentialsParameterData $parameters
     * @param \App\DTO\ChangeClientCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function changeClientCredentials(
        \App\DTO\ChangeClientCredentialsParameterData $parameters,
        \App\DTO\ChangeClientCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->changeClientCredentialsRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Client secret successfully changed (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* The given 'clientId' is unknown or the given 'oldClientSecret' is incorrect */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Change client credentials
     * @param \App\DTO\ChangeClientCredentialsParameterData $parameters
     * @param \App\DTO\ChangeClientCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function changeClientCredentialsResult(
        \App\DTO\ChangeClientCredentialsParameterData $parameters,
        \App\DTO\ChangeClientCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->changeClientCredentials($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region checkCategorization
    /**
     * Check categorization
     * @param \App\DTO\CheckCategorizationParameterData $parameters
     * @param \App\DTO\CheckCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function checkCategorizationRaw(
        \App\DTO\CheckCategorizationParameterData $parameters,
        \App\DTO\CheckCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/tests/checkCategorization', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Check categorization
     * @param \App\DTO\CheckCategorizationParameterData $parameters
     * @param \App\DTO\CheckCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function checkCategorization(
        \App\DTO\CheckCategorizationParameterData $parameters,
        \App\DTO\CheckCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->checkCategorizationRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of given transaction IDs, mapped to their found category */
                $responseContent = new \App\DTO\CategorizationCheckResults();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 422:
                /* The number of transactions exceeds the maximum limit */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Check categorization
     * @param \App\DTO\CheckCategorizationParameterData $parameters
     * @param \App\DTO\CheckCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\CategorizationCheckResults
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function checkCategorizationResult(
        \App\DTO\CheckCategorizationParameterData $parameters,
        \App\DTO\CheckCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\CategorizationCheckResults
    {
        return $this->getSuccessfulContent(...$this->checkCategorization($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region connectInterface
    /**
     * Connect a new interface
     * @param \App\DTO\ConnectInterfaceParameterData $parameters
     * @param \App\DTO\ConnectInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function connectInterfaceRaw(
        \App\DTO\ConnectInterfaceParameterData $parameters,
        \App\DTO\ConnectInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/bankConnections/connectInterface', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Connect a new interface
     * @param \App\DTO\ConnectInterfaceParameterData $parameters
     * @param \App\DTO\ConnectInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function connectInterface(
        \App\DTO\ConnectInterfaceParameterData $parameters,
        \App\DTO\ConnectInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->connectInterfaceRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Bank connection with the new interface */
                $responseContent = new \App\DTO\BankConnection();
                break;
            case 400:
                /* Bad Request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* UNKNOWN_ENTITY:<br/> - if the specified bank connection identifier does not exist;<br/> - if the given source interface does not exist for the given bank connection;<br/>ILLEGAL_FIELD_VALUE:<br/> - if the given credentials do not contain a mandatory login field;<br/> - if 'accountReferences' are not given, but the bank connection has the DETAILED_CONSENT property set, or the given 'accountReferences' contain a wrong IBAN;<br/> - if 'redirectUrl' is not given, but the bank connection has the REDIRECT_APPROACH property set;<br/>ENTITY_EXISTS if such a bank connection interface already exists;<br/>ILLEGAL_ENTITY_STATE:<br/> - if finAPI supports only web scraping for the bank, but web scraping is disabled for the client;<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>BANK_SERVER_REJECTION if the bank server responded with an error message when finAPI tried to retrieve the user's data. The response's error message typically contains useful information from the bank (like that the given login credentials were not correct or that the connection is not activated for online banking) and may be forwarded to the user;<br/>NO_ACCOUNTS_FOR_TYPE_LIST if none of the accounts that the bank returned matched the given account types (or if the bank didn't return any accounts at all);<br/>NO_EXISTING_CHALLENGE in case the 'multiStepAuthentication.challengeResponse' field was set, but there is no pending challenge;<br/>LOGIN_FIELDS_MISMATCH if the source interface is given, but its login fields differ to the main interface;<br/>MISSING_CREDENTIALS if not all login fields of the source interface have stored values; */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* An interface cannot get connected at the moment as the related bank connection is currently being imported or updated (either by the user or by finAPI's automatic batch update). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 451:
                /* THIS HTTP RESPONSE CODE IS DEPRECATED AND WILL BE REMOVED.<br/>Instead please refer to our Web Form offering <a href=\"?product=web_form_2.0\">here</a>.<br/><br/>In case the user must enter credentials within finAPI's Web Form. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 501:
                /* This bank is currently not supported by finAPI */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 510:
                /* In case the bank requires an additional authentication by the user. The error's 'multiStepAuthentication' field contains further instructions. The actual MSA flow depends on the bank and may contain following statuses:<br/><br/>TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the 'twoStepProcedureId' field.<br/><br/>CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the 'challengeResponse' field.<br/><br/>REDIRECT_REQUIRED means that the user must be redirected to the bank's website, where the authentication can be finished.<br/><br/>DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the 'decoupledCallback' field must be set to true to complete the authentication.<br/><br/>DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the 'decoupledCallback' field set to 'true'. Once the decoupled authentication is completed by the user, the service returns a successful response. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Connect a new interface
     * @param \App\DTO\ConnectInterfaceParameterData $parameters
     * @param \App\DTO\ConnectInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\BankConnection
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function connectInterfaceResult(
        \App\DTO\ConnectInterfaceParameterData $parameters,
        \App\DTO\ConnectInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnection
    {
        return $this->getSuccessfulContent(...$this->connectInterface($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createCategory
    /**
     * Create a new category
     * @param \App\DTO\CreateCategoryParameterData $parameters
     * @param \App\DTO\CategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createCategoryRaw(
        \App\DTO\CreateCategoryParameterData $parameters,
        \App\DTO\CategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/categories', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create a new category
     * @param \App\DTO\CreateCategoryParameterData $parameters
     * @param \App\DTO\CategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createCategory(
        \App\DTO\CreateCategoryParameterData $parameters,
        \App\DTO\CategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createCategoryRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created category */
                $responseContent = new \App\DTO\Category();
                break;
            case 400:
                /* The category name is too long. The maximum length for a category name is 128. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* UNKNOWN_ENTITY if the parent category does not exist. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_ENTITY_STATE if The given parentId references a sub-category instead of a main category (Multi-level sub-categories are not supported); <br/>ENTITY_EXISTS if a category with that name already exists.<br/>NOTE: A category already exists means that there is another category of the same name on the same hierarchy level.<br/>Examples:<br/>&bull; if you want to add a sub-category 'Sub' to the main category 'Main', and 'Main' already contains 'Sub', then the category already exists and cannot get created.<br/>&bull; if you want to add a sub-category 'Sub' to the main category 'Main', and some other main category contains 'Sub' (or a main category itself is called 'Sub'), then the category can still get created, because there is no 'Sub' in the 'Main' category<br/>&bull; if you want to add a new main-category 'Main' and there is already a main category with that name, then the category already exists and cannot get created */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create a new category
     * @param \App\DTO\CreateCategoryParameterData $parameters
     * @param \App\DTO\CategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Category
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createCategoryResult(
        \App\DTO\CreateCategoryParameterData $parameters,
        \App\DTO\CategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Category
    {
        return $this->getSuccessfulContent(...$this->createCategory($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createDirectDebit
    /**
     * Create direct debit
     * @param \App\DTO\CreateDirectDebitParameterData $parameters
     * @param \App\DTO\CreateDirectDebitParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createDirectDebitRaw(
        \App\DTO\CreateDirectDebitParameterData $parameters,
        \App\DTO\CreateDirectDebitParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/payments/directDebits', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create direct debit
     * @param \App\DTO\CreateDirectDebitParameterData $parameters
     * @param \App\DTO\CreateDirectDebitParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createDirectDebit(
        \App\DTO\CreateDirectDebitParameterData $parameters,
        \App\DTO\CreateDirectDebitParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createDirectDebitRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created payment */
                $responseContent = new \App\DTO\Payment();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE:<br/> - if the given execution date is in the past;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>UNSUPPORTED_ORDER:<br/> - if the request doesn't fit to the capabilities of any of the interfaces connected to the given account; */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create direct debit
     * @param \App\DTO\CreateDirectDebitParameterData $parameters
     * @param \App\DTO\CreateDirectDebitParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Payment
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createDirectDebitResult(
        \App\DTO\CreateDirectDebitParameterData $parameters,
        \App\DTO\CreateDirectDebitParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Payment
    {
        return $this->getSuccessfulContent(...$this->createDirectDebit($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createIbanRules
    /**
     * Create IBAN rules
     * @param \App\DTO\CreateIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createIbanRulesRaw(
        \App\DTO\CreateIbanRulesParameterData $parameters,
        \App\DTO\IbanRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/ibanRules', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create IBAN rules
     * @param \App\DTO\CreateIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createIbanRules(
        \App\DTO\CreateIbanRulesParameterData $parameters,
        \App\DTO\IbanRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createIbanRulesRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created IBAN rules */
                $responseContent = new \App\DTO\IbanRuleList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ENTITY_EXISTS if at least one of the given rules already exists */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create IBAN rules
     * @param \App\DTO\CreateIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\IbanRuleList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createIbanRulesResult(
        \App\DTO\CreateIbanRulesParameterData $parameters,
        \App\DTO\IbanRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\IbanRuleList
    {
        return $this->getSuccessfulContent(...$this->createIbanRules($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createKeywordRules
    /**
     * Create keyword rules
     * @param \App\DTO\CreateKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createKeywordRulesRaw(
        \App\DTO\CreateKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/keywordRules', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create keyword rules
     * @param \App\DTO\CreateKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createKeywordRules(
        \App\DTO\CreateKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createKeywordRulesRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created keyword rules */
                $responseContent = new \App\DTO\KeywordRuleList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ENTITY_EXISTS if at least one of the given rules already exists; ILLEGAL_FIELD_VALUE if the request contains incorrect keywords. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create keyword rules
     * @param \App\DTO\CreateKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRulesParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\KeywordRuleList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createKeywordRulesResult(
        \App\DTO\CreateKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRulesParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\KeywordRuleList
    {
        return $this->getSuccessfulContent(...$this->createKeywordRules($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createLabel
    /**
     * Create a new label
     * @param \App\DTO\CreateLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createLabelRaw(
        \App\DTO\CreateLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/labels', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create a new label
     * @param \App\DTO\CreateLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createLabel(
        \App\DTO\CreateLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createLabelRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created label */
                $responseContent = new \App\DTO\Label();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE if  the given label name is too long; ENTITY_EXISTS if a label with the given name already exists */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create a new label
     * @param \App\DTO\CreateLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Label
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createLabelResult(
        \App\DTO\CreateLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Label
    {
        return $this->getSuccessfulContent(...$this->createLabel($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createMoneyTransfer
    /**
     * Create money transfer
     * @param \App\DTO\CreateMoneyTransferParameterData $parameters
     * @param \App\DTO\CreateMoneyTransferParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createMoneyTransferRaw(
        \App\DTO\CreateMoneyTransferParameterData $parameters,
        \App\DTO\CreateMoneyTransferParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/payments/moneyTransfers', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create money transfer
     * @param \App\DTO\CreateMoneyTransferParameterData $parameters
     * @param \App\DTO\CreateMoneyTransferParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createMoneyTransfer(
        \App\DTO\CreateMoneyTransferParameterData $parameters,
        \App\DTO\CreateMoneyTransferParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createMoneyTransferRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created payment */
                $responseContent = new \App\DTO\Payment();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE:<br/> - if the given execution date is invalid;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>UNSUPPORTED_ORDER:<br/>- if the request doesn't fit to the capabilities of any of the interfaces connected to the given account; or if the given IBAN relates to a bank that is unknown or not available to you (you may want to use the 'Get and search all banks' service to check the IBAN prior to calling this service); */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create money transfer
     * @param \App\DTO\CreateMoneyTransferParameterData $parameters
     * @param \App\DTO\CreateMoneyTransferParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Payment
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createMoneyTransferResult(
        \App\DTO\CreateMoneyTransferParameterData $parameters,
        \App\DTO\CreateMoneyTransferParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Payment
    {
        return $this->getSuccessfulContent(...$this->createMoneyTransfer($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createNewCertificate
    /**
     * Upload TPP certificate
     * @param \App\DTO\CreateNewCertificateParameterData $parameters
     * @param \App\DTO\TppCertificateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createNewCertificateRaw(
        \App\DTO\CreateNewCertificateParameterData $parameters,
        \App\DTO\TppCertificateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/tppCertificates', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Upload TPP certificate
     * @param \App\DTO\CreateNewCertificateParameterData $parameters
     * @param \App\DTO\TppCertificateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createNewCertificate(
        \App\DTO\CreateNewCertificateParameterData $parameters,
        \App\DTO\TppCertificateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createNewCertificateRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Uploaded TPP certificate */
                $responseContent = new \App\DTO\TppCertificate();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* TPP certificate is invalid or expired */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Upload TPP certificate
     * @param \App\DTO\CreateNewCertificateParameterData $parameters
     * @param \App\DTO\TppCertificateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\TppCertificate
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createNewCertificateResult(
        \App\DTO\CreateNewCertificateParameterData $parameters,
        \App\DTO\TppCertificateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\TppCertificate
    {
        return $this->getSuccessfulContent(...$this->createNewCertificate($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createNotificationRule
    /**
     * Create a new notification rule
     * @param \App\DTO\CreateNotificationRuleParameterData $parameters
     * @param \App\DTO\NotificationRuleParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createNotificationRuleRaw(
        \App\DTO\CreateNotificationRuleParameterData $parameters,
        \App\DTO\NotificationRuleParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/notificationRules', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create a new notification rule
     * @param \App\DTO\CreateNotificationRuleParameterData $parameters
     * @param \App\DTO\NotificationRuleParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createNotificationRule(
        \App\DTO\CreateNotificationRuleParameterData $parameters,
        \App\DTO\NotificationRuleParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createNotificationRuleRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created notification rule */
                $responseContent = new \App\DTO\NotificationRule();
                break;
            case 400:
                /* Bad Request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE if the given 'triggerEvent' does not match any of the known constants, or if the 'params' field contains illegal parameters for the respective trigger event; ENTITY_EXISTS if such a notification rule already exists */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Notification rules cannot get created at the moment as finAPI's automatic batch update is currently being executed */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create a new notification rule
     * @param \App\DTO\CreateNotificationRuleParameterData $parameters
     * @param \App\DTO\NotificationRuleParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\NotificationRule
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createNotificationRuleResult(
        \App\DTO\CreateNotificationRuleParameterData $parameters,
        \App\DTO\NotificationRuleParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\NotificationRule
    {
        return $this->getSuccessfulContent(...$this->createNotificationRule($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createStandingOrder
    /**
     * Create a standing order
     * @param \App\DTO\CreateStandingOrderParameterData $parameters
     * @param \App\DTO\CreateStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createStandingOrderRaw(
        \App\DTO\CreateStandingOrderParameterData $parameters,
        \App\DTO\CreateStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/standingOrders', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create a standing order
     * @param \App\DTO\CreateStandingOrderParameterData $parameters
     * @param \App\DTO\CreateStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createStandingOrder(
        \App\DTO\CreateStandingOrderParameterData $parameters,
        \App\DTO\CreateStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createStandingOrderRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created standing order */
                $responseContent = new \App\DTO\StandingOrder();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE:<br/> - if the amount is negative;<br/> - if the given start date is not in the future;<br/> - if the frequency has an incorrect value;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>UNSUPPORTED_ORDER:<br/> - if the IBAN relates to the bank is unknown or not available; */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create a standing order
     * @param \App\DTO\CreateStandingOrderParameterData $parameters
     * @param \App\DTO\CreateStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\StandingOrder
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createStandingOrderResult(
        \App\DTO\CreateStandingOrderParameterData $parameters,
        \App\DTO\CreateStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\StandingOrder
    {
        return $this->getSuccessfulContent(...$this->createStandingOrder($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createTppCredential
    /**
     * Upload TPP credentials
     * @param \App\DTO\CreateTppCredentialParameterData $parameters
     * @param \App\DTO\TppCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createTppCredentialRaw(
        \App\DTO\CreateTppCredentialParameterData $parameters,
        \App\DTO\TppCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/tppCredentials', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Upload TPP credentials
     * @param \App\DTO\CreateTppCredentialParameterData $parameters
     * @param \App\DTO\TppCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createTppCredential(
        \App\DTO\CreateTppCredentialParameterData $parameters,
        \App\DTO\TppCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createTppCredentialRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Uploaded TPP credentials */
                $responseContent = new \App\DTO\TppCredentials();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* UNKNOWN_ENTITY if the specified TPP authentication group does not exist;<br/>ILLEGAL_FIELD_VALUE if the given validity dates are invalid */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Upload TPP credentials
     * @param \App\DTO\CreateTppCredentialParameterData $parameters
     * @param \App\DTO\TppCredentialsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\TppCredentials
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createTppCredentialResult(
        \App\DTO\CreateTppCredentialParameterData $parameters,
        \App\DTO\TppCredentialsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\TppCredentials
    {
        return $this->getSuccessfulContent(...$this->createTppCredential($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region createUser
    /**
     * Create a new user
     * @param \App\DTO\CreateUserParameterData $parameters
     * @param \App\DTO\UserCreateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function createUserRaw(
        \App\DTO\CreateUserParameterData $parameters,
        \App\DTO\UserCreateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/users', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Create a new user
     * @param \App\DTO\CreateUserParameterData $parameters
     * @param \App\DTO\UserCreateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function createUser(
        \App\DTO\CreateUserParameterData $parameters,
        \App\DTO\UserCreateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->createUserRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Created user's data */
                $responseContent = new \App\DTO\User();
                break;
            case 400:
                /* Bad request (for instance if the given password is too short/long) */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ENTITY_EXISTS if the given userId already exists; ILLEGAL_ENTITY_STATE if you passed 'isAutoUpdateEnabled' = true, but the automatic update can't be enabled for this user (as it is disabled for the client). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Create a new user
     * @param \App\DTO\CreateUserParameterData $parameters
     * @param \App\DTO\UserCreateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\User
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function createUserResult(
        \App\DTO\CreateUserParameterData $parameters,
        \App\DTO\UserCreateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\User
    {
        return $this->getSuccessfulContent(...$this->createUser($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region deleteAccessData
    /**
     * Delete a consent
     * @param \App\DTO\DeleteAccessDataParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAccessDataRaw(
        \App\DTO\DeleteAccessDataParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/bankConnections/{id}/aisConsent', $this->getPathParameters($parameters), $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a consent
     * @param \App\DTO\DeleteAccessDataParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAccessData(
        \App\DTO\DeleteAccessDataParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAccessDataRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Consent deletion result */
                $responseContent = new \App\DTO\DeleteConsent();
                break;
            case 400:
                /* Bad Request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* UNKNOWN_ENTITY:<br/> - if the given bank connection identifier does not exist;<br/> - if the given interface does not exist for the bank connection;<br/>INVALID_CONSENT:<br/> - if the bank server responded with an error when finAPI tried to delete the consent.<br/> */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* The consent cannot be removed at the moment as the bank connection interface is currently being imported or updated (either by the user or by finAPI's automatic batch update). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a consent
     * @param \App\DTO\DeleteAccessDataParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\DeleteConsent
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAccessDataResult(
        \App\DTO\DeleteAccessDataParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\DeleteConsent
    {
        return $this->getSuccessfulContent(...$this->deleteAccessData($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAccount
    /**
     * Delete an account
     * @param \App\DTO\DeleteAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAccountRaw(
        \App\DTO\DeleteAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/accounts/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete an account
     * @param \App\DTO\DeleteAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAccount(
        \App\DTO\DeleteAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAccountRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Account deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Account cannot get deleted at the moment as it is currently being imported or updated (either by the user or by finAPI's automatic batch update), or because the categorization of transactions is performed. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete an account
     * @param \App\DTO\DeleteAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAccountResult(
        \App\DTO\DeleteAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteAccount($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllAccounts
    /**
     * Delete all accounts
     * @param \App\DTO\DeleteAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllAccountsRaw(
        \App\DTO\DeleteAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/accounts', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all accounts
     * @param \App\DTO\DeleteAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllAccounts(
        \App\DTO\DeleteAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllAccountsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted accounts */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* No action was performed as at least one account is currently being imported, updated (either by the user or by finAPI's automatic batch update), or because the categorization of transactions is performed. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all accounts
     * @param \App\DTO\DeleteAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllAccountsResult(
        \App\DTO\DeleteAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllAccounts($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllBankConnections
    /**
     * Delete all bank connections
     * @param \App\DTO\DeleteAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllBankConnectionsRaw(
        \App\DTO\DeleteAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/bankConnections', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all bank connections
     * @param \App\DTO\DeleteAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllBankConnections(
        \App\DTO\DeleteAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllBankConnectionsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted bank connections */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* No action was performed at the moment as at least one bank connection is being imported, updated (either by the user or by finAPI's automatic batch update), or because the categorization of transactions is currently performed. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all bank connections
     * @param \App\DTO\DeleteAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllBankConnectionsResult(
        \App\DTO\DeleteAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllBankConnections($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllCategories
    /**
     * Delete all categories
     * @param \App\DTO\DeleteAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllCategoriesRaw(
        \App\DTO\DeleteAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/categories', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all categories
     * @param \App\DTO\DeleteAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllCategories(
        \App\DTO\DeleteAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllCategoriesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted categories */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all categories
     * @param \App\DTO\DeleteAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllCategoriesResult(
        \App\DTO\DeleteAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllCategories($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllLabels
    /**
     * Delete all labels
     * @param \App\DTO\DeleteAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllLabelsRaw(
        \App\DTO\DeleteAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/labels', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all labels
     * @param \App\DTO\DeleteAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllLabels(
        \App\DTO\DeleteAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllLabelsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted labels */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all labels
     * @param \App\DTO\DeleteAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllLabelsResult(
        \App\DTO\DeleteAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllLabels($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllNotificationRules
    /**
     * Delete all notification rules
     * @param \App\DTO\DeleteAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllNotificationRulesRaw(
        \App\DTO\DeleteAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/notificationRules', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all notification rules
     * @param \App\DTO\DeleteAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllNotificationRules(
        \App\DTO\DeleteAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllNotificationRulesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted notification rules */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Notification rules cannot get deleted at the moment as finAPI's automatic batch update is currently being executed */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all notification rules
     * @param \App\DTO\DeleteAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllNotificationRulesResult(
        \App\DTO\DeleteAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllNotificationRules($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAllTransactions
    /**
     * Delete all transactions
     * @param \App\DTO\DeleteAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAllTransactionsRaw(
        \App\DTO\DeleteAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/transactions', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete all transactions
     * @param \App\DTO\DeleteAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAllTransactions(
        \App\DTO\DeleteAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAllTransactionsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of all deleted transactions */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete all transactions
     * @param \App\DTO\DeleteAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAllTransactionsResult(
        \App\DTO\DeleteAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteAllTransactions($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteAuthorizedUser
    /**
     * Delete the authorized user
     * @param \App\DTO\DeleteAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteAuthorizedUserRaw(
        \App\DTO\DeleteAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/users', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete the authorized user
     * @param \App\DTO\DeleteAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteAuthorizedUser(
        \App\DTO\DeleteAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteAuthorizedUserRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* User deleted (empty response body) */
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* User cannot get deleted at the moment as at least one of his bank connections is currently being imported or updated (either by the user or by finAPI's automatic batch update), or because the categorization of transactions is performed. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete the authorized user
     * @param \App\DTO\DeleteAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteAuthorizedUserResult(
        \App\DTO\DeleteAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteAuthorizedUser($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteBankConnection
    /**
     * Delete a bank connection
     * @param \App\DTO\DeleteBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteBankConnectionRaw(
        \App\DTO\DeleteBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/bankConnections/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a bank connection
     * @param \App\DTO\DeleteBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteBankConnection(
        \App\DTO\DeleteBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteBankConnectionRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Bank connection deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Bank connection cannot get deleted at the moment as it is currently being imported or updated (either by the user or by finAPI's automatic batch update), or because the categorization of transactions is currently performed. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a bank connection
     * @param \App\DTO\DeleteBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteBankConnectionResult(
        \App\DTO\DeleteBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteBankConnection($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteCategory
    /**
     * Delete a category
     * @param \App\DTO\DeleteCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteCategoryRaw(
        \App\DTO\DeleteCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/categories/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a category
     * @param \App\DTO\DeleteCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteCategory(
        \App\DTO\DeleteCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteCategoryRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Category was deleted successfully (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* Category cannot be deleted */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a category
     * @param \App\DTO\DeleteCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteCategoryResult(
        \App\DTO\DeleteCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteCategory($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteCertificate
    /**
     * Delete a TPP certificate
     * @param \App\DTO\DeleteCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteCertificateRaw(
        \App\DTO\DeleteCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/tppCertificates/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a TPP certificate
     * @param \App\DTO\DeleteCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteCertificate(
        \App\DTO\DeleteCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteCertificateRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* TPP certificate deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* TPP certificate not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a TPP certificate
     * @param \App\DTO\DeleteCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteCertificateResult(
        \App\DTO\DeleteCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteCertificate($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteIbanRules
    /**
     * Delete IBAN rules
     * @param \App\DTO\DeleteIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteIbanRulesRaw(
        \App\DTO\DeleteIbanRulesParameterData $parameters,
        \App\DTO\IbanRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/ibanRules/delete', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete IBAN rules
     * @param \App\DTO\DeleteIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteIbanRules(
        \App\DTO\DeleteIbanRulesParameterData $parameters,
        \App\DTO\IbanRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteIbanRulesRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted IBAN rules */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* IBAN rule not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete IBAN rules
     * @param \App\DTO\DeleteIbanRulesParameterData $parameters
     * @param \App\DTO\IbanRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteIbanRulesResult(
        \App\DTO\DeleteIbanRulesParameterData $parameters,
        \App\DTO\IbanRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteIbanRules($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region deleteKeywordRules
    /**
     * Delete keyword rules
     * @param \App\DTO\DeleteKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteKeywordRulesRaw(
        \App\DTO\DeleteKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/keywordRules/delete', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete keyword rules
     * @param \App\DTO\DeleteKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteKeywordRules(
        \App\DTO\DeleteKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteKeywordRulesRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted keyword rules */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Keyword rule not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete keyword rules
     * @param \App\DTO\DeleteKeywordRulesParameterData $parameters
     * @param \App\DTO\KeywordRuleIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteKeywordRulesResult(
        \App\DTO\DeleteKeywordRulesParameterData $parameters,
        \App\DTO\KeywordRuleIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->deleteKeywordRules($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region deleteLabel
    /**
     * Delete a label
     * @param \App\DTO\DeleteLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteLabelRaw(
        \App\DTO\DeleteLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/labels/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a label
     * @param \App\DTO\DeleteLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteLabel(
        \App\DTO\DeleteLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteLabelRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Label deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Label not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a label
     * @param \App\DTO\DeleteLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteLabelResult(
        \App\DTO\DeleteLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteLabel($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteNotificationRule
    /**
     * Delete a notification rule
     * @param \App\DTO\DeleteNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteNotificationRuleRaw(
        \App\DTO\DeleteNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/notificationRules/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a notification rule
     * @param \App\DTO\DeleteNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteNotificationRule(
        \App\DTO\DeleteNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteNotificationRuleRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Notification rule deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Notification rule not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Notification rules cannot get deleted at the moment as finAPI's automatic batch update is currently being executed */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a notification rule
     * @param \App\DTO\DeleteNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteNotificationRuleResult(
        \App\DTO\DeleteNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteNotificationRule($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteTppCredential
    /**
     * Delete a set of TPP credentials
     * @param \App\DTO\DeleteTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteTppCredentialRaw(
        \App\DTO\DeleteTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/tppCredentials/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a set of TPP credentials
     * @param \App\DTO\DeleteTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteTppCredential(
        \App\DTO\DeleteTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteTppCredentialRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* TPP credentials deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* TPP credentials not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a set of TPP credentials
     * @param \App\DTO\DeleteTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteTppCredentialResult(
        \App\DTO\DeleteTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteTppCredential($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteTransaction
    /**
     * Delete a transaction
     * @param \App\DTO\DeleteTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteTransactionRaw(
        \App\DTO\DeleteTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/transactions/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete a transaction
     * @param \App\DTO\DeleteTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteTransaction(
        \App\DTO\DeleteTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteTransactionRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Transaction deleted (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Transaction not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* Transaction cannot get deleted */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete a transaction
     * @param \App\DTO\DeleteTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteTransactionResult(
        \App\DTO\DeleteTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteTransaction($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteUnverifiedUser
    /**
     * Delete an unverified user
     * @param \App\DTO\DeleteUnverifiedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteUnverifiedUserRaw(
        \App\DTO\DeleteUnverifiedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('DELETE', '/api/v1/users/{userId}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete an unverified user
     * @param \App\DTO\DeleteUnverifiedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteUnverifiedUser(
        \App\DTO\DeleteUnverifiedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteUnverifiedUserRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* User deleted (empty response body) */
                break;
            case 400:
                /* Identifier is not given */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* User not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* The user with the given identifier is already verified */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete an unverified user
     * @param \App\DTO\DeleteUnverifiedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteUnverifiedUserResult(
        \App\DTO\DeleteUnverifiedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->deleteUnverifiedUser($parameters, $security, $responseMediaType));
    }
    //endregion

    //region deleteUsers
    /**
     * Delete users
     * @param \App\DTO\DeleteUsersParameterData $parameters
     * @param \App\DTO\UserIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function deleteUsersRaw(
        \App\DTO\DeleteUsersParameterData $parameters,
        \App\DTO\UserIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/mandatorAdmin/deleteUsers', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Delete users
     * @param \App\DTO\DeleteUsersParameterData $parameters
     * @param \App\DTO\UserIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function deleteUsers(
        \App\DTO\DeleteUsersParameterData $parameters,
        \App\DTO\UserIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->deleteUsersRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of deleted and not deleted users */
                $responseContent = new \App\DTO\UserIdentifiersList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Delete users
     * @param \App\DTO\DeleteUsersParameterData $parameters
     * @param \App\DTO\UserIdentifiersParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\UserIdentifiersList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function deleteUsersResult(
        \App\DTO\DeleteUsersParameterData $parameters,
        \App\DTO\UserIdentifiersParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\UserIdentifiersList
    {
        return $this->getSuccessfulContent(...$this->deleteUsers($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editAccount
    /**
     * Edit an account
     * @param \App\DTO\EditAccountParameterData $parameters
     * @param \App\DTO\AccountParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editAccountRaw(
        \App\DTO\EditAccountParameterData $parameters,
        \App\DTO\AccountParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/accounts/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit an account
     * @param \App\DTO\EditAccountParameterData $parameters
     * @param \App\DTO\AccountParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editAccount(
        \App\DTO\EditAccountParameterData $parameters,
        \App\DTO\AccountParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editAccountRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited account */
                $responseContent = new \App\DTO\Account();
                break;
            case 400:
                /* BAD_REQUEST if request is incorrect; MISSING_FIELD if neither a name, nor a type, nor the 'isNew' flag were specified; UNKNOWN_ENTITY if the given account type id does not exist; ILLEGAL_FIELD_VALUE if the given account type is invalid */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Account cannot get edited at the moment as it is currently being imported or updated (either by the user or by finAPI's automatic batch update). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit an account
     * @param \App\DTO\EditAccountParameterData $parameters
     * @param \App\DTO\AccountParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Account
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editAccountResult(
        \App\DTO\EditAccountParameterData $parameters,
        \App\DTO\AccountParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Account
    {
        return $this->getSuccessfulContent(...$this->editAccount($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editAuthorizedUser
    /**
     * Edit the authorized user
     * @param \App\DTO\EditAuthorizedUserParameterData $parameters
     * @param \App\DTO\UserUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editAuthorizedUserRaw(
        \App\DTO\EditAuthorizedUserParameterData $parameters,
        \App\DTO\UserUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/users', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit the authorized user
     * @param \App\DTO\EditAuthorizedUserParameterData $parameters
     * @param \App\DTO\UserUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editAuthorizedUser(
        \App\DTO\EditAuthorizedUserParameterData $parameters,
        \App\DTO\UserUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editAuthorizedUserRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited user data */
                $responseContent = new \App\DTO\User();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* The automatic update cannot be enabled */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit the authorized user
     * @param \App\DTO\EditAuthorizedUserParameterData $parameters
     * @param \App\DTO\UserUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\User
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editAuthorizedUserResult(
        \App\DTO\EditAuthorizedUserParameterData $parameters,
        \App\DTO\UserUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\User
    {
        return $this->getSuccessfulContent(...$this->editAuthorizedUser($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editBankConnection
    /**
     * Edit a bank connection
     * @param \App\DTO\EditBankConnectionParameterData $parameters
     * @param \App\DTO\EditBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editBankConnectionRaw(
        \App\DTO\EditBankConnectionParameterData $parameters,
        \App\DTO\EditBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/bankConnections/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit a bank connection
     * @param \App\DTO\EditBankConnectionParameterData $parameters
     * @param \App\DTO\EditBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editBankConnection(
        \App\DTO\EditBankConnectionParameterData $parameters,
        \App\DTO\EditBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editBankConnectionRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited bank connection */
                $responseContent = new \App\DTO\BankConnection();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* INVALID_TWO_STEP_PROCEDURE:<br/>if submitted two-step-procedure does not exist for the user. Please use one of the procedures that are listed in the bank connection;<br/>ILLEGAL_FIELD_VALUE:<br/>- if the bank connection's credentials were tried to be changed, but the new credentials are equal to the credentials of another existing bank connection of the same bank.<br/> - in case an update attempt is made using an interface that is not connected to the bank;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support; */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Bank connection cannot get edited at the moment as it is currently being imported, updated (either by the user or by finAPI's automatic batch update) or a new interface is being connected. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 451:
                /* THIS HTTP RESPONSE CODE IS DEPRECATED AND WILL BE REMOVED.<br/>Instead please refer to our Web Form offering <a href=\"?product=web_form_2.0\">here</a>.<br/><br/>In case the user must enter credentials within finAPI's Web Form. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit a bank connection
     * @param \App\DTO\EditBankConnectionParameterData $parameters
     * @param \App\DTO\EditBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\BankConnection
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editBankConnectionResult(
        \App\DTO\EditBankConnectionParameterData $parameters,
        \App\DTO\EditBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnection
    {
        return $this->getSuccessfulContent(...$this->editBankConnection($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editCategory
    /**
     * Edit a category
     * @param \App\DTO\EditCategoryParameterData $parameters
     * @param \App\DTO\EditCategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editCategoryRaw(
        \App\DTO\EditCategoryParameterData $parameters,
        \App\DTO\EditCategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/categories/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit a category
     * @param \App\DTO\EditCategoryParameterData $parameters
     * @param \App\DTO\EditCategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editCategory(
        \App\DTO\EditCategoryParameterData $parameters,
        \App\DTO\EditCategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editCategoryRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited transaction category */
                $responseContent = new \App\DTO\Category();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* Category cannot be edited */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit a category
     * @param \App\DTO\EditCategoryParameterData $parameters
     * @param \App\DTO\EditCategoryParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Category
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editCategoryResult(
        \App\DTO\EditCategoryParameterData $parameters,
        \App\DTO\EditCategoryParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Category
    {
        return $this->getSuccessfulContent(...$this->editCategory($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editClientConfiguration
    /**
     * Edit client configuration
     * @param \App\DTO\EditClientConfigurationParameterData $parameters
     * @param \App\DTO\ClientConfigurationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editClientConfigurationRaw(
        \App\DTO\EditClientConfigurationParameterData $parameters,
        \App\DTO\ClientConfigurationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/clientConfiguration', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit client configuration
     * @param \App\DTO\EditClientConfigurationParameterData $parameters
     * @param \App\DTO\ClientConfigurationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editClientConfiguration(
        \App\DTO\EditClientConfigurationParameterData $parameters,
        \App\DTO\ClientConfigurationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editClientConfigurationRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* New client configuration */
                $responseContent = new \App\DTO\ClientConfiguration();
                break;
            case 400:
                /* Bad request (e.g. invalid callback URL) */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit client configuration
     * @param \App\DTO\EditClientConfigurationParameterData $parameters
     * @param \App\DTO\ClientConfigurationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\ClientConfiguration
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editClientConfigurationResult(
        \App\DTO\EditClientConfigurationParameterData $parameters,
        \App\DTO\ClientConfigurationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\ClientConfiguration
    {
        return $this->getSuccessfulContent(...$this->editClientConfiguration($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editLabel
    /**
     * Edit a label
     * @param \App\DTO\EditLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editLabelRaw(
        \App\DTO\EditLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/labels/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit a label
     * @param \App\DTO\EditLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editLabel(
        \App\DTO\EditLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editLabelRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited label */
                $responseContent = new \App\DTO\Label();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Label not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_FIELD_VALUE if  the given label name is too long; ENTITY_EXISTS if a label with the given name already exists */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit a label
     * @param \App\DTO\EditLabelParameterData $parameters
     * @param \App\DTO\LabelParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Label
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editLabelResult(
        \App\DTO\EditLabelParameterData $parameters,
        \App\DTO\LabelParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Label
    {
        return $this->getSuccessfulContent(...$this->editLabel($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editMultipleTransactions
    /**
     * Edit multiple transactions
     * @param \App\DTO\EditMultipleTransactionsParameterData $parameters
     * @param \App\DTO\UpdateMultipleTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editMultipleTransactionsRaw(
        \App\DTO\EditMultipleTransactionsParameterData $parameters,
        \App\DTO\UpdateMultipleTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/transactions', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit multiple transactions
     * @param \App\DTO\EditMultipleTransactionsParameterData $parameters
     * @param \App\DTO\UpdateMultipleTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editMultipleTransactions(
        \App\DTO\EditMultipleTransactionsParameterData $parameters,
        \App\DTO\UpdateMultipleTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editMultipleTransactionsRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of identifiers of all updated transactions */
                $responseContent = new \App\DTO\IdentifierList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category or labels not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* If 'isPotentialDuplicate' is set to 'true' (only 'false' is allowed) */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit multiple transactions
     * @param \App\DTO\EditMultipleTransactionsParameterData $parameters
     * @param \App\DTO\UpdateMultipleTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\IdentifierList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editMultipleTransactionsResult(
        \App\DTO\EditMultipleTransactionsParameterData $parameters,
        \App\DTO\UpdateMultipleTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\IdentifierList
    {
        return $this->getSuccessfulContent(...$this->editMultipleTransactions($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editTppCredential
    /**
     * Edit a set of TPP credentials
     * @param \App\DTO\EditTppCredentialParameterData $parameters
     * @param \App\DTO\EditTppCredentialParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editTppCredentialRaw(
        \App\DTO\EditTppCredentialParameterData $parameters,
        \App\DTO\EditTppCredentialParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/tppCredentials/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit a set of TPP credentials
     * @param \App\DTO\EditTppCredentialParameterData $parameters
     * @param \App\DTO\EditTppCredentialParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editTppCredential(
        \App\DTO\EditTppCredentialParameterData $parameters,
        \App\DTO\EditTppCredentialParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editTppCredentialRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited TPP credentials */
                $responseContent = new \App\DTO\TppCredentials();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* TPP credentials not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* UNKNOWN_ENTITY if the specified TPP authentication group does not exist;<br/>ILLEGAL_FIELD_VALUE if the given validity dates are invalid */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit a set of TPP credentials
     * @param \App\DTO\EditTppCredentialParameterData $parameters
     * @param \App\DTO\EditTppCredentialParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\TppCredentials
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editTppCredentialResult(
        \App\DTO\EditTppCredentialParameterData $parameters,
        \App\DTO\EditTppCredentialParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\TppCredentials
    {
        return $this->getSuccessfulContent(...$this->editTppCredential($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region editTransaction
    /**
     * Edit a transaction
     * @param \App\DTO\EditTransactionParameterData $parameters
     * @param \App\DTO\UpdateTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function editTransactionRaw(
        \App\DTO\EditTransactionParameterData $parameters,
        \App\DTO\UpdateTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('PATCH', '/api/v1/transactions/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Edit a transaction
     * @param \App\DTO\EditTransactionParameterData $parameters
     * @param \App\DTO\UpdateTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function editTransaction(
        \App\DTO\EditTransactionParameterData $parameters,
        \App\DTO\UpdateTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->editTransactionRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Edited transaction */
                $responseContent = new \App\DTO\Transaction();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Transaction, category or labels not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* If 'isPotentialDuplicate' is set to 'true' (only 'false' is allowed) */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Edit a transaction
     * @param \App\DTO\EditTransactionParameterData $parameters
     * @param \App\DTO\UpdateTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Transaction
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function editTransactionResult(
        \App\DTO\EditTransactionParameterData $parameters,
        \App\DTO\UpdateTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Transaction
    {
        return $this->getSuccessfulContent(...$this->editTransaction($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region executePasswordChange
    /**
     * Execute password change
     * @param \App\DTO\ExecutePasswordChangeParameterData $parameters
     * @param \App\DTO\ExecutePasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function executePasswordChangeRaw(
        \App\DTO\ExecutePasswordChangeParameterData $parameters,
        \App\DTO\ExecutePasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/users/executePasswordChange', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Execute password change
     * @param \App\DTO\ExecutePasswordChangeParameterData $parameters
     * @param \App\DTO\ExecutePasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function executePasswordChange(
        \App\DTO\ExecutePasswordChangeParameterData $parameters,
        \App\DTO\ExecutePasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->executePasswordChangeRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Password changed (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* User not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Execute password change
     * @param \App\DTO\ExecutePasswordChangeParameterData $parameters
     * @param \App\DTO\ExecutePasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function executePasswordChangeResult(
        \App\DTO\ExecutePasswordChangeParameterData $parameters,
        \App\DTO\ExecutePasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->executePasswordChange($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region getAccount
    /**
     * Get an account
     * @param \App\DTO\GetAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAccountRaw(
        \App\DTO\GetAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/accounts/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get an account
     * @param \App\DTO\GetAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAccount(
        \App\DTO\GetAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAccountRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested account */
                $responseContent = new \App\DTO\Account();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Account not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get an account
     * @param \App\DTO\GetAccountParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Account
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAccountResult(
        \App\DTO\GetAccountParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Account
    {
        return $this->getSuccessfulContent(...$this->getAccount($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAllBankConnections
    /**
     * Get all bank connections
     * @param \App\DTO\GetAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAllBankConnectionsRaw(
        \App\DTO\GetAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/bankConnections', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get all bank connections
     * @param \App\DTO\GetAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAllBankConnections(
        \App\DTO\GetAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAllBankConnectionsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested bank connections */
                $responseContent = new \App\DTO\BankConnectionList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get all bank connections
     * @param \App\DTO\GetAllBankConnectionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\BankConnectionList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAllBankConnectionsResult(
        \App\DTO\GetAllBankConnectionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnectionList
    {
        return $this->getSuccessfulContent(...$this->getAllBankConnections($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAllCertificates
    /**
     * Get all TPP certificates
     * @param \App\DTO\GetAllCertificatesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAllCertificatesRaw(
        \App\DTO\GetAllCertificatesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/tppCertificates', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get all TPP certificates
     * @param \App\DTO\GetAllCertificatesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAllCertificates(
        \App\DTO\GetAllCertificatesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAllCertificatesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested TPP certificates */
                $responseContent = new \App\DTO\PageableTppCertificateList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get all TPP certificates
     * @param \App\DTO\GetAllCertificatesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableTppCertificateList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAllCertificatesResult(
        \App\DTO\GetAllCertificatesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableTppCertificateList
    {
        return $this->getSuccessfulContent(...$this->getAllCertificates($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAllTppCredentials
    /**
     * Get all TPP credentials
     * @param \App\DTO\GetAllTppCredentialsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAllTppCredentialsRaw(
        \App\DTO\GetAllTppCredentialsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/tppCredentials', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get all TPP credentials
     * @param \App\DTO\GetAllTppCredentialsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAllTppCredentials(
        \App\DTO\GetAllTppCredentialsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAllTppCredentialsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested TPP credentials */
                $responseContent = new \App\DTO\PageableTppCredentialResources();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get all TPP credentials
     * @param \App\DTO\GetAllTppCredentialsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableTppCredentialResources
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAllTppCredentialsResult(
        \App\DTO\GetAllTppCredentialsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableTppCredentialResources
    {
        return $this->getSuccessfulContent(...$this->getAllTppCredentials($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllAccounts
    /**
     * Get and search all accounts
     * @param \App\DTO\GetAndSearchAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllAccountsRaw(
        \App\DTO\GetAndSearchAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/accounts', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all accounts
     * @param \App\DTO\GetAndSearchAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllAccounts(
        \App\DTO\GetAndSearchAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllAccountsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested accounts */
                $responseContent = new \App\DTO\AccountList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all accounts
     * @param \App\DTO\GetAndSearchAllAccountsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\AccountList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllAccountsResult(
        \App\DTO\GetAndSearchAllAccountsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\AccountList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllAccounts($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllBanks
    /**
     * Get and search all banks
     * @param \App\DTO\GetAndSearchAllBanksParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllBanksRaw(
        \App\DTO\GetAndSearchAllBanksParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/banks', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all banks
     * @param \App\DTO\GetAndSearchAllBanksParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllBanks(
        \App\DTO\GetAndSearchAllBanksParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllBanksRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested banks */
                $responseContent = new \App\DTO\PageableBankList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all banks
     * @param \App\DTO\GetAndSearchAllBanksParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableBankList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllBanksResult(
        \App\DTO\GetAndSearchAllBanksParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableBankList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllBanks($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllCategories
    /**
     * Get and search all categories
     * @param \App\DTO\GetAndSearchAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllCategoriesRaw(
        \App\DTO\GetAndSearchAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/categories', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all categories
     * @param \App\DTO\GetAndSearchAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllCategories(
        \App\DTO\GetAndSearchAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllCategoriesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested categories */
                $responseContent = new \App\DTO\PageableCategoryList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all categories
     * @param \App\DTO\GetAndSearchAllCategoriesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableCategoryList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllCategoriesResult(
        \App\DTO\GetAndSearchAllCategoriesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableCategoryList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllCategories($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllLabels
    /**
     * Get and search all labels
     * @param \App\DTO\GetAndSearchAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllLabelsRaw(
        \App\DTO\GetAndSearchAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/labels', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all labels
     * @param \App\DTO\GetAndSearchAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllLabels(
        \App\DTO\GetAndSearchAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllLabelsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested labels */
                $responseContent = new \App\DTO\PageableLabelList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all labels
     * @param \App\DTO\GetAndSearchAllLabelsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableLabelList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllLabelsResult(
        \App\DTO\GetAndSearchAllLabelsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableLabelList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllLabels($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllNotificationRules
    /**
     * Get and search all notification rules
     * @param \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllNotificationRulesRaw(
        \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/notificationRules', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all notification rules
     * @param \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllNotificationRules(
        \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllNotificationRulesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested notification rules */
                $responseContent = new \App\DTO\NotificationRuleList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all notification rules
     * @param \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\NotificationRuleList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllNotificationRulesResult(
        \App\DTO\GetAndSearchAllNotificationRulesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\NotificationRuleList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllNotificationRules($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllSecurities
    /**
     * Get and search all securities
     * @param \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllSecuritiesRaw(
        \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/securities', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all securities
     * @param \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllSecurities(
        \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllSecuritiesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested securities */
                $responseContent = new \App\DTO\PageableSecurityList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all securities
     * @param \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableSecurityList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllSecuritiesResult(
        \App\DTO\GetAndSearchAllSecuritiesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableSecurityList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllSecurities($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchAllTransactions
    /**
     * Get and search all transactions
     * @param \App\DTO\GetAndSearchAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchAllTransactionsRaw(
        \App\DTO\GetAndSearchAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/transactions', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get and search all transactions
     * @param \App\DTO\GetAndSearchAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchAllTransactions(
        \App\DTO\GetAndSearchAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchAllTransactionsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested transactions */
                $responseContent = new \App\DTO\PageableTransactionList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get and search all transactions
     * @param \App\DTO\GetAndSearchAllTransactionsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableTransactionList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchAllTransactionsResult(
        \App\DTO\GetAndSearchAllTransactionsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableTransactionList
    {
        return $this->getSuccessfulContent(...$this->getAndSearchAllTransactions($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAndSearchTppAuthenticationGroups
    /**
     * Get all TPP Authentication Groups
     * @param \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAndSearchTppAuthenticationGroupsRaw(
        \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/tppCredentials/tppAuthenticationGroups', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get all TPP Authentication Groups
     * @param \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAndSearchTppAuthenticationGroups(
        \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAndSearchTppAuthenticationGroupsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested TPP authentication groups */
                $responseContent = new \App\DTO\PageableTppAuthenticationGroupResources();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get all TPP Authentication Groups
     * @param \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableTppAuthenticationGroupResources
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAndSearchTppAuthenticationGroupsResult(
        \App\DTO\GetAndSearchTppAuthenticationGroupsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableTppAuthenticationGroupResources
    {
        return $this->getSuccessfulContent(...$this->getAndSearchTppAuthenticationGroups($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getAuthorizedUser
    /**
     * Get the authorized user
     * @param \App\DTO\GetAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getAuthorizedUserRaw(
        \App\DTO\GetAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/users', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get the authorized user
     * @param \App\DTO\GetAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getAuthorizedUser(
        \App\DTO\GetAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getAuthorizedUserRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Authorized user's data */
                $responseContent = new \App\DTO\User();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get the authorized user
     * @param \App\DTO\GetAuthorizedUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\User
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getAuthorizedUserResult(
        \App\DTO\GetAuthorizedUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\User
    {
        return $this->getSuccessfulContent(...$this->getAuthorizedUser($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getBank
    /**
     * Get a bank
     * @param \App\DTO\GetBankParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getBankRaw(
        \App\DTO\GetBankParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/banks/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a bank
     * @param \App\DTO\GetBankParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getBank(
        \App\DTO\GetBankParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getBankRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested Bank */
                $responseContent = new \App\DTO\Bank();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a bank
     * @param \App\DTO\GetBankParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Bank
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getBankResult(
        \App\DTO\GetBankParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Bank
    {
        return $this->getSuccessfulContent(...$this->getBank($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getBankConnection
    /**
     * Get a bank connection
     * @param \App\DTO\GetBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getBankConnectionRaw(
        \App\DTO\GetBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/bankConnections/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a bank connection
     * @param \App\DTO\GetBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getBankConnection(
        \App\DTO\GetBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getBankConnectionRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested bank connection */
                $responseContent = new \App\DTO\BankConnection();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a bank connection
     * @param \App\DTO\GetBankConnectionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\BankConnection
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getBankConnectionResult(
        \App\DTO\GetBankConnectionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnection
    {
        return $this->getSuccessfulContent(...$this->getBankConnection($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getCashFlows
    /**
     * Get cash flows
     * @param \App\DTO\GetCashFlowsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getCashFlowsRaw(
        \App\DTO\GetCashFlowsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/categories/cashFlows', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get cash flows
     * @param \App\DTO\GetCashFlowsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getCashFlows(
        \App\DTO\GetCashFlowsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getCashFlowsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested cash flows */
                $responseContent = new \App\DTO\CashFlowList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get cash flows
     * @param \App\DTO\GetCashFlowsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\CashFlowList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getCashFlowsResult(
        \App\DTO\GetCashFlowsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\CashFlowList
    {
        return $this->getSuccessfulContent(...$this->getCashFlows($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getCategory
    /**
     * Get a category
     * @param \App\DTO\GetCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getCategoryRaw(
        \App\DTO\GetCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/categories/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a category
     * @param \App\DTO\GetCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getCategory(
        \App\DTO\GetCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getCategoryRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested category */
                $responseContent = new \App\DTO\Category();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a category
     * @param \App\DTO\GetCategoryParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Category
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getCategoryResult(
        \App\DTO\GetCategoryParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Category
    {
        return $this->getSuccessfulContent(...$this->getCategory($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getCertificate
    /**
     * Get a TPP certificate
     * @param \App\DTO\GetCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getCertificateRaw(
        \App\DTO\GetCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/tppCertificates/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a TPP certificate
     * @param \App\DTO\GetCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getCertificate(
        \App\DTO\GetCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getCertificateRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested TPP certificate */
                $responseContent = new \App\DTO\TppCertificate();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* TPP certificate not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a TPP certificate
     * @param \App\DTO\GetCertificateParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\TppCertificate
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getCertificateResult(
        \App\DTO\GetCertificateParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\TppCertificate
    {
        return $this->getSuccessfulContent(...$this->getCertificate($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getClientConfiguration
    /**
     * Get client configuration
     * @param \App\DTO\GetClientConfigurationParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getClientConfigurationRaw(
        \App\DTO\GetClientConfigurationParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/clientConfiguration', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get client configuration
     * @param \App\DTO\GetClientConfigurationParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getClientConfiguration(
        \App\DTO\GetClientConfigurationParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getClientConfigurationRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Current client configuration */
                $responseContent = new \App\DTO\ClientConfiguration();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get client configuration
     * @param \App\DTO\GetClientConfigurationParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\ClientConfiguration
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getClientConfigurationResult(
        \App\DTO\GetClientConfigurationParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\ClientConfiguration
    {
        return $this->getSuccessfulContent(...$this->getClientConfiguration($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getDailyBalances
    /**
     * Get daily balances
     * @param \App\DTO\GetDailyBalancesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getDailyBalancesRaw(
        \App\DTO\GetDailyBalancesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/accounts/dailyBalances', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get daily balances
     * @param \App\DTO\GetDailyBalancesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getDailyBalances(
        \App\DTO\GetDailyBalancesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getDailyBalancesRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested daily balances */
                $responseContent = new \App\DTO\DailyBalanceList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Account(s) not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* Invalid date range (e.g. endDate < startDate) */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get daily balances
     * @param \App\DTO\GetDailyBalancesParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\DailyBalanceList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getDailyBalancesResult(
        \App\DTO\GetDailyBalancesParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\DailyBalanceList
    {
        return $this->getSuccessfulContent(...$this->getDailyBalances($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getIbanRuleList
    /**
     * Get IBAN rules
     * @param \App\DTO\GetIbanRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getIbanRuleListRaw(
        \App\DTO\GetIbanRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/mandatorAdmin/ibanRules', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get IBAN rules
     * @param \App\DTO\GetIbanRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getIbanRuleList(
        \App\DTO\GetIbanRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getIbanRuleListRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested IBAN rules */
                $responseContent = new \App\DTO\PageableIbanRuleList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get IBAN rules
     * @param \App\DTO\GetIbanRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableIbanRuleList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getIbanRuleListResult(
        \App\DTO\GetIbanRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableIbanRuleList
    {
        return $this->getSuccessfulContent(...$this->getIbanRuleList($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getKeywordRuleList
    /**
     * Get keyword rules
     * @param \App\DTO\GetKeywordRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getKeywordRuleListRaw(
        \App\DTO\GetKeywordRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/mandatorAdmin/keywordRules', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get keyword rules
     * @param \App\DTO\GetKeywordRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getKeywordRuleList(
        \App\DTO\GetKeywordRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getKeywordRuleListRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested keyword rules */
                $responseContent = new \App\DTO\PageableKeywordRuleList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get keyword rules
     * @param \App\DTO\GetKeywordRuleListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableKeywordRuleList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getKeywordRuleListResult(
        \App\DTO\GetKeywordRuleListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableKeywordRuleList
    {
        return $this->getSuccessfulContent(...$this->getKeywordRuleList($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getLabel
    /**
     * Get a label
     * @param \App\DTO\GetLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getLabelRaw(
        \App\DTO\GetLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/labels/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a label
     * @param \App\DTO\GetLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getLabel(
        \App\DTO\GetLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getLabelRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested label */
                $responseContent = new \App\DTO\Label();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Label not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a label
     * @param \App\DTO\GetLabelParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Label
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getLabelResult(
        \App\DTO\GetLabelParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Label
    {
        return $this->getSuccessfulContent(...$this->getLabel($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getNotificationRule
    /**
     * Get a notification rule
     * @param \App\DTO\GetNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getNotificationRuleRaw(
        \App\DTO\GetNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/notificationRules/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a notification rule
     * @param \App\DTO\GetNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getNotificationRule(
        \App\DTO\GetNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getNotificationRuleRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested notification rule */
                $responseContent = new \App\DTO\NotificationRule();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Notification rule not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a notification rule
     * @param \App\DTO\GetNotificationRuleParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\NotificationRule
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getNotificationRuleResult(
        \App\DTO\GetNotificationRuleParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\NotificationRule
    {
        return $this->getSuccessfulContent(...$this->getNotificationRule($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getPayments
    /**
     * Get payments
     * @param \App\DTO\GetPaymentsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getPaymentsRaw(
        \App\DTO\GetPaymentsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/payments', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get payments
     * @param \App\DTO\GetPaymentsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getPayments(
        \App\DTO\GetPaymentsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getPaymentsRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested payments */
                $responseContent = new \App\DTO\PageablePaymentResources();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Authentication required */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* Unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get payments
     * @param \App\DTO\GetPaymentsParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageablePaymentResources
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getPaymentsResult(
        \App\DTO\GetPaymentsParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageablePaymentResources
    {
        return $this->getSuccessfulContent(...$this->getPayments($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getSecurity
    /**
     * Get a security
     * @param \App\DTO\GetSecurityParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getSecurityRaw(
        \App\DTO\GetSecurityParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/securities/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a security
     * @param \App\DTO\GetSecurityParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getSecurity(
        \App\DTO\GetSecurityParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getSecurityRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested security */
                $responseContent = new \App\DTO\Security();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Security not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a security
     * @param \App\DTO\GetSecurityParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Security
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getSecurityResult(
        \App\DTO\GetSecurityParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Security
    {
        return $this->getSuccessfulContent(...$this->getSecurity($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getStandingOrders
    /**
     * Get standing orders
     * @param \App\DTO\GetStandingOrdersParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getStandingOrdersRaw(
        \App\DTO\GetStandingOrdersParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/standingOrders', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get standing orders
     * @param \App\DTO\GetStandingOrdersParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getStandingOrders(
        \App\DTO\GetStandingOrdersParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getStandingOrdersRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* List of requested standing orders */
                $responseContent = new \App\DTO\PageableStandingOrderResources();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Authentication required */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* Unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get standing orders
     * @param \App\DTO\GetStandingOrdersParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableStandingOrderResources
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getStandingOrdersResult(
        \App\DTO\GetStandingOrdersParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableStandingOrderResources
    {
        return $this->getSuccessfulContent(...$this->getStandingOrders($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getToken
    /**
     * Get tokens
     * @param \App\DTO\GetTokenParameterData $parameters
     * @param \App\DTO\GetTokenParams $requestContent
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getTokenRaw(
        \App\DTO\GetTokenParameterData $parameters,
        \App\DTO\GetTokenParams $requestContent,
        string $requestMediaType = 'application/x-www-form-urlencoded',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/oauth/token', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get tokens
     * @param \App\DTO\GetTokenParameterData $parameters
     * @param \App\DTO\GetTokenParams $requestContent
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getToken(
        \App\DTO\GetTokenParameterData $parameters,
        \App\DTO\GetTokenParams $requestContent,
        string $requestMediaType = 'application/x-www-form-urlencoded',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getTokenRaw($parameters, $requestContent, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested token */
                $responseContent = new \App\DTO\AccessToken();
                break;
            case 400:
                /* Bad user credentials, or invalid refresh_token, or unsupported grant_type */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Bad client credentials */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* User is locked */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get tokens
     * @param \App\DTO\GetTokenParameterData $parameters
     * @param \App\DTO\GetTokenParams $requestContent
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\AccessToken
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getTokenResult(
        \App\DTO\GetTokenParameterData $parameters,
        \App\DTO\GetTokenParams $requestContent,
        string $requestMediaType = 'application/x-www-form-urlencoded',
        string $responseMediaType = 'application/json'
    ): \App\DTO\AccessToken
    {
        return $this->getSuccessfulContent(...$this->getToken($parameters, $requestContent, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region getTppCredential
    /**
     * Get a set of TPP credentials
     * @param \App\DTO\GetTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getTppCredentialRaw(
        \App\DTO\GetTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/tppCredentials/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a set of TPP credentials
     * @param \App\DTO\GetTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getTppCredential(
        \App\DTO\GetTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getTppCredentialRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested TPP credentials */
                $responseContent = new \App\DTO\TppCredentials();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* TPP credentials not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a set of TPP credentials
     * @param \App\DTO\GetTppCredentialParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\TppCredentials
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getTppCredentialResult(
        \App\DTO\GetTppCredentialParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\TppCredentials
    {
        return $this->getSuccessfulContent(...$this->getTppCredential($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getTransaction
    /**
     * Get a transaction
     * @param \App\DTO\GetTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getTransactionRaw(
        \App\DTO\GetTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/transactions/{id}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a transaction
     * @param \App\DTO\GetTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getTransaction(
        \App\DTO\GetTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getTransactionRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested transaction */
                $responseContent = new \App\DTO\Transaction();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Transaction not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a transaction
     * @param \App\DTO\GetTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Transaction
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getTransactionResult(
        \App\DTO\GetTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Transaction
    {
        return $this->getSuccessfulContent(...$this->getTransaction($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getUserList
    /**
     * Get user list
     * @param \App\DTO\GetUserListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getUserListRaw(
        \App\DTO\GetUserListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/mandatorAdmin/getUserList', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get user list
     * @param \App\DTO\GetUserListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getUserList(
        \App\DTO\GetUserListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getUserListRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Requested users list */
                $responseContent = new \App\DTO\PageableUserInfoList();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get user list
     * @param \App\DTO\GetUserListParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\PageableUserInfoList
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getUserListResult(
        \App\DTO\GetUserListParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\PageableUserInfoList
    {
        return $this->getSuccessfulContent(...$this->getUserList($parameters, $security, $responseMediaType));
    }
    //endregion

    //region getVerificationStatus
    /**
     * Get a user's verification status
     * @param \App\DTO\GetVerificationStatusParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function getVerificationStatusRaw(
        \App\DTO\GetVerificationStatusParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('GET', '/api/v1/users/verificationStatus', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Get a user's verification status
     * @param \App\DTO\GetVerificationStatusParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function getVerificationStatus(
        \App\DTO\GetVerificationStatusParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->getVerificationStatusRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* User's verification status */
                $responseContent = new \App\DTO\VerificationStatusResource();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* User not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Get a user's verification status
     * @param \App\DTO\GetVerificationStatusParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\VerificationStatusResource
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function getVerificationStatusResult(
        \App\DTO\GetVerificationStatusParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\VerificationStatusResource
    {
        return $this->getSuccessfulContent(...$this->getVerificationStatus($parameters, $security, $responseMediaType));
    }
    //endregion

    //region importBankConnection
    /**
     * Import a new bank connection
     * @param \App\DTO\ImportBankConnectionParameterData $parameters
     * @param \App\DTO\ImportBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function importBankConnectionRaw(
        \App\DTO\ImportBankConnectionParameterData $parameters,
        \App\DTO\ImportBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/bankConnections/import', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Import a new bank connection
     * @param \App\DTO\ImportBankConnectionParameterData $parameters
     * @param \App\DTO\ImportBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function importBankConnection(
        \App\DTO\ImportBankConnectionParameterData $parameters,
        \App\DTO\ImportBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->importBankConnectionRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 201:
                /* Imported bank connection */
                $responseContent = new \App\DTO\BankConnection();
                break;
            case 400:
                /* Bad Request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* UNKNOWN_ENTITY if the specified bank identifier does not exist;<br/>ENTITY_EXISTS if such a bank connection already exists;<br/>ILLEGAL_FIELD_VALUE:<br/> - if the given credentials do not contain a mandatory login field;<br/> - if 'accountReferences' are not given, but the bank connection has the DETAILED_CONSENT property set, or the given 'accountReferences' contain a wrong IBAN;<br/> - if 'redirectUrl' is not given, but the bank connection has the REDIRECT_APPROACH property set;<br/>ILLEGAL_ENTITY_STATE:<br/> - if finAPI supports only web scraping for the bank, but web scraping is disabled for the client;<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>BANK_SERVER_REJECTION if the bank server responded with an error message when finAPI tried to retrieve the user's data. The response's error message typically contains useful information from the bank (like that the given login credentials were not correct or that the connection is not activated for online banking) and may be forwarded to the user;<br/>NO_ACCOUNTS_FOR_TYPE_LIST if none of the accounts that the bank returned matched the given account types (or if the bank didn’t return any accounts at all);<br/>NO_EXISTING_CHALLENGE in case the 'multiStepAuthentication.challengeResponse' field was set, but there is no pending challenge;<br/> */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 451:
                /* THIS HTTP RESPONSE CODE IS DEPRECATED AND WILL BE REMOVED.<br/>Instead please refer to our Web Form offering <a href=\"?product=web_form_2.0\">here</a>.<br/><br/>In case the user must enter credentials within finAPI's Web Form. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 501:
                /* This bank is currently not supported by finAPI */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 510:
                /* In case the bank requires an additional authentication by the user. The error's 'multiStepAuthentication' field contains further instructions. The actual MSA flow depends on the bank and may contain following statuses:<br/><br/>TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the 'twoStepProcedureId' field.<br/><br/>CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the 'challengeResponse' field.<br/><br/>REDIRECT_REQUIRED means that the user must be redirected to the bank's website, where the authentication can be finished.<br/><br/>DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the 'decoupledCallback' field must be set to true to complete the authentication.<br/><br/>DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the 'decoupledCallback' field set to 'true'. Once the decoupled authentication is completed by the user, the service returns a successful response. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Import a new bank connection
     * @param \App\DTO\ImportBankConnectionParameterData $parameters
     * @param \App\DTO\ImportBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\BankConnection
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function importBankConnectionResult(
        \App\DTO\ImportBankConnectionParameterData $parameters,
        \App\DTO\ImportBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnection
    {
        return $this->getSuccessfulContent(...$this->importBankConnection($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region mockBatchUpdate
    /**
     * Mock batch update
     * @param \App\DTO\MockBatchUpdateParameterData $parameters
     * @param \App\DTO\MockBatchUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function mockBatchUpdateRaw(
        \App\DTO\MockBatchUpdateParameterData $parameters,
        \App\DTO\MockBatchUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/tests/mockBatchUpdate', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Mock batch update
     * @param \App\DTO\MockBatchUpdateParameterData $parameters
     * @param \App\DTO\MockBatchUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function mockBatchUpdate(
        \App\DTO\MockBatchUpdateParameterData $parameters,
        \App\DTO\MockBatchUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->mockBatchUpdateRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Mock batch update has been started (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection or account not found; or account does not belong to the bank connection it is nested in. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* At least one of the given account identifiers refers to a security account; or at least one of the given bank connections is currently locked due to another running update; or not all given bank connections have a PIN stored; or the number of transactions exceeds the limit of 1000.<br/>ILLEGAL_FIELD_VALUE if the given transaction type is invalid. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Mock batch update
     * @param \App\DTO\MockBatchUpdateParameterData $parameters
     * @param \App\DTO\MockBatchUpdateParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function mockBatchUpdateResult(
        \App\DTO\MockBatchUpdateParameterData $parameters,
        \App\DTO\MockBatchUpdateParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->mockBatchUpdate($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region removeInterface
    /**
     * Remove an interface
     * @param \App\DTO\RemoveInterfaceParameterData $parameters
     * @param \App\DTO\RemoveInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function removeInterfaceRaw(
        \App\DTO\RemoveInterfaceParameterData $parameters,
        \App\DTO\RemoveInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/bankConnections/removeInterface', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Remove an interface
     * @param \App\DTO\RemoveInterfaceParameterData $parameters
     * @param \App\DTO\RemoveInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function removeInterface(
        \App\DTO\RemoveInterfaceParameterData $parameters,
        \App\DTO\RemoveInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->removeInterfaceRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Bank connection interface removed (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection interface not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Bank connection interface cannot be removed at the moment as it is currently being imported or updated (either by the user or by finAPI's automatic batch update). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Remove an interface
     * @param \App\DTO\RemoveInterfaceParameterData $parameters
     * @param \App\DTO\RemoveInterfaceParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function removeInterfaceResult(
        \App\DTO\RemoveInterfaceParameterData $parameters,
        \App\DTO\RemoveInterfaceParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->removeInterface($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region requestPasswordChange
    /**
     * Request password change
     * @param \App\DTO\RequestPasswordChangeParameterData $parameters
     * @param \App\DTO\RequestPasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function requestPasswordChangeRaw(
        \App\DTO\RequestPasswordChangeParameterData $parameters,
        \App\DTO\RequestPasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/users/requestPasswordChange', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Request password change
     * @param \App\DTO\RequestPasswordChangeParameterData $parameters
     * @param \App\DTO\RequestPasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function requestPasswordChange(
        \App\DTO\RequestPasswordChangeParameterData $parameters,
        \App\DTO\RequestPasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->requestPasswordChangeRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Details of change password request */
                $responseContent = new \App\DTO\PasswordChangingResource();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* User not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* User is not verified */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Request password change
     * @param \App\DTO\RequestPasswordChangeParameterData $parameters
     * @param \App\DTO\RequestPasswordChangeParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\PasswordChangingResource
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function requestPasswordChangeResult(
        \App\DTO\RequestPasswordChangeParameterData $parameters,
        \App\DTO\RequestPasswordChangeParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\PasswordChangingResource
    {
        return $this->getSuccessfulContent(...$this->requestPasswordChange($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region restoreTransaction
    /**
     * Restore a transaction
     * @param \App\DTO\RestoreTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function restoreTransactionRaw(
        \App\DTO\RestoreTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/transactions/{id}/restore', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Restore a transaction
     * @param \App\DTO\RestoreTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function restoreTransaction(
        \App\DTO\RestoreTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->restoreTransactionRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Restored transaction */
                $responseContent = new \App\DTO\Transaction();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Transaction not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* The request transaction is a sub-transaction and can not be restored. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Restore a transaction
     * @param \App\DTO\RestoreTransactionParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return \App\DTO\Transaction
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function restoreTransactionResult(
        \App\DTO\RestoreTransactionParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): \App\DTO\Transaction
    {
        return $this->getSuccessfulContent(...$this->restoreTransaction($parameters, $security, $responseMediaType));
    }
    //endregion

    //region revokeToken
    /**
     * Revoke a token
     * @param \App\DTO\RevokeTokenParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function revokeTokenRaw(
        \App\DTO\RevokeTokenParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/oauth/revoke', [], $this->getQueryParameters($parameters));
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Revoke a token
     * @param \App\DTO\RevokeTokenParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function revokeToken(
        \App\DTO\RevokeTokenParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->revokeTokenRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Token was invalidated successfully or token was invalid (empty response body) */
                break;
            case 400:
                /* The service does not support the revocation of the presented token type. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Revoke a token
     * @param \App\DTO\RevokeTokenParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function revokeTokenResult(
        \App\DTO\RevokeTokenParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->revokeToken($parameters, $security, $responseMediaType));
    }
    //endregion

    //region splitTransaction
    /**
     * Split a transaction
     * @param \App\DTO\SplitTransactionParameterData $parameters
     * @param \App\DTO\SplitTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function splitTransactionRaw(
        \App\DTO\SplitTransactionParameterData $parameters,
        \App\DTO\SplitTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/transactions/{id}/split', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Split a transaction
     * @param \App\DTO\SplitTransactionParameterData $parameters
     * @param \App\DTO\SplitTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function splitTransaction(
        \App\DTO\SplitTransactionParameterData $parameters,
        \App\DTO\SplitTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->splitTransactionRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Split transaction */
                $responseContent = new \App\DTO\Transaction();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Transaction, category or labels not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_ENTITY_STATE if the transaction you are trying to split is a sub-transaction; ILLEGAL_FIELD_VALUE if there is less than two sub-transactions specified, or the specified sub-transactions' amounts do not add up to the original transaction's amount */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Split a transaction
     * @param \App\DTO\SplitTransactionParameterData $parameters
     * @param \App\DTO\SplitTransactionsParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Transaction
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function splitTransactionResult(
        \App\DTO\SplitTransactionParameterData $parameters,
        \App\DTO\SplitTransactionsParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Transaction
    {
        return $this->getSuccessfulContent(...$this->splitTransaction($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region submitPayment
    /**
     * Submit payment
     * @param \App\DTO\SubmitPaymentParameterData $parameters
     * @param \App\DTO\SubmitPaymentParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function submitPaymentRaw(
        \App\DTO\SubmitPaymentParameterData $parameters,
        \App\DTO\SubmitPaymentParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/payments/submit', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Submit payment
     * @param \App\DTO\SubmitPaymentParameterData $parameters
     * @param \App\DTO\SubmitPaymentParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function submitPayment(
        \App\DTO\SubmitPaymentParameterData $parameters,
        \App\DTO\SubmitPaymentParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->submitPaymentRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Submitted payment with updated status */
                $responseContent = new \App\DTO\Payment();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given payment not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_ENTITY_STATE:<br/> - if finAPI supports only web scraping for the bank, but web scraping is disabled for the client;<br/> - if not all login fields required by the bank connection interface are provided;<br/> - if the given interface doesn't exist for the account or has deprecated status;<br/>ILLEGAL_FIELD_VALUE:<br/> - if 'redirectUrl' is not given, but the bank connection's interface has the REDIRECT_APPROACH property set;<br/> - if 'redirectUrl' is given, but the bank connection's interface doesn't have the REDIRECT_APPROACH property set or the Web Form flow is used;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>UNSUPPORTED_ORDER:<br/> - if the given interface doesn't have the required capabilities to submit the payment; or if the payment relates to a bank that is unknown or not available to you.<br/>UNSUPPORTED_FEATURE:<br/> - if the bank rejects the payment because it requires a feature that the bank does not support (e.g. FUTURE_DATED_PAYMENT);<br/>BANK_SERVER_REJECTION:<br/>- if the bank rejects the payment for an unexpected/unknown reason;<br/>NO_EXISTING_CHALLENGE in case the 'multiStepAuthentication.challengeResponse' field was set, but there is no pending challenge;<br/> */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 451:
                /* THIS HTTP RESPONSE CODE IS DEPRECATED AND WILL BE REMOVED.<br/>Instead please refer to our Web Form offering <a href=\"?product=web_form_2.0\">here</a>.<br/><br/>In case the user must enter credentials within finAPI's Web Form. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 501:
                /* The bank associated with the payment is currently not supported by finAPI */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 510:
                /* In case the bank requires an additional authentication by the user. The error's 'multiStepAuthentication' field contains further instructions. The actual MSA flow depends on the bank and may contain following statuses:<br/><br/>TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the 'twoStepProcedureId' field.<br/><br/>CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the 'challengeResponse' field.<br/><br/>REDIRECT_REQUIRED means that the user must be redirected to the bank's website, where the authentication can be finished.<br/><br/>DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the 'decoupledCallback' field must be set to true to complete the authentication.<br/><br/>DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the 'decoupledCallback' field set to 'true'. Once the decoupled authentication is completed by the user, the service returns a successful response. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Submit payment
     * @param \App\DTO\SubmitPaymentParameterData $parameters
     * @param \App\DTO\SubmitPaymentParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\Payment
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function submitPaymentResult(
        \App\DTO\SubmitPaymentParameterData $parameters,
        \App\DTO\SubmitPaymentParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\Payment
    {
        return $this->getSuccessfulContent(...$this->submitPayment($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region submitStandingOrder
    /**
     * Submit standing order
     * @param \App\DTO\SubmitStandingOrderParameterData $parameters
     * @param \App\DTO\SubmitStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function submitStandingOrderRaw(
        \App\DTO\SubmitStandingOrderParameterData $parameters,
        \App\DTO\SubmitStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/standingOrders/submit', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Submit standing order
     * @param \App\DTO\SubmitStandingOrderParameterData $parameters
     * @param \App\DTO\SubmitStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function submitStandingOrder(
        \App\DTO\SubmitStandingOrderParameterData $parameters,
        \App\DTO\SubmitStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->submitStandingOrderRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Submitted standing order with updated status */
                $responseContent = new \App\DTO\StandingOrder();
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given standing order not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* ILLEGAL_ENTITY_STATE:<br/> - if finAPI supports only web scraping for the bank, but web scraping is disabled for the client;<br/> - if not all login fields required by the bank connection interface are provided;<br/> - if the given interface doesn't exist for the account or has deprecated status;<br/>ILLEGAL_FIELD_VALUE:<br/> - if 'redirectUrl' is not given, but the bank connection's interface has the REDIRECT_APPROACH property set;<br/> - if 'redirectUrl' is given, but the bank connection's interface doesn't have the REDIRECT_APPROACH property set or the Web Form flow is used;<br/>ILLEGAL_ENTITY_STATE:<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/> - if the standing order is in a status that does not support the given request;<br/>UNSUPPORTED_ORDER:<br/> - if the given interface doesn't have the required capabilities to submit the standing order; or if the standing order relates to a bank that is unknown or not available to you.<br/>UNSUPPORTED_FEATURE:<br/> - if the bank rejects the standing orders because it requires a feature that the bank does not support;<br/>BANK_SERVER_REJECTION:<br/>- if the bank rejects the standing order for an unexpected/unknown reason;<br/>NO_EXISTING_CHALLENGE in case the 'multiStepAuthentication.challengeResponse' field was set, but there is no pending challenge;<br/> */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 501:
                /* The bank associated with the standing order is currently not supported by finAPI */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 510:
                /* In case the bank requires an additional authentication by the user. The error's 'multiStepAuthentication' field contains further instructions. The actual MSA flow depends on the bank and may contain following statuses:<br/><br/>TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the 'twoStepProcedureId' field.<br/><br/>CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the 'challengeResponse' field.<br/><br/>REDIRECT_REQUIRED means that the user must be redirected to the bank's website, where the authentication can be finished.<br/><br/>DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the 'decoupledCallback' field must be set to true to complete the authentication.<br/><br/>DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the 'decoupledCallback' field set to 'true'. Once the decoupled authentication is completed by the user, the service returns a successful response. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Submit standing order
     * @param \App\DTO\SubmitStandingOrderParameterData $parameters
     * @param \App\DTO\SubmitStandingOrderParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\StandingOrder
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function submitStandingOrderResult(
        \App\DTO\SubmitStandingOrderParameterData $parameters,
        \App\DTO\SubmitStandingOrderParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\StandingOrder
    {
        return $this->getSuccessfulContent(...$this->submitStandingOrder($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region trainCategorization
    /**
     * Train categorization
     * @param \App\DTO\TrainCategorizationParameterData $parameters
     * @param \App\DTO\TrainCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function trainCategorizationRaw(
        \App\DTO\TrainCategorizationParameterData $parameters,
        \App\DTO\TrainCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/categories/trainCategorization', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Train categorization
     * @param \App\DTO\TrainCategorizationParameterData $parameters
     * @param \App\DTO\TrainCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function trainCategorization(
        \App\DTO\TrainCategorizationParameterData $parameters,
        \App\DTO\TrainCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->trainCategorizationRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Categorization rules updated (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Category not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* The number of transactions exceeds the limit of 100. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Train categorization
     * @param \App\DTO\TrainCategorizationParameterData $parameters
     * @param \App\DTO\TrainCategorizationData $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function trainCategorizationResult(
        \App\DTO\TrainCategorizationParameterData $parameters,
        \App\DTO\TrainCategorizationData $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->trainCategorization($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region triggerCategorization
    /**
     * Trigger categorization
     * @param \App\DTO\TriggerCategorizationParameterData $parameters
     * @param \App\DTO\TriggerCategorizationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function triggerCategorizationRaw(
        \App\DTO\TriggerCategorizationParameterData $parameters,
        \App\DTO\TriggerCategorizationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/transactions/triggerCategorization', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Trigger categorization
     * @param \App\DTO\TriggerCategorizationParameterData $parameters
     * @param \App\DTO\TriggerCategorizationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function triggerCategorization(
        \App\DTO\TriggerCategorizationParameterData $parameters,
        \App\DTO\TriggerCategorizationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->triggerCategorizationRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Categorizations have been scheduled (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Given bank connection(s) not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* At least one of the target bank connections is currently locked, or there are no bank connections to trigger categorization for */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Trigger categorization
     * @param \App\DTO\TriggerCategorizationParameterData $parameters
     * @param \App\DTO\TriggerCategorizationParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function triggerCategorizationResult(
        \App\DTO\TriggerCategorizationParameterData $parameters,
        \App\DTO\TriggerCategorizationParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->triggerCategorization($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region updateBankConnection
    /**
     * Update a bank connection
     * @param \App\DTO\UpdateBankConnectionParameterData $parameters
     * @param \App\DTO\UpdateBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function updateBankConnectionRaw(
        \App\DTO\UpdateBankConnectionParameterData $parameters,
        \App\DTO\UpdateBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/bankConnections/update', [], []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addBody($request, $requestMediaType, $requestContent);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Update a bank connection
     * @param \App\DTO\UpdateBankConnectionParameterData $parameters
     * @param \App\DTO\UpdateBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function updateBankConnection(
        \App\DTO\UpdateBankConnectionParameterData $parameters,
        \App\DTO\UpdateBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->updateBankConnectionRaw($parameters, $requestContent, $security, $requestMediaType, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* Bank connection that the update was triggered for */
                $responseContent = new \App\DTO\BankConnection();
                break;
            case 400:
                /* Bad Request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* Bank connection not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* MISSING_FIELD if the credentials (stored in finAPI and provided in the request) do not contain at least one non-secret and one secret field;<br/>ILLEGAL_FIELD_VALUE:<br/> - if any of the specified credentials contain illegal characters;<br/> - if you tried to update a bank connection with an invalid credential label;<br/> - if the bank connection's credentials were tried to be changed, but the new credentials are equal to the credentials of another existing bank connection of the same bank;<br/> - if the given 'accountReferences' contain a wrong IBAN;<br/> - if 'redirectUrl' is not given, but the bank connection has the REDIRECT_APPROACH property set;<br/>ILLEGAL_ENTITY_STATE:<br/> - if finAPI supports only web scraping for the bank, but web scraping is disabled for the client;<br/> - if the mandator is not configured correctly to use this service. Please contact our support;<br/>BANK_SERVER_REJECTION if the bank server responded with an error message when finAPI tried to  retrieve the user's data. The response's error message typically contains useful information from the bank (like that the given login credentials were not correct or that the connection is not activated for online banking) and may be forwarded to the user;<br/>NO_EXISTING_CHALLENGE in case the 'multiStepAuthentication.challengeResponse' field was set, but there is no pending challenge;<br/>INVALID_CONSENT if access data of the bank connection has already expired. Please retry the call to request a new consent. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 423:
                /* Bank connection cannot get updated at the moment as it is currently being imported or updated (either by the user or by finAPI's automatic batch update). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 451:
                /* THIS HTTP RESPONSE CODE IS DEPRECATED AND WILL BE REMOVED.<br/>Instead please refer to our Web Form offering <a href=\"?product=web_form_2.0\">here</a>.<br/><br/>In case the user must enter credentials within finAPI's Web Form. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 501:
                /* This bank is currently not supported by finAPI */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 510:
                /* In case the bank requires an additional authentication by the user. The error's 'multiStepAuthentication' field contains further instructions. The actual MSA flow depends on the bank and may contain following statuses:<br/><br/>TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the 'twoStepProcedureId' field.<br/><br/>CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the 'challengeResponse' field.<br/><br/>REDIRECT_REQUIRED means that the user must be redirected to the bank's website, where the authentication can be finished.<br/><br/>DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the 'decoupledCallback' field must be set to true to complete the authentication.<br/><br/>DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the 'decoupledCallback' field set to 'true'. Once the decoupled authentication is completed by the user, the service returns a successful response. */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Update a bank connection
     * @param \App\DTO\UpdateBankConnectionParameterData $parameters
     * @param \App\DTO\UpdateBankConnectionParams $requestContent
     * @param iterable|string[][] $security
     * @param string $requestMediaType
     * @param string $responseMediaType
     * @return \App\DTO\BankConnection
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function updateBankConnectionResult(
        \App\DTO\UpdateBankConnectionParameterData $parameters,
        \App\DTO\UpdateBankConnectionParams $requestContent,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $requestMediaType = 'application/json',
        string $responseMediaType = 'application/json'
    ): \App\DTO\BankConnection
    {
        return $this->getSuccessfulContent(...$this->updateBankConnection($parameters, $requestContent, $security, $requestMediaType, $responseMediaType));
    }
    //endregion

    //region verifyUser
    /**
     * Verify a user
     * @param \App\DTO\VerifyUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     */
    public function verifyUserRaw(
        \App\DTO\VerifyUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): ResponseInterface
    {
        $request = $this->createRequest('POST', '/api/v1/users/verify/{userId}', $this->getPathParameters($parameters), []);
        $request = $this->addCustomHeaders($request, $parameters);
        $request = $this->addAcceptHeader($request, $responseMediaType);
        $request = $this->addSecurity($request, $security);
        return $this->httpClient->sendRequest($request);
    }

    /**
     * Verify a user
     * @param \App\DTO\VerifyUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return array
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     */
    public function verifyUser(
        \App\DTO\VerifyUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    ): array
    {
        $response = $this->verifyUserRaw($parameters, $security, $responseMediaType);
        $responseContent = null;
        switch ($response->getStatusCode())
        {
            case 200:
                /* User verified (empty response body) */
                break;
            case 400:
                /* Bad request */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 401:
                /* Not authenticated or invalid access_token */
                $responseContent = new \App\DTO\BadCredentialsError();
                break;
            case 403:
                /* Incorrect authorization role or you are not allowed to call this service for other reasons (see error message). */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 404:
                /* User not found */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 422:
                /* User already verified */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
            case 500:
                /* An unexpected error occurred */
                $responseContent = new \App\DTO\ErrorMessage();
                break;
        }
        $this->parseBody($response, $responseContent);
        return [$responseContent, $response->getHeaders(), $response->getStatusCode(), $response->getReasonPhrase()];
    }

    /**
     * Verify a user
     * @param \App\DTO\VerifyUserParameterData $parameters
     * @param iterable|string[][] $security
     * @param string $responseMediaType
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws DT\Exception\InvalidData
     * @throws OAGAC\Exception\InvalidResponseBodySchema
     * @throws OAGAC\Exception\UnsuccessfulResponse
     */
    public function verifyUserResult(
        \App\DTO\VerifyUserParameterData $parameters,
        iterable $security = ['finapi_auth' => ['all', ]],
        string $responseMediaType = 'application/json'
    )
    {
        return $this->getSuccessfulContent(...$this->verifyUser($parameters, $security, $responseMediaType));
    }
    //endregion
}

