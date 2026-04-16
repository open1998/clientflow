# Multi-Tenancy & Isolation Guide

## Workspace Isolation
- This is a multi-tenant SaaS. Every tenant-owned record belongs to a `Workspace`.
- Use the `App\Traits\Tenantable` trait on all models that belong to a workspace.
- The `Tenantable` trait automatically:
    - Sets `workspace_id` on record creation (from `session('workspace_id')`).
    - Applies a global scope to filter all queries by the active `workspace_id`.

## Client Isolation
- Users with the `client` role are further restricted.
- Use the `App\Traits\ClientScoped` trait on models like `Project`, `Invoice`, and `Subscription`.
- This ensures clients only see data where the `client_id` matches their specific Client record within that workspace.

## Roles
- `owner`: Full workspace access.
- `admin`: Management access.
- `member`: Staff access.
- `client`: External access (restricted by `ClientScoped`).
