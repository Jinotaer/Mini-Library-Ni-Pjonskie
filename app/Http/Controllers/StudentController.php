<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // only staff manage students
    }

    public function index()
    {
        $students = Student::withCount('borrowTransactions')->latest()->paginate(20);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'course' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'contact' => 'nullable|string|max:50',
        ]);

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added.');
    }

    public function show(Student $student)
    {
        $student->load('borrowTransactions.items.book');
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number,' . $student->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'course' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'contact' => 'nullable|string|max:50',
        ]);

        $student->update($data);

        return redirect()->route('students.show', $student)->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        // optional: prevent if student has outstanding borrowed items
        $outstanding = $student->borrowTransactions()
            ->whereNull('returned_at')
            ->exists();

        if ($outstanding) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete student with outstanding borrowed books.']);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }
}