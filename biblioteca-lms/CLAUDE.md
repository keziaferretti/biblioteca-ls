CLAUDE.md — Diretrizes do Projeto: Biblioteca LMS
🧠 Papel e Comportamento
Você atuará como um Engenheiro de Software Full-Stack Sênior especialista em Laravel 12.
Construa de forma autônoma, completa e sem placeholders (`// TODO`, `// ...`). Se encontrar erros, corrija-os autonomamente antes de continuar.
---
🛠️ Stack Tecnológica
Camada	Tecnologia
Back-end	Laravel 12 + PHP 8.2+
Banco	MySQL (via Laravel Herd local)
Servidor	Laravel Herd / `php artisan serve`
Front-end	Blade Templates + Bootstrap 5 + Vanilla JS
UI / Design	Paleta Azul Escuro (`#1e293b`) + Laranja (`#f97316`)
---
📁 Estrutura de Diretórios
```
app/
├── Http/
│   ├── Controllers/
│   │   └── {Módulo}/
│   │       └── {Entidade}Controller.php
│   ├── Requests/
│   │   └── {Módulo}/
│   │       └── {Entidade}Request.php
│   └── Interfaces/
│       ├── Controllers/
│       │   └── {Entidade}ControllerInterface.php
│       ├── Requests/
│       │   └── {Entidade}RequestInterface.php
│       └── Services/
│           └── {Entidade}ServiceInterface.php
├── Services/
│   └── {Entidade}Service.php
├── DTOs/
│   └── {Entidade}DTO.php
├── Models/
│   └── {Entidade}.php
└── Support/
    ├── DefaultReturnType.php
    └── ExceptionWithData.php
```
---
📐 Padrão de Arquitetura (OBRIGATÓRIO)
1. Models
   Estendem `Model` e implementam a interface correspondente quando aplicável.
   Usam `CamelCasing` via trait: colunas no banco em `snake_case` (ex: `exemplar_test`), acessadas via `camelCase` (ex: `$model->exemplarTest`).
   Atributos e relacionamentos em inglês.
   Sempre definir `$table`, `$fillable` e `$casts` explicitamente.
```php
class Book extends Model
{
    use HasFactory, CamelCasing;

    protected $table    = 'books';
    protected $fillable = ['title', 'isbn', 'publication_year', 'available_copies', 'publisher_id'];
    protected $casts    = ['publication_year' => 'integer', 'available_copies' => 'integer'];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
}
```
---
2. Migrations
   Nomes de tabelas em `snake_case` plural e em inglês (ex: `books`, `loan_items`).
   Colunas em `snake_case` e em inglês.
   Chaves estrangeiras com `constrained()->cascadeOnDelete()` ou `restrictOnDelete()` conforme a regra de negócio.
```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->string('title', 200);
    $table->string('isbn', 20)->unique();
    $table->unsignedSmallInteger('publication_year');
    $table->unsignedInteger('available_copies')->default(0);
    $table->foreignId('publisher_id')->constrained('publishers')->restrictOnDelete();
    $table->timestamps();
    $table->softDeletes();
});
```
---
3. Interfaces
   Toda entidade deve ter 3 interfaces:
   ControllerInterface — define os métodos HTTP públicos:
```php
interface BookControllerInterface
{
    public function index(): View;
    public function store(BookRequestInterface $request): JsonResponse;
    public function update(BookRequestInterface $request, int $id): JsonResponse;
    public function destroy(int $id): JsonResponse;
}
```
RequestInterface — contrato do FormRequest:
```php
interface BookRequestInterface
{
    public function authorize(): bool;
    public function rules(): array;
    public function attributes(): array;
    public function toDTO(): BookDTOInterface;
}
```
ServiceInterface — contrato do Service:
```php
interface BookServiceInterface
{
    public function list(): DefaultReturnType;
    public function create(BookDTOInterface $dto): DefaultReturnType;
    public function update(BookDTOInterface $dto, int $id): DefaultReturnType;
    public function delete(int $id): DefaultReturnType;
}
```
---
4. FormRequests
   Estendem `FormRequest` e implementam `{Entidade}RequestInterface`.
   `prepareForValidation()` para higienizar/normalizar dados antes da validação.
   `attributes()` com nomes amigáveis em português para mensagens de erro.
   `toDTO()` retorna o DTO tipado.
