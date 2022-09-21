<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for change client credentials parameters
 */
class ChangeClientCredentialsParams
{
    /**
     * client_id of the client that you want to change the secret for
     * @DTA\Data(field="clientId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $client_id;

    /**
     * Old (&#x3D;current) client_secret
     * @DTA\Data(field="oldClientSecret")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $old_client_secret;

    /**
     * New client_secret. Required length is 36. Allowed symbols: Digits (0 through 9), lower-case and upper-case letters (A through Z), and the dash symbol (\&quot;-\&quot;).
     * @DTA\Data(field="newClientSecret")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[a-zA-Z0-9\\-]*/"})
     * @var string|null
     */
    public $new_client_secret;

}
