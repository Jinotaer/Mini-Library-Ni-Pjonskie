<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Please select a student.',
            'student_id.exists' => 'The selected student is invalid.',
            'borrow_date.required' => 'Please provide the borrow date.',
            'borrow_date.date' => 'Borrow date must be a valid date.',
            'due_date.required' => 'Please provide the due date.',
            'due_date.date' => 'Due date must be a valid date.',
            'due_date.after_or_equal' => 'Due date must be on or after the borrow date.',
            'books.required' => 'Please add at least one book.',
            'books.array' => 'Books must be a valid list.',
            'books.min' => 'Please add at least one book.',
            'books.*.book_id.required' => 'Please select a book.',
            'books.*.book_id.exists' => 'The selected book is invalid.',
            'books.*.quantity.required' => 'Please provide a quantity.',
            'books.*.quantity.integer' => 'Quantity must be a number.',
            'books.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
