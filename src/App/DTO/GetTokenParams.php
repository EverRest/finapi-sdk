<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 */
class GetTokenParams
{
    /**
     * Determines the required type of authorization:password - authorize a user; client_credentials - authorize a client;refresh_token - refresh a user&#39;s access_token.
     * @DTA\Data(field="grant_type")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $grant_type;

    /**
     * Client identifier
     * @DTA\Data(field="client_id")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $client_id;

    /**
     * Client secret
     * @DTA\Data(field="client_secret")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $client_secret;

    /**
     * Refresh token. Required for grant_type&#x3D;refresh_token only.
     * @DTA\Data(field="refresh_token", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $refresh_token;

    /**
     * User identifier. Required for grant_type&#x3D;password only.
     * @DTA\Data(field="username", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $username;

    /**
     * User password. Required for grant_type&#x3D;password only.
     * @DTA\Data(field="password", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $password;

}
