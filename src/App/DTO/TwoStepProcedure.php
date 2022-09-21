<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Two-step-procedure for user authorization on bank-side
 */
class TwoStepProcedure
{
    /**
     * Bank-given ID of the procedure
     * @DTA\Data(field="procedureId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $procedure_id;

    /**
     * Bank-given name of the procedure
     * @DTA\Data(field="procedureName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $procedure_name;

    /**
     * The challenge type of the procedure. Possible values are:&lt;br/&gt;&lt;br/&gt;&amp;bull; &lt;code&gt;TEXT&lt;/code&gt; - the challenge will be a text that contains instructions for the user on how to proceed with the authorization.&lt;br/&gt;&amp;bull; &lt;code&gt;PHOTO&lt;/code&gt; - the challenge will contain a BASE-64 string depicting a photo (or any kind of QR-code-like data) that must be shown to the user.&lt;br/&gt;&amp;bull; &lt;code&gt;FLICKER_CODE&lt;/code&gt; - the challenge will contain a BASE-64 string depicting a flicker code animation that must be shown to the user.&lt;br/&gt;&lt;br/&gt;Note that this challenge type information does not originate from the bank, but is determined by finAPI internally. There is no guarantee that the determined challenge type is correct. Note also that this field may not be set, meaning that finAPI could not determine the challenge type of the procedure.
     * @DTA\Data(field="procedureChallengeType")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $procedure_challenge_type;

    /**
     * If &#39;true&#39;, then there is no need for your client to pass back anything to finAPI to continue the authorization when using this procedure. The authorization will be dealt with directly between the user, finAPI, and the bank.
     * @DTA\Data(field="implicitExecute")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $implicit_execute;

}
