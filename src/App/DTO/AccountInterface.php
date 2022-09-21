<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Account interface details
 */
class AccountInterface
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankingInterface&lt;br/&gt; Bank interface. Possible values:&lt;br&gt;&lt;br&gt;&amp;bull; &lt;code&gt;WEB_SCRAPER&lt;/code&gt; - finAPI will parse account data from the bank&#39;s online banking website.&lt;br&gt;&amp;bull; &lt;code&gt;FINTS_SERVER&lt;/code&gt; - finAPI will download account data via the bank&#39;s FinTS interface.&lt;br&gt;&amp;bull; &lt;code&gt;XS2A&lt;/code&gt; - finAPI will download account data via the bank&#39;s XS2A interface.&lt;br&gt;
     * @DTA\Data(field="interface")
     * @DTA\Strategy(name="Object", options={"type":BankingInterface::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":BankingInterface::class})
     * @var BankingInterface|null
     */
    public $interface;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; AccountStatus&lt;br/&gt; The current status of the account from the perspective of this interface. Possible values are:&lt;br/&gt;&amp;bull; &lt;code&gt;UPDATED&lt;/code&gt; means that the account is up to date from finAPI&#39;s point of view. This means that no current import/update is running, and the previous import/update had successfully updated the account&#39;s data (e.g. transactions and securities), and the bank given balance matched the transaction&#39;s calculated sum, meaning that no adjusting entry (&#39;Zwischensaldo&#39; transaction) was inserted.&lt;br/&gt;&amp;bull; &lt;code&gt;UPDATED_FIXED&lt;/code&gt; means that the account is up to date from finAPI&#39;s point of view (no current import/update is running, and the previous import/update had successfully updated the account&#39;s data), BUT there was a deviation in the bank given balance which was fixed by adding an adjusting entry (&#39;Zwischensaldo&#39; transaction).&lt;br/&gt;&amp;bull; &lt;code&gt;DOWNLOAD_IN_PROGRESS&lt;/code&gt; means that the account&#39;s data is currently being imported/updated.&lt;br/&gt;&amp;bull; &lt;code&gt;DOWNLOAD_FAILED&lt;/code&gt; means that the account data was not successfully imported or updated. Possible reasons: finAPI could not get the account&#39;s balance, or it could not parse all transactions/securities, or some internal error has occurred. Also, it could mean that finAPI could not even get to the point of receiving the account data from the bank server, for example because of incorrect login credentials or a network problem. Note however that when we get a balance and just an empty list of transactions or securities, then this is regarded as valid and successful download. The reason for this is that for some accounts that have little activity, we may actually get no recent transactions but only a balance.&lt;br/&gt;&amp;bull; &lt;code&gt;DEPRECATED&lt;/code&gt; means that the account could no longer be matched with any account from the bank server. This can mean either that the account was terminated by the user and is no longer sent by the bank server, or that finAPI could no longer match it because the account&#39;s data (name, type, iban, account number, etc.) has been changed by the bank.
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":AccountStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":AccountStatus::class})
     * @var AccountStatus|null
     */
    public $status;

    /**
     * @DTA\Data(field="capabilities")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection533::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection533::class})
     * @var \App\DTO\Collection533|null
     */
    public $capabilities;

    /**
     * @DTA\Data(field="paymentCapabilities")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\AccountInterfacePaymentCapabilities::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\AccountInterfacePaymentCapabilities::class})
     * @var \App\DTO\AccountInterfacePaymentCapabilities|null
     */
    public $payment_capabilities;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Timestamp of when the account was last successfully updated using this interface (or initially imported); more precisely: time when the account data (balance and positions) has been stored into the finAPI databases.
     * @DTA\Data(field="lastSuccessfulUpdate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_successful_update;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Timestamp of when the account was last tried to be updated using this interface (or initially imported); more precisely: time when the update (or initial import) was triggered.
     * @DTA\Data(field="lastUpdateAttempt")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_update_attempt;

}
