<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordValidation implements Rule
{
    //最小文字数
    protected $minCharacter;
    //最大文字数
    protected $maxCharacter;
    //1文字以上の大文字
    protected $includeLessThanOneUpperLetter;
    //1文字以上の小文字
    protected $includeLessThanOneLowerLetter;
    //1文字以上の数字
    protected $includeLessThanOneNumber;

    /**
     * Create a new rule instance.
     *
     * @return void
     * @param int $minCharacter
     * @param null $maxCharacter
     * @param boolean $includeLessThanOneUpperLetter
     * @param boolean $includeLessThanOneLowerLetter
     * @param boolean $includeLessThanOneNumber
     */
    public function __construct(
        $minCharacter = 8,
        $maxCharacter = null,
        $includeLessThanOneUpperLetter = true,
        $includeLessThanOneLowerLetter = true,
        $includeLessThanOneNumber = true
    )
    {
        $this->minCharacter = $minCharacter;
        $this->maxCharacter = $maxCharacter;
        $this->includeLessThanOneUpperLetter = $includeLessThanOneUpperLetter;
        $this->includeLessThanOneLowerLetter = $includeLessThanOneLowerLetter;
        $this->includeLessThanOneNumber = $includeLessThanOneNumber;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regexOfValidation = '';
        if ($this->includeLessThanOneLowerLetter) {
            $regexOfValidation = "(?=.*?[a-z])" . $regexOfValidation;
        }
        if ($this->includeLessThanOneUpperLetter) {
            $regexOfValidation = "(?=.*?[A-Z])" . $regexOfValidation;
        }
        if ($this->includeLessThanOneNumber) {
            $regexOfValidation = "(?=.*?\d)" . $regexOfValidation;
        }
        if ($this->maxCharacter || $this->minCharacter) {
            $regexOfValidation = $regexOfValidation . "{{$this->minCharacter}, {$this->maxCharacter}}";
        }
        $regexOfValidation = "/\A{$regexOfValidation}+\z/";

        return preg_match($regexOfValidation, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = 'パスワードは';

        return $message;
    }
}
