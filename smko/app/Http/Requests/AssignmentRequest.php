<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AssignmentRequest extends FormRequest { public function authorize(): bool { return auth()->check() && in_array(auth()->user()->role, ['admin','guru'], true); } public function rules(): array { return ['course_id'=>['required','exists:courses,id'], 'title'=>['required','string','max:255'], 'description'=>['nullable','string'], 'due_date'=>['required','date']]; } }
