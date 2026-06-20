<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class GradeRequest extends FormRequest { public function authorize(): bool { return auth()->check() && in_array(auth()->user()->role, ['admin','guru'], true); } public function rules(): array { return ['score'=>['required','integer','min:0','max:100']]; } }
