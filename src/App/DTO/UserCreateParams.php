<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * User details
 */
class UserCreateParams
{
    /**
     * User&#39;s identifier. Max length is 36 symbols. Only the following symbols are allowed: 0-9, A-Z, a-z, -, _, ., +, @. If not specified, then a unique random value will be generated.
     * @DTA\Data(field="id", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[a-zA-Z0-9\\-_\\.\\+@]*/"})
     * @var string|null
     */
    public $id;

    /**
     * User&#39;s password. Minimum length is 6, and maximum length is 128. If not specified, then a unique random value will be generated.
     * @DTA\Data(field="password", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $password;

    /**
     * User&#39;s email address. Maximum length is 320.
     * @DTA\Data(field="email", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $email;

    /**
     * User&#39;s phone number. Maximum length is 50.
     * @DTA\Data(field="phone", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $phone;

    /**
     * Whether the user&#39;s bank connections will get updated in the course of finAPI&#39;s automatic batch update. Note that the automatic batch update will only update bank connections where all of the following applies:&lt;br&gt;&lt;br&gt; - a valid consent exists OR the PIN is stored in finAPI for the bank connection, and the related bank does not have volatile PINs (see the &#39;isVolatile&#39; flag of the &#39;loginCredentials&#39;)&lt;br/&gt; - the user has accepted the latest Terms and Conditions (this only applies to users whose mandator doesn&#39;t have an AIS license)&lt;br&gt; - the bank connection interface flag &#39;userActionRequired&#39; has to be false&lt;br&gt; - the previous update using the stored credentials did not fail due to the credentials being incorrect (or there was no previous update with the stored credentials)&lt;br&gt; - the bank that the bank connection relates to is included in the automatic batch update (please contact your Sys-Admin for details about the batch update configuration)&lt;br&gt;- at least one of the bank&#39;s supported data sources can be used by finAPI for your client (i.e.: if a bank supports only web scraping, but web scraping is disabled for your client, then bank connections of that bank will not get updated by the automatic batch update)&lt;br&gt;&lt;br&gt;Also note that the automatic batch update must generally be enabled for your client for this field to have any effect.&lt;br/&gt;&lt;br/&gt;WARNING: The automatic update will always download transactions and security positions for any account that it updates, even if the account was previously imported or updated with &#39;skipPositionsDownload&#39; &#x3D; true.&lt;br/&gt;&lt;br/&gt;Default value is false.
     * @DTA\Data(field="isAutoUpdateEnabled", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_auto_update_enabled;

}
