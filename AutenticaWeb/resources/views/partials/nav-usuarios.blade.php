@php
use Illuminate\Support\Facades\Auth;

if (! function_exists('avatarInitials')) {
    function avatarInitials(string $name): string {
        $parts = explode(' ', trim($name));
        $initials = '';
        foreach (array_slice($parts, 0, 2) as $part) {
            $initials .= strtoupper(mb_substr($part, 0, 1));
        }
        return $initials;
    }
}
@endphp

<nav>
    <div class="nav-brand">
        <div class="nav-dot"></div>
        <a href="{{ route('dashboard') }}" style="text-decoration:none;color:inherit;">Sistema Escolar</a>
    </div>
    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">Usuários</a>
        @if (in_array(Auth::user()->role, ['admin', 'responsavel']))
        <a href="{{ route('tickets.create') }}" class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}">Autorização</a>
        @endif
        <a href="{{ route('notificacoes.index') }}" class="nav-link {{ request()->routeIs('notificacoes.*') ? 'active' : '' }}">Notificações</a>
    </div>
    <div class="nav-avatar" title="{{ Auth::user()->name }}">
        {{ avatarInitials(Auth::user()->name) }}
    </div>
</nav>
