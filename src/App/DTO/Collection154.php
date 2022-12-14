<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * @DTA\Strategy(name="ObjectList", options={"type":\App\DTO\KeywordRuleParams::class})
 * @DTA\Validator(name="Count", options={"min":1,"max":100}, blocker=true)
 * @DTA\Validator(name="Collection", options={"validators":{
 *     {"name":"TypeCompliant", "options":{"type":\App\DTO\KeywordRuleParams::class}}
 * }})
 */
class Collection154 extends \ArrayObject
{
}
