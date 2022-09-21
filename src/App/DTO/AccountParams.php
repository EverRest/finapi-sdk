<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for an account&#39;s name, type and &#39;isNew&#39; flag&#39;.
 */
class AccountParams
{
    /**
     * Account name. Maximum length is 512.
     * @DTA\Data(field="accountName", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $account_name;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountType&lt;br/&gt; An account type.&lt;br/&gt;&lt;br/&gt;Checking,&lt;br/&gt;Savings,&lt;br/&gt;CreditCard,&lt;br/&gt;Security,&lt;br/&gt;Loan,&lt;br/&gt;Membership,&lt;br/&gt;Bausparen&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="accountType", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":AccountType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":AccountType::class})
     * @var AccountType|null
     */
    public $account_type;

    /**
     * Whether this account should be flagged as &#39;new&#39; or not. Any newly imported account will have this flag initially set to true, and remain so until you set it to false (see PATCH /accounts/&lt;id&gt;). How you use this field is up to your interpretation, however it is recommended to set the flag to false for all accounts right after the initial import of the bank connection. This way, you will be able to recognize accounts that get newly imported during a later update of the bank connection, by checking for any accounts with the flag set to &#39;true&#39; after every update of the bank connection.
     * @DTA\Data(field="isNew", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

}
