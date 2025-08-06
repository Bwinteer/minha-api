Core/           (Núcleo - Router, View, Json)
Controllers/    (Controladores)  
Services/       (Lógica de negócio)
Models/         (Acesso ao banco)
Config/         (Configurações)
Views/          (Templates HTML)

Fluxo de uma Requisição:
- GET /usuarios/123

index.php → Router recebe a requisição
Router → Identifica o padrão e chama UsuarioController->buscarUsuario(123)
UsuarioController → Chama UsuarioService->buscarPorId(123)
UsuarioService → Chama UsuarioModel->readOne()
UsuarioModel → Executa SQL: SELECT * FROM usuarios WHERE id = 123
Retorno → Model → Service → Controller → JSON response
