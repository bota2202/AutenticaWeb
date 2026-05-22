@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/Dashboard/style.css">
</head>

<body>
    <div id="opcoes">

        @if (in_array(Auth::user()->role, ['admin', 'responsavel']))
        <a class="btn-opcao ubuntu" href="/cadastro">
            <i class="fa-solid fa-user"></i>
            Cadastrar usuário 
        </a>
        @endif

        @if (in_array(Auth::user()->role, ['responsavel', 'admin']))
        <a class="btn-opcao ubuntu">
            <i class="fa-solid fa-ticket"></i>
            Criar autorização
        </a>
        @endif

        @if (in_array(Auth::user()->role, ['responsavel', 'admin', 'professor']))
        <a class="btn-opcao ubuntu">
            <i class="fa-solid fa-bell"></i>
            Notificações
        </a>
        @endif

        @if (in_array(Auth::user()->role, ['portaria', 'admin']))
        <a class="btn-opcao ubuntu">
            <i class="fa-solid fa-check"></i>
            Confirmar
        </a>
        @endif

    </div>
    <form action="/logout" method="post">
        @csrf
        <button type="submit">Sair</button>
    </form>
</body>

</html>