```php
class BookRequest extends FormRequest implements BookRequestInterface
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => 'required|string|max:200',
            'isbn'            => 'required|string|max:20|unique:books,isbn,' . $this->route('id'),
            'publicationYear' => 'required|integer|min:1500|max:' . date('Y'),
            'availableCopies' => 'required|integer|min:0',
            'publisherId'     => 'required|integer|exists:publishers,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'isbn' => preg_replace('/[^0-9X]/', '', strtoupper($this->isbn ?? '')),
        ]);
    }

    public function attributes(): array
    {
        return [
            'title'           => 'Título',
            'isbn'            => 'ISBN',
            'publicationYear' => 'Ano de Publicação',
            'availableCopies' => 'Exemplares Disponíveis',
            'publisherId'     => 'Editora',
        ];
    }

    public function toDTO(): BookDTOInterface
    {
        return BookDTO::fromRequest($this);
    }
}
```
---
5. DTOs
   Classes `readonly` com construtor tipado.
   Método estático `fromRequest(FormRequest $request)` e `fromArray(array $data)`.
   Atributos em inglês e `camelCase`.
   Método `toArray()` quando necessário para persistência.
```php
readonly class BookDTO implements BookDTOInterface
{
    public function __construct(
        public string  $title,
        public string  $isbn,
        public int     $publicationYear,
        public int     $availableCopies,
        public int     $publisherId,
        public ?int    $id = null,
    ) {}

    public static function fromRequest(BookRequest $request): self
    {
        return new self(
            title:           $request->input('title'),
            isbn:            $request->input('isbn'),
            publicationYear: (int) $request->input('publicationYear'),
            availableCopies: (int) $request->input('availableCopies'),
            publisherId:     (int) $request->input('publisherId'),
            id:              $request->route('id'),
        );
    }

    public function toArray(): array
    {
        return [
            'title'            => $this->title,
            'isbn'             => $this->isbn,
            'publication_year' => $this->publicationYear,
            'available_copies' => $this->availableCopies,
            'publisher_id'     => $this->publisherId,
        ];
    }
}
```
---
6. Services
   Implementam `{Entidade}ServiceInterface`.
   Recebem DTOs, executam regras de negócio, retornam `DefaultReturnType`.
   Nunca acessam `$request` diretamente — apenas DTOs.
   Exceções de negócio devem ser lançadas com mensagens descritivas.
```php
class BookService implements BookServiceInterface
{
    public function __construct(private Book $model) {}

    public function create(BookDTOInterface $dto): DefaultReturnType
    {
        $book = $this->model->create($dto->toArray());

        return DefaultReturnType::create()
            ->setMessage('Livro cadastrado com sucesso!')
            ->setData($book->toArray());
    }

    public function delete(int $id): DefaultReturnType
    {
        $book = $this->model->findOrFail($id);

        if ($book->availableCopies < $book->totalCopies) {
            throw new \RuntimeException('Não é possível excluir um livro com exemplares emprestados.');
        }

        $book->delete();

        return DefaultReturnType::create()->setMessage('Livro excluído com sucesso!');
    }
}
```
---
7. Controllers
   Estendem `Controller` e implementam `{Entidade}ControllerInterface`.
   Injetam apenas `{Entidade}ServiceInterface` no construtor.
   Todo bloco de ação envolto em `try/catch` com `ExceptionWithData`.
   Métodos de listagem retornam `View`; mutações retornam `JsonResponse`.
```php
class BookController extends Controller implements BookControllerInterface
{
    public function __construct(private BookServiceInterface $service) {}

    public function index(): View
    {
        return $this->service->list()->toView('books.index');
    }

    public function store(BookRequestInterface $request): JsonResponse
    {
        try {
            return $this->service->create(bookDTO: $request->toDTO())->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function update(BookRequestInterface $request, int $id): JsonResponse
    {
        try {
            return $this->service->update(bookDTO: $request->toDTO(), id: $id)->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            return $this->service->delete(id: $id)->toJsonResponse();
        } catch (Exception $e) {
            return ExceptionWithData::create($e)->toJsonResponse();
        }
    }
}
```
---
8. DefaultReturnType
   Classe de envelope de resposta padrão:
