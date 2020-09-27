<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordValidation implements Rule
{
    //最小文字数
    protected $minCharacter;
    //最大文字数
    protected $maxCharacter;
    //1文字以上の半角英字（大文字）
    protected $includeLessThanOneUpperLetter;
    //1文字以上の半角英字（小文字）
    protected $includeLessThanOneLowerLetter;
    //1文字以上の半角数字
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
        $regexOfValidation = "[a-zA-z\d]";
        // 半角英字（小文字）1文字以上
        if ($this->includeLessThanOneLowerLetter) {
            $regexOfValidation = "(?=.*?[a-z])" . $regexOfValidation;
        }
        // 半角英字（大文字）1文字以上
        if ($this->includeLessThanOneUpperLetter) {
            $regexOfValidation = "(?=.*?[A-Z])" . $regexOfValidation;
        }
        // 半角数字1文字以上
        if ($this->includeLessThanOneNumber) {
            $regexOfValidation = "(?=.*?\d)" . $regexOfValidation;
        }
        // 最大、最小文字数
        if ($this->maxCharacter || $this->minCharacter) {
            $regexOfValidation = $regexOfValidation . "{{$this->minCharacter},{$this->maxCharacter}}";
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
        $validationMessage = 'パスワードは';
        $validationOneLetterMessage = [];
        if ($this->includeLessThanOneLowerLetter) {
            $validationOneLetterMessage[] = '半角英字（小文字）';
        }
        if ($this->includeLessThanOneUpperLetter) {
            $validationOneLetterMessage[] = '半角英字（大文字）';
        }
        if ($this->includeLessThanOneNumber) {
            $validationOneLetterMessage[] = '半角数字';
        }
        if ($validationOneLetterMessage) {
            $validationMessage .= implode('、', $validationOneLetterMessage) . 'を１文字以上含む';
        }
        if ($this->minCharacter) {
            $validationMessage .= "{$this->minCharacter}文字以上";
        }
        if ($this->maxCharacter) {
            $validationMessage .= "{$this->maxCharacter}文字以下";
        }
        $validationMessage .= 'で入力してください';

        return $validationMessage;
    }
}
