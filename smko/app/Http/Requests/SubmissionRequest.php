<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SubmissionRequest extends FormRequest { public function authorize(): bool { return auth()->check() && auth()->user()->role === 'siswa'; } public function rules(): array { return ['assignment_id'=>['required','exists:assignments,id'], 'file'=>['nullable','file','mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg','max:4096'], 'file_path'=>['nullable','string','max:255']]; } }
