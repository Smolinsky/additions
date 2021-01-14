<?php

namespace App\Http\Requests\Admin\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user.edit', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /* @var User $user */
        $user = $this->route('user');

        return [
            'first_name' => 'string|max:' . config('validation.string_max_length'),
            'last_name' => 'string|max:' . config('validation.string_max_length'),
            'email' => "email|unique:users,email,$user->id|max:" . config('validation.email_max_length'),
            'email_verified_at' => 'nullable|date',
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        return $this->validated();
    }
}
