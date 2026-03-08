<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // only staff manage students
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $students = Student::query()
            ->withCount('borrowTransactions')
            ->when($search !== '', function ($query) use ($search): void {
                $keyword = '%'.$search.'%';
                $query->where(function ($studentQuery) use ($keyword): void {
                    $studentQuery
                        ->where('student_number', 'like', $keyword)
                        ->orWhere('first_name', 'like', $keyword)
                        ->orWhere('last_name', 'like', $keyword)
                        ->orWhere('email', 'like', $keyword)
                        ->orWhere('course', 'like', $keyword)
                        ->orWhere('contact', 'like', $keyword);
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('students.index');
    }

    public function store(Request $request): RedirectResponse
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

    public function show(Student $student): RedirectResponse
    {
        return redirect()->route('students.index');
    }

    public function edit(Student $student): RedirectResponse
    {
        return redirect()->route('students.index');
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $data = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number,'.$student->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'course' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'contact' => 'nullable|string|max:50',
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student): RedirectResponse
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
