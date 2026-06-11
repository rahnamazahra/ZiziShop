<?php

namespace App\Http\Controllers\Panel;

use App\Enums\ExpenseTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::query()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', '%' . $request->search . '%'))
            ->latest('spent_at')
            ->paginate(20)
            ->withQueryString();

        return view('panel.expenses.index', [
            'expenses'        => $expenses,
            'types'           => ExpenseTypeEnum::cases(),
            'totalAll'        => (int) Expense::sum('amount'),
            'monthlyEstimate' => (int) round(Expense::all()->sum(fn ($e) => $e->monthlyEquivalent())),
        ]);
    }

    public function create()
    {
        return view('panel.expenses.create', [
            'types'        => ExpenseTypeEnum::cases(),
            'recurrences'  => Expense::RECURRENCES,
        ]);
    }

    public function store(Request $request)
    {
        Expense::create($this->validated($request));

        return to_route('admin.expenses.index')->with('swal', [
            'title' => 'ثبت شد', 'message' => 'هزینه با موفقیت ثبت شد.', 'icon' => 'success',
        ]);
    }

    public function edit(Expense $expense)
    {
        return view('panel.expenses.edit', [
            'expense'      => $expense,
            'types'        => ExpenseTypeEnum::cases(),
            'recurrences'  => Expense::RECURRENCES,
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $expense->update($this->validated($request));

        return to_route('admin.expenses.index')->with('swal', [
            'title' => 'ویرایش شد', 'message' => 'هزینه به‌روزرسانی شد.', 'icon' => 'success',
        ]);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return to_route('admin.expenses.index')->with('swal', [
            'title' => 'حذف شد', 'message' => 'هزینه حذف شد.', 'icon' => 'success',
        ]);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'type'          => ['required', 'string'],
            'amount'        => ['required', 'integer', 'min:0'],
            'spent_at'      => ['required', 'date'],
            'recurrence'    => ['required', 'string'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'material_name' => ['nullable', 'string', 'max:255'],
            'product_code'  => ['nullable', 'string', 'max:100'],
            'quantity'      => ['nullable', 'integer', 'min:0'],
            'weight'        => ['nullable', 'integer', 'min:0'],
            'is_demo'       => ['nullable', 'boolean'],
        ]);
    }
}
