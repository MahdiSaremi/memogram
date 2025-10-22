<?php

namespace MemoGram\Tests\Validation;

use MemoGram\Api\Types\Update;
use MemoGram\Tests\Handle\FakeEvent;
use MemoGram\Tests\TestCase;
use MemoGram\Validation\Validator;

class ValidationTest extends TestCase
{
    public function testValidateUpdate()
    {
        $validator = new Validator(new Update(1));
        $validator->add(['update']);

        $this->assertTrue($validator->passes());
        $this->assertSame([], $validator->errors());
    }

    public function testValidateUpdateForFakeEvent()
    {
        $validator = new Validator(new FakeEvent(1, 1, 1));
        $validator->add(['update']);

        $this->assertFalse($validator->passes());
        $this->assertSame([__('memogram::validation.be_update')], $validator->errors());
    }
}