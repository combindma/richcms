<?php

namespace Combindma\Richcms\Http\Requests;

use Combindma\Richcms\Rules\EmailRule;
use Combindma\Richcms\Rules\NameRule;
use Combindma\Richcms\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', new NameRule()],
            'email' => ['required', 'email', new EmailRule(), Rule::unique('users')->ignore(auth()->user())],
            'password' => ['nullable', new PasswordRule()]
        ];
    }
}
