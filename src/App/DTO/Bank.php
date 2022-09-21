<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank&#39;s data
 */
class Bank
{
    /**
     * Bank identifier.&lt;br/&gt;&lt;br/&gt;NOTE: Do NOT assume that the identifiers of banks are the same across different finAPI environments. In fact, the identifiers may change whenever a new finAPI version is released, even within the same environment. The identifiers are meant to be used for references within the finAPI services only, but not for hard-coding them in your application. If you need to hard-code the usage of a certain bank within your application, please instead refer to the BLZ.
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Name of bank
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * BIC of bank
     * @DTA\Data(field="bic")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bic;

    /**
     * BLZ of bank
     * @DTA\Data(field="blz")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $blz;

    /**
     * Bank location (two-letter country code; ISO 3166 ALPHA-2). Note that when this field is not set, it means that this bank depicts an international institute which is not bound to any specific country.
     * @DTA\Data(field="location")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $location;

    /**
     * City that this bank is located in. Note that this field may not be set for some banks.
     * @DTA\Data(field="city")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $city;

    /**
     * If true, then this bank does not depict a real bank, but rather a testing endpoint provided by a bank or by finAPI. You probably want to regard these banks only during the development of your application, but not in production. You can filter out these banks in production by making sure that the &#39;isTestBank&#39; parameter is always set to &#39;false&#39; whenever your application is calling the &#39;Get and search all banks&#39; service.
     * @DTA\Data(field="isTestBank")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_test_bank;

    /**
     * Popularity of this bank with your users (mandator-wide, i.e. across all of your clients). The value equals the number of bank connections that are currently imported for this bank across all of your users (which means it is a constantly adjusting value). You can use this field for statistical evaluation, and also for ordering bank search results (see service &#39;Get and search all banks&#39;).
     * @DTA\Data(field="popularity")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $popularity;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; BankInterface&lt;br/&gt; Set of interfaces that finAPI can use to connect to the bank. Note that this set will be empty for non-supported banks. Note also that the WEB_SCRAPER interface might be disabled for your client (see GET /clientConfiguration). When this is the case, then finAPI will not use the web scraper for data download, and if the web scraper is the only supported interface of this bank, then finAPI will not allow to download any data for this bank at all (for details, see POST /bankConnections/import and POST /bankConnections/update).
     * @DTA\Data(field="interfaces")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection511::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection511::class})
     * @var \App\DTO\Collection511|null
     */
    public $interfaces;

    /**
     * @DTA\Data(field="bankGroup")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankBankGroup::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankBankGroup::class})
     * @var \App\DTO\BankBankGroup|null
     */
    public $bank_group;

    /**
     * Whether this bank is in beta phase. For more details, please refer to the field ClientConfiguration.betaBanksEnabled.
     * @DTA\Data(field="isBeta")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_beta;

    /**
     * @DTA\Data(field="logo")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankLogo::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankLogo::class})
     * @var \App\DTO\BankLogo|null
     */
    public $logo;

    /**
     * @DTA\Data(field="icon")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\BankIcon::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\BankIcon::class})
     * @var \App\DTO\BankIcon|null
     */
    public $icon;

}
