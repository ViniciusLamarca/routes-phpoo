# Sistema de Versionamento de Banco de Dados

Este sistema permite **versionar e fazer backup** da estrutura e dados do seu banco MySQL de forma automatizada.

## 🏗️ **Estrutura de Diretórios**

```
App/Database/Schema/
├── versions/           # Versões do schema (apenas estrutura)
│   ├── latest.sql     # Última versão exportada
│   ├── schema_v1.0.sql
│   └── versions.json  # Histórico de versões
├── backups/           # Backups completos (estrutura + dados)
│   ├── backup_2024_01_15.sql.gz
│   └── producao_2024.sql.gz
└── DatabaseSchema.php # Classe principal
```

## 🌐 **Interface Web**

Acesse: `http://localhost/PHP-POO/routes-phpoo/public/database`

### Funcionalidades:

- ✅ **Exportar Schema Atual** - Salva apenas a estrutura das tabelas
- ✅ **Aplicar Versão** - Restaura estrutura de uma versão específica
- 💾 **Criar Backup** - Salva estrutura + todos os dados
- 🔄 **Restaurar Backup** - Restaura backup completo
- 📋 **Listar Versões** - Visualiza todas as versões salvas

## 🖥️ **Linha de Comando (CLI)**

```bash
# Exportar estrutura atual
php database_cli.php export v1.0

# Importar estrutura específica
php database_cli.php import v1.0

# Criar backup completo
php database_cli.php backup producao_2024

# Restaurar backup
php database_cli.php restore backup_2024_01_15.sql.gz

# Listar versões disponíveis
php database_cli.php list

# Listar backups disponíveis
php database_cli.php list-backups

# Informações do banco atual
php database_cli.php info
```

## 🔥 **Casos de Uso**

### **1. Antes de fazer mudanças:**

```bash
# Exportar versão atual
php database_cli.php export stable_antes_mudancas

# Fazer backup completo
php database_cli.php backup antes_mudancas_$(date +%Y%m%d)
```

### **2. Versionamento durante desenvolvimento:**

```bash
# Exportar cada versão importante
php database_cli.php export v1.0_usuarios
php database_cli.php export v1.1_produtos
php database_cli.php export v1.2_chat
```

### **3. Recuperação de desastres:**

```bash
# Restaurar estrutura da última versão estável
php database_cli.php import stable_antes_mudancas

# Ou restaurar backup completo
php database_cli.php restore backup_producao_20240115.sql.gz
```

### **4. Deploy em produção:**

```bash
# Exportar versão de desenvolvimento
php database_cli.php export dev_v2.0

# Aplicar em produção
php database_cli.php import dev_v2.0
```

## ⚠️ **Diferenças Importantes**

| Funcionalidade | Schema (Estrutura)           | Backup (Completo)          |
| -------------- | ---------------------------- | -------------------------- |
| **Conteúdo**   | Apenas estrutura das tabelas | Estrutura + todos os dados |
| **Tamanho**    | Pequeno (~KB)                | Grande (MB/GB)             |
| **Velocidade** | Rápido                       | Lento (depende dos dados)  |
| **Uso**        | Versionamento de estrutura   | Backup de segurança        |
| **Risco**      | Baixo                        | Alto (sobrescreve dados)   |

## 🛡️ **Segurança**

- ✅ Confirmação obrigatória antes de restaurar
- ✅ Backups comprimidos automaticamente (.gz)
- ✅ Histórico completo de versões (JSON)
- ✅ Validação de arquivos antes da aplicação
- ✅ Logs de erro em `logs/error.log`

## 🚀 **Workflow Recomendado**

1. **Desenvolvimento**: Exportar schema a cada mudança importante
2. **Testes**: Aplicar versões para testar migrações
3. **Produção**: Backup completo antes de mudanças
4. **Deploy**: Aplicar schema da versão testada
5. **Manutenção**: Backups regulares agendados

## 📊 **Exemplo de Versionamento**

```json
{
  "version": "2024_01_15_14_30_25",
  "filename": "schema_v2024_01_15_14_30_25.sql",
  "created_at": "2024-01-15 14:30:25",
  "description": "Schema version 2024_01_15_14_30_25"
}
```

---

## 🔧 **Instalação e Configuração**

1. **Configurar rotas** - Já incluído em `Routes.php`
2. **Permissões** - Criar diretórios automaticamente
3. **Banco** - Usar conexão existente em `connection.php`
4. **Web** - Acessar `/database` no navegador
5. **CLI** - Executar `php database_cli.php` no terminal

**✅ Sistema pronto para usar!**
