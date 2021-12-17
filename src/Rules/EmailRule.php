<?php

namespace Combindma\Richcms\Rules;

use Illuminatech\Validation\Composite\CompositeRule;

class EmailRule extends CompositeRule
{
    protected function rules(): array
    {
        return ['string', 'max:250', 'indisposable'];
    }

    protected function messages(): array
    {
        return [
            'indisposable' => __('Les adresses e-mail jetables ne sont pas autorisées.'),
        ];
    }
}
