<?php

namespace Combindma\Richcms\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Combindma\Richcms\Enums\Roles;
use Combindma\Richcms\Rules\EmailRule;
use Combindma\Richcms\Rules\NameRule;
use Combindma\Richcms\Rules\PasswordRule;
use Combindma\Richcms\Rules\PhoneRule;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->getMethod() === 'PUT') {
            return $this->updateRules();
        }
        if ($this->getMethod() === 'PATCH') {
            return $this->updateRules();
        }

        return $this->createRules();
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape|lowercase',
            'email' => 'trim|escape|lowercase',
            'phone' => 'trim',
            'company' => 'trim|escape|lowercase',
            'address' => 'trim|escape|lowercase',
            'city' => 'trim|escape',
            'state' => 'trim|escape',
            'country' => 'trim|escape',
        ];
    }

    public function createRules()
    {
        return [
            'name' => ['required', new NameRule()],
            'email' => ['required', new EmailRule(), 'email','unique:users,email'],
            'password' => ['required', new PasswordRule()],
            'phone' => ['nullable', new PhoneRule()],
            'company' => 'nullable|string',
            'address' => 'nullable|string',
            'postcode' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => ['required', 'string'],
            'role' => ['required','string', new EnumValue(Roles::class, false)],
            'meta.*' => 'nullable|string',
            'send_email' => 'nullable|boolean',
        ];
    }

    public function updateRules()
    {
        return [
            'name' => ['required', new NameRule()],
            'email' => ['required', new EmailRule(), 'email', Rule::unique('users', 'email')->ignore($this->user)],
            'password' => ['nullable', new PasswordRule()],
            'phone' => ['nullable', new PhoneRule()],
            'company' => 'nullable|string',
            'address' => 'nullable|string',
            'postcode' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => ['required', 'string'],
            'role' => ['required', new EnumValue(Roles::class, false)],
            'meta.*' => 'nullable|string',
            'send_email' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'send_email' => $this->send_email ?? 0,
        ]);
    }
}
