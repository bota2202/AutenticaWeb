<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function create()
    {
        $professors = User::where('role', 'professor')->where('is_active', true)->orderBy('name')->get();

        return view('Criar_Autorizacao.index', compact('professors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|min:3|max:255',
            'professor_id' => 'required|exists:users,id',
            'type' => 'required|in:entrada,saida',
            'scheduled_for' => 'required|date',
            'reason' => 'nullable|string|max:500',
            'comeback' => 'nullable|boolean',
            'return_scheduled_for' => 'nullable|date|required_if:comeback,1',
        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Ticket::create([
            'responsible_id' => Auth::id(),
            'student_name' => trim($request->student_name),
            'professor_id' => $request->professor_id,
            'type' => $request->type,
            'reason' => $request->reason,
            'scheduled_for' => $request->scheduled_for,
            'comeback' => $request->boolean('comeback'),
            'return_scheduled_for' => $request->boolean('comeback') ? $request->return_scheduled_for : null,
            'status' => 'pendente',
            'validated' => false,
        ]);

        return redirect()->route('notificacoes.index')->with('success', 'Autorização criada com sucesso.');
    }
}
