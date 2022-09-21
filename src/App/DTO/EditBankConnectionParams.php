<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for bank connection edit params
 */
class EditBankConnectionParams
{
    /**
     * New name for the bank connection. Maximum length is 64. If you do not want to change the current name let this field remain unset. If you want to clear the current name, set the field&#39;s value to an empty string (\&quot;\&quot;).&lt;br/&gt;&lt;br/&gt;&lt;strong&gt;NOTE:&lt;/strong&gt; If you are a Web Form 2.0 customer, and would like to update the name of your bank connection, please use the API parameter.
     * @DTA\Data(field="name", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€]*/"})
     * @var string|null
     */
    public $name;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; The interface for which you want to edit data. Must be given when you pass &#39;loginCredentials&#39; and/or a &#39;defaultTwoStepProcedureId&#39;.
     * @DTA\Data(field="interface", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; LoginCredential&lt;br/&gt; Set of login credentials that you want to edit. Must be passed in combination with the &#39;interface&#39; field. The labels that you pass must match with the login credential labels that the respective interface defines. If you want to clear the stored value for a credential, you can pass an empty string (\&quot;\&quot;) as value. In case you need to use finAPI&#39;s Web Form to let the user update the login credentials, send all fields the user wishes to update with a non-empty value. In case all fields contain an empty string (\&quot;\&quot;), no Web Form will be generated. Note that any change in the credentials will automatically remove the saved consent data associated with those credentials.&lt;br/&gt;&lt;br/&gt;&lt;strong&gt;NOTE:&lt;/strong&gt; If you are a  Web Form 2.0 customer, and would like to allow your end-users to change the credentials they have stored in our system, then please navigate &lt;a target&#x3D;\&quot;_blank\&quot; href&#x3D;&#39;?product&#x3D;web_form_2.0#post-/api/tasks/backgroundUpdate&#39; target&#x3D;&#39;_blank&#39;&gt;here&lt;/a&gt; to implement the same functionality.
     * @DTA\Data(field="loginCredentials", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection402::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection402::class})
     * @var \App\DTO\Collection402|null
     */
    public $login_credentials;

    /**
     * NOTE: In the future, this field will work only in combination with the &#39;interface&#39; field.&lt;br/&gt;&lt;br/&gt;New default two-step-procedure. Must match the &#39;procedureId&#39; of one of the procedures that are listed in the bank connection. If you do not want to change this field let it remain unset. If you want to clear the current default two-step-procedure, set the field&#39;s value to an empty string (\&quot;\&quot;).&lt;br/&gt;&lt;br/&gt;&lt;strong&gt;NOTE:&lt;/strong&gt; If you are a Web Form 2.0 customer and would like to allow your end users to update their preferred TAN procedure that is stored in our system, then please navigate &lt;a target&#x3D;\&quot;_blank\&quot; href&#x3D;&#39;?product&#x3D;web_form_2.0#post-/api/tasks/backgroundUpdate&#39;&gt;here&lt;/a&gt; to implement the same functionality.
     * @DTA\Data(field="defaultTwoStepProcedureId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $default_two_step_procedure_id;

}
