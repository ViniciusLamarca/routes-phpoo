# Routes PHP-OO - Sistema Modular e Escalável

## Visão Geral

Este projeto foi reestruturado para ser mais modular, escalável e seguir as melhores práticas de desenvolvimento PHP. Mantém todas as funcionalidades originais enquanto melhora significativamente a arquitetura.

## Principais Melhorias

### 1. Arquitetura Modular

- **Container de Injeção de Dependências**: Gerenciamento automático de dependências
- **Service Providers**: Registro modular de serviços
- **Separação de Responsabilidades**: Cada classe tem uma responsabilidade específica

### 2. Sistema de Roteamento Avançado

- **Rotas Nomeadas**: Fácil referenciamento de rotas
- **Middleware**: Aplicação de filtros de forma modular
- **Parâmetros de Rota**: Suporte a rotas dinâmicas
- **Agrupamento de Rotas**: Organização lógica com middlewares compartilhados

### 3. Camada de Dados Aprimorada

- **Query Builder**: Construção fluente de consultas
- **Modelos Eloquentes**: Interação simplificada com banco de dados
- **Conexões Múltiplas**: Suporte a múltiplos bancos de dados
- **Transações**: Controle de transações automático

### 4. Sistema HTTP Robusto

- **Request/Response Objects**: Manipulação estruturada de HTTP
- **Validação Integrada**: Validação de entrada automática
- **Middlewares**: Filtros de requisições
- **Respostas JSON**: Suporte nativo para APIs

## Estrutura do Projeto

```
App/
├── bootstrap/          # Inicialização da aplicação
├── config/            # Arquivos de configuração
├── Controllers/       # Controllers da aplicação
├── Core/              # Núcleo do framework
│   ├── Container/     # Container de injeção de dependências
│   ├── Database/      # Gerenciamento de banco de dados
│   ├── Http/          # Classes HTTP (Request/Response)
│   ├── Router/        # Sistema de roteamento
│   ├── Session/       # Gerenciamento de sessões
│   └── View/          # Sistema de views
├── Database/          # Modelos e migrations
│   └── Models/        # Modelos Eloquent
├── Middleware/        # Middlewares da aplicação
├── resources/         # Recursos da aplicação
│   └── views/         # Templates das views
├── routes/            # Definição de rotas
└── helpers/           # Funções auxiliares
```

## Instalação

1. **Clone o repositório**

```bash
git clone [url-do-repositorio]
cd routes-phpoo
```

2. **Instale as dependências**

```bash
composer install
```

3. **Configure o ambiente**

```bash
cp .env.example .env
# Edite o arquivo .env com suas configurações
```

4. **Configure o servidor web**
   Aponte o documento root para a pasta `public/`

## Configuração

### Variáveis de Ambiente

Copie o arquivo `.env.example` para `.env` e configure as seguintes variáveis:

```env
# Application
APP_NAME="Routes PHP-OO"
APP_ENV=local
APP_DEBUG=true
BASE_URL=/PHP-POO/routes-phpoo/public

# Database
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=service_db
DB_USERNAME=root
DB_PASSWORD=

# WebSocket
WS_HOST=127.0.0.1
WS_PORT=8080
```

## Uso

### Definindo Rotas

```php
// App/routes/web.php
$router->get('/', 'HomeController@index')->name('home');
$router->post('/login', 'AuthController@authenticate');

// Rotas com middleware
$router->group(['middleware' => [AuthMiddleware::class]], function($router) {
    $router->get('/dashboard', 'DashboardController@index');
    $router->get('/users/{id}', 'UserController@show');
});
```

### Criando Controllers

```php
<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Response;

class ExampleController extends BaseController
{
    public function index(Request $request): Response
    {
        $data = ['message' => 'Hello World'];

        return $this->json($data);
    }

    public function show(Request $request, string $id): Response
    {
        $content = $this->render('example/show', ['id' => $id]);

        return $this->response($content);
    }
}
```

### Usando Modelos

```php
<?php

namespace App\Database\Models;

class Product extends BaseModel
{
    protected string $table = 'products';

    protected array $fillable = ['name', 'price', 'description'];

    public function getExpensiveProducts(): array
    {
        return $this->where('price', '>', 100)->get();
    }
}

// Uso
$product = new Product();
$products = $product->where('active', true)->get();
$expensiveProducts = $product->getExpensiveProducts();
```

### Middleware

```php
<?php

namespace App\Middleware;

use App\Core\Http\Request;

class ExampleMiddleware
{
    public function handle(Request $request): void
    {
        // Lógica do middleware
        if (!$request->has('api_key')) {
            throw new \Exception('API key required');
        }
    }
}
```

## Funcionalidades Mantidas

- ✅ Sistema de autenticação
- ✅ Gerenciamento de usuários
- ✅ CRUD de produtos
- ✅ Chat em tempo real (WebSocket)
- ✅ Interface Bootstrap
- ✅ Sistema de notificações
- ✅ Todas as views existentes

## Benefícios da Nova Estrutura

1. **Manutenibilidade**: Código mais organizado e fácil de manter
2. **Testabilidade**: Arquitetura que facilita testes unitários
3. **Escalabilidade**: Estrutura preparada para crescimento
4. **Reutilização**: Componentes reutilizáveis
5. **Padronização**: Seguir padrões da comunidade PHP
6. **Performance**: Carregamento otimizado de dependências

## Compatibilidade

A nova estrutura mantém total compatibilidade com:

- PHP 8.0+
- Todas as funcionalidades existentes
- Interface visual atual
- Banco de dados atual
- Sistema de chat WebSocket

## Próximos Passos

Para aproveitar ao máximo a nova estrutura, considere:

1. Migrar controllers existentes para a nova estrutura
2. Implementar testes unitários
3. Adicionar cache para melhor performance
4. Implementar sistema de logs
5. Adicionar validação de formulários mais robusta
6. Implementar sistema de migrations para banco de dados

## Suporte

Para dúvidas ou problemas, consulte a documentação do código ou entre em contato com o desenvolvedor.
