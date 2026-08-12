<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# TaskPulse

A multi-tenant SaaS project & task management platform built with Laravel — designed to explore real-world patterns like workspace isolation, role-based access, and subscription billing.

## Overview

TaskPulse lets teams organize their work inside isolated **workspaces**, similar in spirit to tools like Linear or Trello. Users can belong to multiple workspaces, switch between them, and manage projects and tasks scoped entirely to whichever workspace is active — with no data leakage between tenants.

This project was built to practice designing and implementing a multi-tenant application architecture from the ground up, rather than relying on a starter kit or boilerplate for the tenancy layer.

## Features

- **Multi-tenant workspaces** — create, switch between, and manage multiple isolated workspaces
- **Project & task management** — a Trello-style board (To Do / In Progress / Done) with task assignment and due dates
- **Authentication** — registration, login, and email verification via Laravel Breeze
- **Automatic workspace scoping** — a custom middleware resolves the active workspace on every request, so all queries stay scoped without manual filtering
- **Billing-ready architecture** — Laravel Cashier (Stripe) wired at the workspace level for future subscription tiers

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP), SQLite |
| Frontend | Tailwind CSS, Alpine.js, Blade (via Vite) |
| Billing | Laravel Cashier (Stripe) |

## Architecture Highlights

**Workspace-aware middleware.** An `IdentifyWorkspace` middleware runs on every authenticated request. It resolves the user's active workspace from the session (falling back to their first workspace), binds it into the service container, and shares it with every view. This means controllers and views can call a simple `currentWorkspace()` helper instead of passing workspace context around manually — and every query stays correctly scoped to the right tenant.

**Role-based data model.** Workspace membership is modeled through a `workspace_user` pivot table with a `role` column (`admin`, `manager`, `member`). The schema is already role-aware; the current release enforces a single-role (admin) workflow, with granular permission checks planned as a near-term improvement (see Roadmap).

## Getting Started

```bash
git clone <your-repo-url>
cd taskpulse
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate

npm run build
php artisan serve
```

Visit `http://127.0.0.1:8000` and register a new account — a personal workspace is created automatically.

## Roadmap

- [ ] Team invitations with role assignment (admin / manager / member)
- [ ] Permission checks enforcing role-based access (e.g. only admins/managers can delete projects)
- [ ] Stripe-powered subscription billing per workspace
- [ ] Task comments and detail view
- [ ] Project archiving

## License

This project is open source and available for learning purposes.
