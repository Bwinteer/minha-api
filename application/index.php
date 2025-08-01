<!DOCTYPE html>
<html>
<head>
    <title>Teste da API</title>
</head>
<body>
    <h1>Teste da API de Usuários</h1>
    
    <button onclick="listarUsuarios()">Listar Usuários</button>
    <button onclick="criarUsuario()">Criar Usuário</button>
    <button onclick="buscarUsuario()">Buscar Usuário ID 1</button>
    
    <div id="resultado" class="resultado">
        Resultado aparecerá aqui...
    </div>

    <script>
        function listarUsuarios() {
            fetch('api/usuarios.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('resultado').innerHTML = 
                        '<h3>Usuários:</h3><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                });
        }

        function criarUsuario() {
            const dados = {
                nome: 'Bruna Winter',
                email: 'brunaw20@api.com',
                telefone: '(11) 99999-9999'
            };

            fetch('api/usuarios.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('resultado').innerHTML = 
                    '<h3>Resultado:</h3><pre>' + JSON.stringify(data, null, 2) + '</pre>';
            });
        }

        function buscarUsuario() {
            fetch('api/usuarios.php?id=1')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('resultado').innerHTML = 
                        '<h3>Usuário encontrado:</h3><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                });
        }
    </script>
</body>
</html>
<style>
    body { font-family: Arial; margin: 20px; }
    button { padding: 10px; margin: 5px; cursor: pointer; }
    .resultado { background: #f0f0f0; padding: 10px; margin: 10px 0; }
</style>