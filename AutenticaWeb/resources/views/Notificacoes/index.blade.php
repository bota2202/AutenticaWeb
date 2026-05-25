@php
$statusLabels = [
    'pendente' => 'Pendente',
    'lida' => 'Lida',
    'confirmada' => 'Confirmada',
];
$typeLabels = [
    'entrada' => 'Entrada',
    'saida' => 'Saída',
];
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link rel="stylesheet" href="{{ asset('css/Usuarios/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;margin:0;">
    <div class="accent-bar"></div>
    @include('partials.nav-usuarios')

    <main>
        <div class="page-header">
            <div>
                <p class="page-title">Notificações</p>
                <p class="page-subtitle">Autorizações e solicitações do sistema</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-add" style="background:#64748b;">← Dashboard</a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            @if ($tickets->isEmpty())
            <p class="empty-msg">Nenhuma notificação no momento.</p>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Responsável</th>
                        <th>Professor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->student?->name ?? '—' }}</td>
                        <td>{{ $ticket->responsible?->name ?? '—' }}</td>
                        <td>{{ $ticket->professor?->name ?? '—' }}</td>
                        <td>{{ $typeLabels[$ticket->type] ?? $ticket->type }}</td>
                        <td>{{ $ticket->scheduled_for?->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge {{ $ticket->status }}">
                                <span class="badge-dot"></span>
                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            @if ($ticket->status === 'pendente' && in_array(auth()->user()->role, ['professor', 'portaria', 'admin']))
                            <form action="{{ route('tickets.read', $ticket) }}" method="post" class="inline-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn" title="Marcar como lida">👁</button>
                            </form>
                            @endif
                            @if (in_array($ticket->status, ['pendente', 'lida']) && in_array(auth()->user()->role, ['professor', 'portaria', 'admin']))
                            <form action="{{ route('tickets.confirm', $ticket) }}" method="post" class="inline-form" onsubmit="return confirm('Confirmar esta autorização?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn" title="Confirmar">✓</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>

    <footer><span>© {{ date('Y') }} Sistema Escolar</span></footer>
    <div class="accent-bar"></div>
</body>
</html>