```php
class DefaultReturnType
{
    private string $message = '';
    private mixed  $data    = null;
    private int    $status  = 200;

    public static function create(): self
    {
        return new self();
    }

    public function setMessage(string $message): self { $this->message = $message; return $this; }
    public function setData(mixed $data): self         { $this->data    = $data;    return $this; }
    public function setStatus(int $status): self       { $this->status  = $status;  return $this; }

    public function toJsonResponse(): JsonResponse
    {
        return response()->json(['message' => $this->message, 'data' => $this->data], $this->status);
    }

    public function toView(string $view, array $extra = []): View
    {
        return view($view, array_merge(['data' => $this->data, 'message' => $this->message], $extra));
    }
}
```
9. ExceptionWithData
```php
class ExceptionWithData
{
    private function __construct(private readonly Throwable $exception) {}

    public static function create(Throwable $e): self
    {
        return new self($e);
    }

    public function toJsonResponse(): JsonResponse
    {
        $status = $this->exception->getCode() >= 400 ? $this->exception->getCode() : 500;

        return response()->json([
            'message' => $this->exception->getMessage(),
            'data'    => null,
        ], $status);
    }
}
```
---
🗄️ Banco de Dados
Convenções
Item	Convenção	Exemplo
Nome da tabela	`snake_case` plural, inglês	`books`, `loan_records`
Nome de coluna	`snake_case`, inglês	`available_copies`
Acesso no PHP	`camelCase` via trait `CamelCasing`	`$book->availableCopies`
Chave estrangeira	`{tabela_singular}_id`	`publisher_id`, `book_id`
Regras de Negócio (Loans)
Ao criar empréstimo: `books.available_copies -= 1` (validar se `> 0`).
Ao registrar devolução: `books.available_copies += 1`.
Status possíveis: `active`, `returned`, `overdue`.
Campo `returned_at` nullable; preenchido apenas na devolução.
---
🎨 Front-end (Blade + Bootstrap 5)
Paleta de Cores (CSS Variables no `app.blade.php`)
```css
:root {
    --color-primary:    #1e293b;   /* Azul escuro — sidebar, navbar */
    --color-secondary:  #0f172a;   /* Azul mais escuro — hover, fundo */
    --color-accent:     #f97316;   /* Laranja — botões primários, badges */
    --color-accent-dk:  #ea580c;   /* Laranja escuro — hover dos botões */
    --color-text-light: #f8fafc;
    --color-muted:      #94a3b8;
}
```
Layout Base (`layouts/app.blade.php`)
Sidebar fixa com navegação por módulo.
Navbar superior com nome do usuário e logout.
`@yield('content')` no corpo principal.
Alertas flash (`session('success')`, `session('error')`) com Bootstrap Toast.
Views por Módulo
View	Requisitos
`index`	Tabela responsiva Bootstrap, paginação Laravel nativa, botões Visualizar / Editar / Excluir
`create/edit`	Formulário com validação front-end HTML5 + exibição de erros do `$errors` do Laravel
`show`	Cards com todos os atributos, botão Voltar
`dashboard`	Cards: Total Livros, Empréstimos Ativos, Clientes Cadastrados, Livros Atrasados
Regras de UI
Botão primário: `background: var(--color-accent)`, `color: white`.
Tabelas: listras alternadas via `table-striped`, hover destacado.
Erros de validação: `<div class="invalid-feedback">` abaixo de cada input.
Badges de status: `active` → verde, `overdue` → vermelho, `returned` → cinza.
---
🤖 Instruções de Execução Autônoma
Siga esta sequência ao iniciar ou evoluir o projeto:
Varrer a estrutura atual com `ls -la` e `cat .env` para entender o estado do projeto.
Criar nesta ordem para cada entidade: Interface → DTO → Request → Model → Migration → Service → Controller → View.
Registrar bindings no `AppServiceProvider` (`$this->app->bind(Interface::class, Concreto::class)`).
Registrar rotas em `routes/web.php` agrupadas por módulo com `Route::resource()` ou rotas nomeadas explícitas.
Executar `php artisan migrate --seed` e corrigir qualquer falha antes de continuar.
Exportar o dump SQL: `mysqldump -u root biblioteca_lms > database_backup.sql`.
Validar acessando as rotas principais. Se houver erro 500, consultar `storage/logs/laravel.log` e corrigir.
---
✅ Checklist por Entidade
Ao criar ou modificar qualquer entidade, confirmar que todos os itens estão presentes:
[ ] `{Entidade}ControllerInterface`
[ ] `{Entidade}RequestInterface`
[ ] `{Entidade}ServiceInterface`
[ ] `{Entidade}DTOInterface`
[ ] `{Entidade}DTO` (readonly class)
[ ] `{Entidade}Request` (extends FormRequest)
[ ] `{Entidade}Service`
[ ] `{Entidade}Controller`
[ ] `{Entidade}` Model (com `CamelCasing`, `$fillable`, `$casts`, relacionamentos)
[ ] Migration com FK e `softDeletes()` quando aplicável
[ ] Factory + Seeder com dados realistas
[ ] Binding no `AppServiceProvider`
[ ] Rotas registradas em `routes/web.php`
[ ] Views: `index`, `create`, `edit`, `show`
---
⚠️ Restrições e Proibições
❌ Nunca colocar regras de negócio no Controller.
❌ Nunca acessar `$request` dentro de um Service ou DTO.
❌ Nunca usar `array` genérico como retorno de Service — sempre `DefaultReturnType`.
❌ Nunca deixar métodos vazios, stubs ou comentários `// TODO`.
❌ Nunca usar nomes de variáveis ou colunas em português no código PHP/SQL.
✅ Português apenas em: mensagens de resposta (`setMessage()`), labels de `attributes()`, textos de Views.