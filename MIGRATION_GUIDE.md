# Guia de Migração - Estrutura Reestruturada

## Visão Geral da Migração

Este documento explica como migrar do sistema antigo para a nova estrutura modular e escalável, mantendo todas as funcionalidades existentes.

## Mudanças Principais

### 1. Estrutura de Diretórios

**Antes:**

```
App/
├── core/
├── controllers/
├── dataBase/
├── view/
└── routes/
```

**Depois:**

```
App/
├── bootstrap/          # Inicialização
├── config/            # Configurações
├── Controllers/       # Controllers (maiúsculo)
├── Core/              # Núcleo modular
├── Database/          # Banco de dados (maiúsculo)
├── Middleware/        # Middlewares
├── resources/         # Recursos
│   └── views/         # Views organizadas
├── routes/            # Rotas organizadas
└── helpers/           # Funções auxiliares
```

### 2. Namespaces Padronizados

**Antes:**

- `app\core\Router`
- `app\controllers\Controller`
- `app\dataBase\Models\User`

**Depois:**

- `App\Core\Router\Router`
- `App\Controllers\BaseController`
- `App\Database\Models\User`

### 3. Sistema de Roteamento

**Antes:**

```php
// App/routes/Routes.php
return [
    'get' => [
        '/path' => 'Controller@method'
    ]
];
```

**Depois:**

```php
// App/routes/web.php
$router->get('/path', 'Controller@method')->name('route.name');
$router->group(['middleware' => [AuthMiddleware::class]], function($router) {
    // Rotas protegidas
});
```

## Como Migrar Controllers

### Controller Antigo:

```php
<?php
namespace app\controllers;
use app\controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', ['data' => $data]);
    }
}
```

### Controller Novo:

```php
<?php
namespace App\Controllers;
use App\Core\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Response;

class HomeController extends BaseController
{
    public function index(Request $request): Response
    {
        $content = $this->render('home', ['data' => $data]);
        return $this->response($content);
    }
}
```

## Como Migrar Models

### Model Antigo:

```php
<?php
namespace app\dataBase\Models;
use app\dataBase\connection;

class User extends Model
{
    protected string $tables = 'usuarios';

    public function findUser($id) {
        // Query manual
    }
}
```

### Model Novo:

```php
<?php
namespace App\Database\Models;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = ['name', 'email'];

    public function findUser($id) {
        return $this->find($id);
    }
}
```

## Como Migrar Views

### View Antiga:

```php
// App/view/home.php
<h1>Home</h1>
```

### View Nova:

```php
// App/resources/views/home.php
<?php $this->layout('master', ['title' => $title]) ?>
<h1>Home</h1>
```

## Configuração Necessária

### 1. Arquivo .env

Crie um arquivo `.env` baseado no `.env.example`:

```env
BASE_URL=/PHP-POO/routes-phpoo/public
DB_HOST=localhost
DB_DATABASE=service_db
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Composer

Execute para atualizar autoload:

```bash
composer dump-autoload
```

## Compatibilidade

### O que continua funcionando:

- ✅ Todas as URLs existentes
- ✅ Sistema de autenticação
- ✅ Interface visual (Bootstrap)
- ✅ Chat WebSocket
- ✅ Banco de dados atual
- ✅ Sistema de notificações

### O que foi melhorado:

- ✅ Injeção de dependências
- ✅ Roteamento avançado
- ✅ Validação de formulários
- ✅ Middlewares modulares
- ✅ Query Builder
- ✅ Tratamento de erros
- ✅ Sistema de configuração

## Migração Gradual

### Etapa 1: Configuração Base

1. Criar arquivo `.env`
2. Atualizar `composer.json`
3. Executar `composer dump-autoload`

### Etapa 2: Controllers

1. Migrar um controller por vez
2. Testar funcionamento
3. Repetir para outros controllers

### Etapa 3: Models

1. Migrar models para nova estrutura
2. Atualizar queries para usar Query Builder
3. Testar operações de banco

### Etapa 4: Views

1. Mover views para `App/resources/views/`
2. Atualizar sintaxe se necessário
3. Testar renderização

### Etapa 5: Rotas

1. Converter rotas antigas para nova sintaxe
2. Adicionar middlewares onde necessário
3. Testar todas as rotas

## Troubleshooting

### Erro: Class not found

- Verificar namespace correto
- Executar `composer dump-autoload`
- Verificar se arquivo está no local correto

### Erro: View not found

- Verificar se view está em `App/resources/views/`
- Verificar nome do arquivo
- Verificar configuração de paths

### Erro: Route not found

- Verificar definição da rota em `App/routes/web.php`
- Verificar se controller existe
- Verificar middleware de autenticação

## Benefícios Imediatos

1. **Desenvolvimento mais rápido**: Helpers e métodos facilitam tarefas comuns
2. **Código mais limpo**: Separação clara de responsabilidades
3. **Fácil manutenção**: Estrutura organizada e padronizada
4. **Melhor performance**: Carregamento otimizado de dependências
5. **Preparado para crescimento**: Arquitetura escalável

## Próximos Passos

Após a migração, considere implementar:

1. **Testes unitários**: Para garantir qualidade do código
2. **Sistema de cache**: Para melhorar performance
3. **Logs estruturados**: Para debug e monitoramento
4. **API endpoints**: Para integração com outras aplicações
5. **Documentação automática**: Para facilitar manutenção

## Suporte

Para dúvidas durante a migração:

1. Consulte este guia
2. Verifique a documentação no README.md
3. Analise exemplos nos controllers migrados
4. Teste pequenas partes por vez
