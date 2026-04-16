# Database & Models Guide

## ER Diagram (Mermaid)

```mermaid
erDiagram
    User ||--o{ Workspace : "owns (owner_id)"
    User ||--o{ WorkspaceUser : "belongs to"
    Workspace ||--o{ WorkspaceUser : "has member"
    Workspace ||--o{ Client : "has"
    Workspace ||--o{ Project : "has"
    Workspace ||--o{ Task : "has (redundant FK)"
    Workspace ||--o{ TimeEntry : "has"
    Workspace ||--o{ Subscription : "has"
    Workspace ||--o{ Invoice : "has"
    Workspace ||--o{ Invitation : "has"

    User ||--o{ Client : "can login as"
    Client ||--o{ Project : "has"
    Client ||--o{ Subscription : "has"
    Client ||--o{ Invoice : "billed to"

    Project ||--o{ Task : "has"
    Task ||--o{ TimeEntry : "tracks"
    User ||--o{ TimeEntry : "logs"

    Subscription ||--o{ Invoice : "generates"
    Invoice ||--o{ InvoiceItem : "contains"
    
    User ||--o{ Invitation : "inviter"
```

## UUID Primary Keys
- Every model must use `Illuminate\Database\Eloquent\Concerns\HasUuids`.
- `protected $keyType = 'string';`
- `public $incrementing = false;`

## Migrations
- Use `$table->uuid('id')->primary();` for primary keys.
- Use `$table->foreignUuid('xxx_id')->index();` for foreign keys.
- **CRITICAL:** NEVER use `->constrained()` on UUID foreign keys. PostgreSQL often fails with self-referencing or circular UUID dependencies. Handle referential integrity at the application level.
- Always include `$table->softDeletes();`.

## PostgreSQL Compatibility
- While local tests use SQLite, all Eloquent code and migrations MUST be 100% compatible with PostgreSQL.
- Avoid using DB-specific functions (like `json_contains`) directly; prefer Eloquent abstractions.
