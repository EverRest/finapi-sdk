<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * OAuth access token data
 */
class AccessToken
{
    /**
     * Access token. Token has a length of up to 128 characters.
     * @DTA\Data(field="access_token")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $access_token;

    /**
     * Refresh token. Only set in case of grant_type&#x3D;&#39;password&#39;. Token has a length of up to 128 characters.
     * @DTA\Data(field="refresh_token", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $refresh_token;

    /**
     * Token type (it&#39;s always &#39;bearer&#39;)
     * @DTA\Data(field="token_type")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $token_type;

    /**
     * Expiration time in seconds. A value of 0 means that the token never expires (unless it is explicitly invalidated, e.g. by revocation, or when a user gets locked).
     * @DTA\Data(field="expires_in")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $expires_in;

    /**
     * Requested scopes (it&#39;s always &#39;all&#39;)
     * @DTA\Data(field="scope")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $scope;

}
