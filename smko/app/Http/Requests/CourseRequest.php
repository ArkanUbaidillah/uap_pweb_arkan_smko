<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CourseRequest extends FormRequest { public function authorize(): bool { return auth()->check() && in_array(auth()->user()->role, ['admin','guru'], true); } public function rules(): array { $id = $this->route('course')?->id; return ['teacher_id'=>['nullable','exists:users,id'], 'name'=>['required','string','max:255'], 'code'=>['required','string','max:50', Rule::unique('courses','code')->ignore($id)], 'description'=>['nullable','string']]; } }
