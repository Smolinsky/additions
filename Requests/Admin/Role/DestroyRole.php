<?php

namespace App\Http\Requests\Admin\Role;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.role.delete', $this->role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
