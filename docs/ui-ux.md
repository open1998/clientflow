# UI/UX & Styling Guide

## Tailwind CSS v4
- Use Tailwind v4 patterns exclusively.
- Avoid long, messy class stacks in templates. Use `@apply` in CSS files for reusable UI patterns.
- Check existing classes before creating new ones to avoid duplication.

## Components
- **Breeze:** Use latest Blade component patterns (`<x-card>`, etc.).
- **Layouts:** Use `{{ $slot }}` and Blade components. **NEVER** use `@extends` or `@yield`.
- **FluxUI:** Utilize FluxUI components for high-quality interactive elements.
- **Shadcn Inspired:** Follow Shadcn aesthetics for the dashboard UI.

## Design Tokens
- Follow design tokens strictly.
- Tokens should be defined in a central location (e.g., `resources/css/design-tokens.css`).
- Use token variables instead of hardcoded hex values or spacing.
