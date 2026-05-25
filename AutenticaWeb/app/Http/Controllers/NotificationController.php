<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $tickets = $this->ticketsForUser()->with(['student', 'responsible', 'professor'])->get();

        return view('Notificacoes.index', compact('tickets'));
    }

    public function markAsRead(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        if ($ticket->status === 'pendente') {
            $ticket->update(['status' => 'lida']);
        }

        return redirect()->route('notificacoes.index')->with('success', 'Notificação marcada como lida.');
    }

    public function confirm(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $ticket->update([
            'status' => 'confirmada',
            'validated' => true,
            'confirmational_id' => Auth::id(),
        ]);

        return redirect()->route('notificacoes.index')->with('success', 'Autorização confirmada.');
    }

    private function ticketsForUser()
    {
        $user = Auth::user();

        return match ($user->role) {
            'professor' => Ticket::where('professor_id', $user->id)->orderByDesc('created_at'),
            'responsavel' => Ticket::where('responsible_id', $user->id)->orderByDesc('created_at'),
            'portaria' => Ticket::orderByDesc('created_at'),
            default => Ticket::orderByDesc('created_at'),
        };
    }

    private function authorizeTicket(Ticket $ticket): void
    {
        $user = Auth::user();

        $allowed = match ($user->role) {
            'professor' => $ticket->professor_id === $user->id,
            'responsavel' => $ticket->responsible_id === $user->id,
            'portaria', 'admin' => true,
            default => false,
        };

        if (! $allowed) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
