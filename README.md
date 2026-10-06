# Saúde Caxias

**Projeto Integrador IV-A — 2026/3**  
**Curso:** Análise e Desenvolvimento de Sistemas — Universidade de Caxias do Sul (UCS)

## Sobre o projeto

O **Saúde Caxias** é uma aplicação web desenvolvida para facilitar a consulta e a visualização de informações epidemiológicas relacionadas a doenças e agravos de saúde no município de Caxias do Sul/RS.

O sistema foi desenvolvido a partir das histórias definidas no backlog da sprint do Projeto Integrador e contempla três funcionalidades principais:

- **H1 — Consultar doenças e agravos de saúde:** permite selecionar uma doença e visualizar informações e totais relacionados a ela.
- **H2 — Visualizar dados estatísticos:** permite selecionar uma doença e um período para consultar totais e visualizar os resultados em gráfico.
- **H3 — Comparar doenças:** permite selecionar um período e comparar a quantidade de casos entre diferentes doenças.

## Tecnologias utilizadas

- **PHP** — desenvolvimento da aplicação web;
- **PostgreSQL** — armazenamento dos dados;
- **PDO / pdo_pgsql** — conexão entre PHP e PostgreSQL;
- **HTML e CSS** — estrutura e apresentação das telas;
- **SQL** — criação do banco, inserção dos dados e realização das consultas.

A aplicação não utiliza framework externo. A estrutura foi mantida simples para facilitar a execução, manutenção e demonstração das funcionalidades propostas no projeto.

## Organização da aplicação

A aplicação é organizada em páginas PHP correspondentes às funcionalidades do sistema, com conexão ao banco centralizada em `db.php`, funções auxiliares em `functions.php`, componentes de interface reutilizados em `header.php` e `footer.php` e scripts SQL separados na pasta `sql`.

O banco de dados utiliza as entidades principais:

- **doenca** — informações sobre doenças e agravos;
- **localidade** — identificação do município analisado;
- **dados_notificacao** — registros epidemiológicos por doença, localidade e período.

## Fonte e dados utilizados

A fonte prevista para os dados do projeto é o **DATASUS — Sistema de Informação de Agravos de Notificação (SINAN/TABNET)**.

Para desenvolvimento, testes e demonstração da versão apresentada nesta etapa foram utilizados **dados simulados**, identificados dessa forma no projeto. Esses valores não devem ser interpretados como estatísticas epidemiológicas oficiais.

O arquivo `sql/02_seed.sql` gera 480 registros de teste, correspondentes a 8 doenças distribuídas mensalmente entre os anos de 2020 e 2024.

## Como executar o projeto

### 1. Criar o banco de dados

No PostgreSQL, por meio do pgAdmin ou `psql`, crie o banco:

```sql
CREATE DATABASE saude_caxias;
```

Depois conecte-se ao banco `saude_caxias` e execute os scripts na seguinte ordem:

1. `sql/01_schema.sql`
2. `sql/02_seed.sql`

Também está disponível o arquivo `sql/00_criar_banco.sql` com o comando de criação do banco.

### 2. Configurar a conexão

Abra o arquivo `db.php` e ajuste os dados de conexão de acordo com a instalação local do PostgreSQL:

```php
$host = 'localhost';
$port = '5432';
$db   = 'saude_caxias';
$user = 'postgres';
$pass = 'postgres';
```

A senha deve ser substituída pela senha configurada no PostgreSQL utilizado para executar o projeto.

### 3. Executar a aplicação

É necessário possuir o PHP instalado e a extensão `pdo_pgsql` habilitada.

Dentro da pasta do projeto, execute:

```bash
php -S localhost:8000
```

Depois acesse no navegador:

```text
http://localhost:8000
```

### Execução com XAMPP ou Laragon

Também é possível colocar a pasta do projeto em `htdocs` (XAMPP) ou `www` (Laragon) e executá-la pelo Apache. Nesse caso, é necessário verificar no `php.ini` se as extensões `pgsql` e `pdo_pgsql` estão habilitadas.

## Estrutura de arquivos

```text
saude_caxias/
├── index.php
├── consultar.php
├── estatisticas.php
├── comparar.php
├── db.php
├── functions.php
├── header.php
├── footer.php
├── assets/
│   └── style.css
└── sql/
    ├── 00_criar_banco.sql
    ├── 01_schema.sql
    └── 02_seed.sql
```

## Integrantes do grupo

- **José Roberto da Veiga Bazzi** — Scrum Master
- **Kevin Rennan Tozo Francisco** — Product Owner
- **Oliver Kayan de Almeida Lopes** — Desenvolvedor
- **Gabriel Richter** — Desenvolvedor
- **Alisson Alves Fischer** — Desenvolvedor

## Observação

O objetivo desta versão é demonstrar de forma funcional as três histórias priorizadas no backlog da sprint, mantendo a implementação compatível com o escopo definido para o Projeto Integrador.
