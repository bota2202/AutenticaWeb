<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar autorização</title>
    <link rel="stylesheet" href="{{ asset('css/Usuarios/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="display:flex;flex-direction:column;min-height:100vh;margin:0;">
    <div class="accent-bar"></div>
    @include('partials.nav-usuarios')

    <main>
        <div class="page-header">
            <div>
                <p class="page-title">Criar autorização</p>
                <p class="page-subtitle">Solicite entrada ou saída do aluno</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-add" style="background:#64748b;">← Dashboard</a>
        </div>

        @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="card form-card">
            <form action="{{ route('tickets.store') }}" method="post" class="user-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_name">Nome do aluno</label>
                        <input type="text" id="student_name" name="student_name" value="{{ old('student_name') }}" placeholder="Digite o nome completo do aluno" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="professor_id">Professor responsável</label>
                        <select id="professor_id" name="professor_id" required>
                            <option value="">Selecione o professor</option>
                            @foreach ($professors as $professor)
                            <option value="{{ $professor->id }}" @selected(old('professor_id') == $professor->id)>
                                {{ $professor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo</label>
                        <select id="type" name="type" required>
                            <option value="entrada" @selected(old('type') === 'entrada')>Entrada</option>
                            <option value="saida" @selected(old('type') === 'saida')>Saída</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scheduled_for">Data e hora</label>
                        <input type="datetime-local" id="scheduled_for" name="scheduled_for" value="{{ old('scheduled_for') }}" required>
                    </div>
                    <div class="form-group form-full">
                        <label for="reason">Motivo</label>
                        <textarea id="reason" name="reason" rows="3" placeholder="Descreva o motivo da autorização">{{ old('reason') }}</textarea>
                    </div>
                    <div class="form-group form-check">
                        <label>
                            <input type="checkbox" name="comeback" value="1" id="comeback" @checked(old('comeback'))>
                            Retorno previsto
                        </label>
                    </div>
                    <div class="form-group" id="return-group" style="display:none;">
                        <label for="return_scheduled_for">Data e hora do retorno</label>
                        <input type="datetime-local" id="return_scheduled_for" name="return_scheduled_for" value="{{ old('return_scheduled_for') }}">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-add">Criar autorização</button>
                </div>
            </form>
        </div>
    </main>

    <footer><span>© {{ date('Y') }} Sistema Escolar</span></footer>
    <div class="accent-bar"></div>
    <script>
        const comeback = document.getElementById('comeback');
        const returnGroup = document.getElementById('return-group');
        function toggleReturn() {
            returnGroup.style.display = comeback.checked ? '' : 'none';
        }
        comeback.addEventListener('change', toggleReturn);
        toggleReturn();
    </script>
</body>
</html>
