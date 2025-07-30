<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = User::with('userProfile');
        $user_is_creator = $user->profile->is_creator ?? false;
        return (auth()->check() && $user_is_creator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
			'price' => [
				'nullable', // Allows the field to be null or not present
				'numeric',  // Ensures it's a valid number (integer or float)
				'min:0',    // Prices typically can't be negative. Adjust if your logic allows negative prices.
				'max:99999999.99', // Matches the precision (10 total digits, 2 after decimal)
				'regex:/^\d+(\.\d{1,2})?$/', // Ensures at most 2 decimal places
			],
			'is_paid' => 'boolean',
			'visibility' => ['required', 'in:public,subscribers,paid'],
        ];
    }
}
