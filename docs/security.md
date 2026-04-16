# Security & Authorization Guide

This project uses a combination of Global Scopes (Multi-Tenancy) and Laravel Policies (RBAC) for strict data security.

## Roles & Permissions

| Role | Scope | Permissions |
| :--- | :--- | :--- |
| **Owner** | Workspace | Full control over workspace, settings, billing, and all users. |
| **Admin** | Workspace | Can manage projects, clients, and members. Cannot change owner or delete workspace. |
| **Member** | Workspace | Can create/manage projects and tasks. Access is limited by project assignment if enabled. |
| **Client** | Client-Specific | Read-only access to their own projects, invoices, and subscriptions via `ClientScoped`. |

## Authorization Strategy

### 1. Multi-Tenancy (First Line of Defense)
The `Tenantable` and `ClientScoped` traits act as automatic filters. They ensure a user *physically cannot* query data belonging to another workspace or client.

### 2. Policies (Second Line of Defense)
Use Laravel Policies for fine-grained action control (e.g., "Can this member delete this project?").

#### Example: `ProjectPolicy`
- `viewAny`: Allowed for all workspace members.
- `view`:
    - `owner`/`admin`: Always.
    - `member`: If assigned or "public" within workspace.
    - `client`: Only if `project.client_id` matches their `client_id`.
- `create`: `owner`, `admin`, `member`.
- `update`/`delete`: `owner`, `admin`, or original creator (`member`).

## Implementation Rules
- **Policy Requirement:** Every model must have a corresponding Policy class.
- **Middleware:** Always use the `auth` and workspace-validation middleware.
- **No Manual IDs:** Never trust a `workspace_id` passed from a form. Always rely on the `Tenantable` trait or session-derived values.
- **Gate-Checking:** Always use `$this->authorize()` in controllers or `wire:navigate` / `@can` in Blade components.
