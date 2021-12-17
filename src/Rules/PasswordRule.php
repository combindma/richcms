<?php

namespace Combindma\Richcms\Rules;

use Illuminatech\Validation\Composite\CompositeRule;

class PasswordRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['string', 'min:6', 'max:20'];
    }
}
