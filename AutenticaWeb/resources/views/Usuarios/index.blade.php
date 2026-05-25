@php
$roleLabels = [
    'admin'       => 'Admin',
    'portaria'    => 'Portaria',
    'professor'   => 'Professor',
    'responsavel' => 'Responsável',
];

function avatarInitials(string $name): string {
    $parts = explode(' ', trim($name));
    $initials = '';
    foreach (array_slice($parts, 0, 2) as $part) {
        $initials .= strtoupper(mb_substr($part, 0, 1));
    }
    return $initials;
}
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="{{ asset('css/Usuarios/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;margin:0;">

    <div class="accent-bar"></div>
    @include('partials.nav-usuarios')

    <main>
        <div class="page-header">
            <div>
                <p class="page-title">Usuários</p>
                <p class="page-subtitle">Gerencie todos os usuários do sistema</p>
            </div>
            <a href="{{ route('usuarios.create') }}" class="btn-add">+ Novo usuário</a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="table-toolbar">
                <div class="search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input type="text" id="search-input" placeholder="Buscar usuário...">
                </div>
                <div>
                    <select id="role-filter" class="filter-select">
                        <option value="">Todos os cargos</option>
                        <option value="admin">Admin</option>
                        <option value="portaria">Portaria</option>
                        <option value="professor">Professor</option>
                        <option value="responsavel">Responsável</option>
                    </select>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cargo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($users as $user)
                    <tr data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" data-role="{{ $user->role }}">
                        <td>
                            <div class="name-cell">
                                <div class="avatar {{ $user->role }}">
                                    {{ avatarInitials($user->name) }}
                                </div>
                                <span class="name-text">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td><span class="cpf-text">{{ $user->cpf }}</span></td>
                        <td><span class="email-text">{{ $user->email }}</span></td>
                        <td><span class="phone-text">{{ $user->phone }}</span></td>
                        <td>
                            <span class="badge {{ $user->role }}">
                                <span class="badge-dot"></span>
                                {{ $roleLabels[$user->role] ?? $user->role }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('usuarios.edit', $user) }}" class="action-btn" title="Editar">✏</a>
                            @if ($user->id !== auth()->id())
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <span>© {{ date('Y') }} Sistema Escolar</span>
        <span id="row-count">
            {{ $users->count() }} usuário{{ $users->count() !== 1 ? 's' : '' }} encontrado{{ $users->count() !== 1 ? 's' : '' }}
        </span>
    </footer>

    <div class="accent-bar"></div>

    <script>
        const searchInput = document.getElementById('search-input');
        const roleFilter  = document.getElementById('role-filter');
        const rows        = document.querySelectorAll('#table-body tr');
        const rowCount    = document.getElementById('row-count');

        function filterTable() {
            const q = searchInput.value.toLowerCase();
            const r = roleFilter.value;
            let visible = 0;

            rows.forEach(row => {
                const name  = row.dataset.name  || '';
                const email = row.dataset.email || '';
                const role  = row.dataset.role  || '';
                const match = (name.includes(q) || email.includes(q)) && (!r || role === r);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            rowCount.textContent = visible + ' usuário' + (visible !== 1 ? 's' : '') + ' encontrado' + (visible !== 1 ? 's' : '');
        }

        searchInput.addEventListener('input', filterTable);
        roleFilter.addEventListener('change', filterTable);
    </script>
</body>
</html>
