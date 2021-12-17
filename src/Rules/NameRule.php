<?php

namespace Combindma\Richcms\Rules;

use Illuminatech\Validation\Composite\CompositeRule;

class NameRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['string', 'max:150'];
    }
}
