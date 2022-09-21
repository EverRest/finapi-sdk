<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a result of the consent deleting
 */
class DeleteConsent
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DeleteConsentResult&lt;br/&gt; Result of consent deletion in the finAPI database (local):&lt;br/&gt;&lt;br/&gt;&amp;bull; &lt;code&gt;DELETED&lt;/code&gt; - if there was a stored consent and it was deleted.&lt;br/&gt;&amp;bull; &lt;code&gt;NOT_EXIST&lt;/code&gt; - if there was no stored consent.&lt;br/&gt;
     * @DTA\Data(field="local")
     * @DTA\Strategy(name="Object", options={"type":DeleteConsentResult::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":DeleteConsentResult::class})
     * @var DeleteConsentResult|null
     */
    public $local;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DeleteConsentResult&lt;br/&gt; Result of consent deletion on the bank&#39;s side (remote):&lt;br/&gt;&lt;br/&gt;&amp;bull; &lt;code&gt;DELETED&lt;/code&gt; - if the consent was successfully deleted on the bank side.&lt;br/&gt;&amp;bull; &lt;code&gt;NOT_SUPPORTED&lt;/code&gt; - if the bank doesn&#39;t support consent deletion.&lt;br/&gt;&amp;bull; &lt;code&gt;NOT_EXIST&lt;/code&gt; - if either there was no remote consent, or there was no local consent (making it impossible to identify any remote consent).&lt;br/&gt;&amp;bull; &lt;code&gt;NOT_DELETED&lt;/code&gt; - if the consent couldn&#39;t get deleted on the bank side.&lt;br/&gt;
     * @DTA\Data(field="remote")
     * @DTA\Strategy(name="Object", options={"type":DeleteConsentResult::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":DeleteConsentResult::class})
     * @var DeleteConsentResult|null
     */
    public $remote;

}
