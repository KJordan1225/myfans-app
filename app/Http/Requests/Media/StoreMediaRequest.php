<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => ['required', 'exists:posts,id'],
            'media_type' => ['required', 'in:image,video'],
            // Validate file type based on media_type
            'path' => [
                'required',
                function ($attribute, $value, $fail) {
                    $mediaType = $this->input('media_type');
                    $file = $this->file('path');

                    if ($mediaType === 'image' && !$file->isValid()) {
                        $fail('Invalid image file.');
                    }

                    if ($mediaType === 'image' && !in_array($file->extension(), ['jpg', 'jpeg', 'png', 'webp'])) {
                        $fail('Image must be a JPG, JPEG, PNG, or WEBP file.');
                    }

                    if ($mediaType === 'video' && !in_array($file->extension(), ['mp4', 'mov', 'avi', 'webm'])) {
                        $fail('Video must be a MP4, MOV, AVI, or WEBM file.');
                    }
                }
            ],
			'thumbnail_path' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}
