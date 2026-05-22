<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Biblioteca LMS')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --color-primary:    #1e293b;
            --color-secondary:  #0f172a;
            --color-accent:     #f97316;
            --color-accent-dk:  #ea580c;
            --color-text-light: #f8fafc;
            --color-muted:      #94a3b8;
        }

        html, body { height: 100%; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .app-shell { display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px;
            background-color: var(--color-primary);
            color: var(--color-text-light);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar .brand {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-weight: 700;
            font-size: 1.1rem;
        }
        .sidebar .brand i { color: var(--color-accent); margin-right: .5rem; }
        .sidebar .nav-link {
            color: var(--color-text-light);
            padding: .65rem 1rem;
            display: flex;
            align-items: center;
            gap: .55rem;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link i { width: 1.2rem; text-align: center; }
        .sidebar .nav-link:hover {
            background-color: var(--color-secondary);
            color: var(--color-text-light);
        }
        .sidebar .nav-link.active {
            background-color: var(--color-secondary);
            border-left-color: var(--color-accent);
            color: var(--color-text-light);
            font-weight: 600;
        }
        .sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            font-size: .8rem;
            color: var(--color-muted);
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .main-content { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: .65rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .page-title { font-weight: 600; color: var(--color-primary); margin: 0; }
        .topbar .user-info { color: var(--color-muted); font-size: .9rem; }

        .content-area { padding: 1.5rem; flex: 1; }

        .btn-primary-accent {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: #ffffff;
        }
        .btn-primary-accent:hover,
        .btn-primary-accent:focus {
            background-color: var(--color-accent-dk);
            border-color: var(--color-accent-dk);
            color: #ffffff;
        }

        .btn-outline-primary-accent {
            color: var(--color-accent);
            border-color: var(--color-accent);
            background-color: transparent;
        }
        .btn-outline-primary-accent:hover {
            background-color: var(--color-accent);
            color: #ffffff;
        }

        .card-stat {
            border: none;
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(15,23,42,0.06);
        }
        .card-stat .stat-label { color: var(--color-muted); font-size: .85rem; text-transform: uppercase; letter-spacing: .04em; }
        .card-stat .stat-value { font-size: 2rem; font-weight: 700; color: var(--color-primary); }
        .card-stat .stat-icon { font-size: 2rem; color: var(--color-accent); }

        .table thead th {
            background-color: var(--color-primary);
            color: var(--color-text-light);
            border-bottom: none;
            font-weight: 600;
        }
        .table-hover tbody tr:hover { background-color: #fff7ed; }

        .badge-status-active   { background-color: #16a34a; }
        .badge-status-returned { background-color: #64748b; }
        .badge-status-overdue  { background-color: #dc2626; }

        .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 1080; }

        .invalid-feedback.d-block { display: block !important; }

        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar .brand span,
            .sidebar .nav-link span,
            .sidebar .sidebar-footer { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand"><i class="bi bi-book-half"></i><span>Biblioteca LMS</span></div>
        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('dashboard')      ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('publishers.*')  ? 'active' : '' }}" href="{{ route('publishers.index') }}">
                <i class="bi bi-building"></i><span>Editoras</span>
            </a>
            <a class="nav-link {{ request()->routeIs('books.*')       ? 'active' : '' }}" href="{{ route('books.index') }}">
                <i class="bi bi-journal-bookmark"></i><span>Livros</span>
            </a>
            <a class="nav-link {{ request()->routeIs('customers.*')   ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-people"></i><span>Clientes</span>
            </a>
            <a class="nav-link {{ request()->routeIs('loans.*')       ? 'active' : '' }}" href="{{ route('loans.index') }}">
                <i class="bi bi-arrow-left-right"></i><span>Empréstimos</span>
            </a>
        </nav>
        <div class="sidebar-footer">© {{ date('Y') }} Biblioteca LMS</div>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <h1 class="page-title">@yield('page-title', 'Painel')</h1>
            <div class="user-info">
                <i class="bi bi-person-circle"></i>
                <span>Bibliotecário</span>
            </div>
        </header>

        <main class="content-area">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<div class="toast-container" id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const bg        = type === 'success' ? 'text-bg-success' : 'text-bg-danger';
        const wrapper   = document.createElement('div');
        wrapper.innerHTML = `
            <div class="toast align-items-center ${bg} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
        const toastEl = wrapper.firstElementChild;
        container.appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    async function submitJsonForm(form, options = {}) {
        const method      = (options.method || form.dataset.method || form.method || 'POST').toUpperCase();
        const url         = options.url || form.dataset.url || form.action;
        const redirectTo  = options.redirectTo || form.dataset.redirect;
        const formData    = new FormData(form);
        const body        = {};
        formData.forEach((value, key) => { body[key] = value; });

        clearErrors(form);

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type':     'application/json',
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     window.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
            });

            const data = await res.json().catch(() => ({}));

            if (res.ok) {
                showToast(data.message || 'Operação realizada com sucesso!', 'success');
                if (redirectTo) {
                    setTimeout(() => { window.location.href = redirectTo; }, 800);
                }
                return data;
            }

            if (res.status === 422 && data.errors) {
                applyValidationErrors(form, data.errors);
            }
            showToast(data.message || 'Erro ao processar requisição.', 'danger');
            return null;
        } catch (err) {
            showToast('Erro de rede: ' + err.message, 'danger');
            return null;
        }
    }

    function applyValidationErrors(form, errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (!input) return;
            input.classList.add('is-invalid');
            let feedback = input.parentElement.querySelector('.invalid-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback d-block';
                input.parentElement.appendChild(feedback);
            }
            feedback.textContent = Array.isArray(messages) ? messages[0] : messages;
        });
    }

    function clearErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }

    async function confirmAndDelete(url, redirectTo) {
        if (!confirm('Tem certeza que deseja excluir este registro?')) return;
        try {
            const res = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     window.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const data = await res.json().catch(() => ({}));
            if (res.ok) {
                showToast(data.message || 'Excluído com sucesso!', 'success');
                setTimeout(() => { window.location.href = redirectTo || window.location.href; }, 800);
            } else {
                showToast(data.message || 'Erro ao excluir.', 'danger');
            }
        } catch (err) {
            showToast('Erro de rede: ' + err.message, 'danger');
        }
    }

    async function returnLoan(url, redirectTo) {
        if (!confirm('Confirmar devolução deste empréstimo?')) return;
        try {
            const res = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     window.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const data = await res.json().catch(() => ({}));
            if (res.ok) {
                showToast(data.message || 'Devolução registrada!', 'success');
                setTimeout(() => { window.location.href = redirectTo || window.location.href; }, 800);
            } else {
                showToast(data.message || 'Erro ao registrar devolução.', 'danger');
            }
        } catch (err) {
            showToast('Erro de rede: ' + err.message, 'danger');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form[data-json]').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                submitJsonForm(form);
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
