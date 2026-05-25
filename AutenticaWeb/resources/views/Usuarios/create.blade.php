<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo usuário</title>
    <link rel="stylesheet" href="{{ asset('css/Usuarios/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;margin:0;">
    <div class="accent-bar"></div>
    @include('partials.nav-usuarios')

    <main>
        <div class="page-header">
            <div>
                <p class="page-title">Novo usuário</p>
                <p class="page-subtitle">Cadastre um novo usuário no sistema</p>
            </div>
            <a href="{{ route('usuarios.index') }}" class="btn-add" style="background:#64748b;">← Voltar</a>
        </div>

        @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="card form-card">
            <form action="{{ route('usuarios.store') }}" method="post" class="user-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="(00) 00000-0000" maxlength="15" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Cargo</label>
                        <select id="role" name="role" required>
                            <option value="">Selecione</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            <option value="portaria" @selected(old('role') === 'portaria')>Portaria</option>
                            <option value="professor" @selected(old('role') === 'professor')>Professor</option>
                            <option value="responsavel" @selected(old('role') === 'responsavel')>Responsável</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" required minlength="6">
                    </div>
                    <div class="form-group form-check">
                        <label>
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                            Usuário ativo
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-add">Cadastrar usuário</button>
                </div>
            </form>
        </div>
    </main>

    <footer><span>© {{ date('Y') }} Sistema Escolar</span></footer>
    <div class="accent-bar"></div>
    <script src="{{ asset('js/masks.js') }}"></script>
</body>
</html>
