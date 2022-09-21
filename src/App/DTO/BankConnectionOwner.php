<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank connection owner&#39;s data
 */
class BankConnectionOwner
{
    /**
     * First name
     * @DTA\Data(field="firstName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $first_name;

    /**
     * Last name
     * @DTA\Data(field="lastName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $last_name;

    /**
     * Salutation
     * @DTA\Data(field="salutation")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $salutation;

    /**
     * Title
     * @DTA\Data(field="title")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $title;

    /**
     * Email
     * @DTA\Data(field="email")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $email;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Date of birth
     * @DTA\Data(field="dateOfBirth")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $date_of_birth;

    /**
     * Post code
     * @DTA\Data(field="postCode")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $post_code;

    /**
     * Country
     * @DTA\Data(field="country")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $country;

    /**
     * City
     * @DTA\Data(field="city")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $city;

    /**
     * Street
     * @DTA\Data(field="street")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $street;

    /**
     * House number
     * @DTA\Data(field="houseNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $house_number;

}
