<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Iosevka+Charon+Mono:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=SN+Pro:ital,wght@0,200..900;1,200..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <img src="Imagem/senai.jpg" alt="Logo">
    </nav>

    <main>
        <form action="/login" method="post">
            @csrf
            <h2 class="ubuntu">Conecte-se</h2>
            @error('cpf')
            <div class="error">
                <span class="ubuntu error-msg">{{ $message }}</span>
            </div>
            @enderror
            @error('password')
            <div class="error">
                <span class="ubuntu error-msg">{{ $message }}</span>
            </div>
            @enderror
            <div>
                <label class="ubuntu" for="cpf">CPF:</label>
                <input class="ubuntu" type="text" name="cpf" placeholder="Digite seu cpf" id="cpf">
                <label class="ubuntu" for="senha">Senha:</label>
                <input class="ubuntu" type="text" name="password" placeholder="Digite sua senha" id="senha">
            </div>
            <button class="ubuntu" type="sumbmit">Entrar</button>
        </form>
    </main>

    <footer>
        &copy Otávio Satunino da Silva
    </footer>

</body>

</html>