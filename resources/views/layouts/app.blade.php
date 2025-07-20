<!doctype html>
<html lang="en">

<head>
    <title>Irshad Autos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        .collapse .nav-link {
            background-color: transparent !important;
            color: #212529 !important;
        }

        .collapse .nav-link:hover {
            background-color: #f8f9fa !important;
            color: #0d6efd !important;
        }
        body {
            color: #d32f2f !important;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>


</head>

<body>
    <header>
        {{-- @include('includes.navbar')
        @include('includes.sidebar') --}}
    </header>
    <div class="d-flex">
        @include('includes.sidebar')
        <div class="flex-grow-1 p-3" style="margin-left: 250px;">
            @include('includes.navbar')
            <main class="mt-2">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- @if (session('success'))
                    <p style="color:green;">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <ul style="color:red;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif --}}

                <div class="p-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <footer>
        <!-- place footer here -->
    </footer>
    @stack('scripts')
    <!-- Bootstrap JavaScript Libraries -->
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous">
    </script>

    <!-- Toast container for reminders -->
    <div id="reminder-toast-container" style="position: fixed; bottom: 32px; right: 32px; z-index: 1080;"></div>

    <script>
    // Reminder Bell Icon Notification Logic
    let notifiedReminders = JSON.parse(localStorage.getItem('notifiedReminders') || '{}');
    function playReminderSound() {
        const audio = new Audio('/notification.mp3');
        audio.play();
    }
    function showReminderToast(reminder) {
        // Only show one toast per reminder per session
        if (document.getElementById('reminder-toast') || notifiedReminders[reminder.id]) return;
        const container = document.getElementById('reminder-toast-container');
        const toast = document.createElement('div');
        toast.id = 'reminder-toast';
        toast.className = 'shadow';
        toast.style.background = '#fffbe6';
        toast.style.border = '1.5px solid #ffe066';
        toast.style.color = '#856404';
        toast.style.padding = '18px 32px 18px 18px';
        toast.style.borderRadius = '8px';
        toast.style.fontSize = '1.1rem';
        toast.style.marginBottom = '12px';
        toast.style.minWidth = '260px';
        toast.style.maxWidth = '350px';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.innerHTML = `
            <span style="flex:1;">🔔 <b>New Reminder:</b> ${reminder.title || '(No Title)'}<br><span style='font-size:0.98em;'>${reminder.note}</span><br><span style='font-size:0.9em;color:#b59a00;'>Check the <b>bell icon</b> in the navbar.</span></span>
            <button id="reminder-toast-close" style="background:none; border:none; font-size:1.5rem; color:#856404; margin-left:12px; cursor:pointer;">&times;</button>
        `;
        container.appendChild(toast);
        document.getElementById('reminder-toast-close').onclick = function() {
            toast.remove();
        };
        // Auto-dismiss after 10 seconds
        setTimeout(() => { if (toast.parentNode) toast.remove(); }, 10000);
        notifiedReminders[reminder.id] = true;
        localStorage.setItem('notifiedReminders', JSON.stringify(notifiedReminders));
    }
    function renderReminders(reminders) {
        const badge = document.getElementById('reminder-badge');
        const list = document.getElementById('reminder-list');
        const empty = document.getElementById('reminder-list-empty');
        if (!badge || !list || !empty) return;
        list.innerHTML = '';
        if (reminders.length === 0) {
            badge.style.display = 'none';
            empty.style.display = '';
            return;
        }
        badge.textContent = reminders.length;
        badge.style.display = '';
        empty.style.display = 'none';
        reminders.forEach(reminder => {
            const li = document.createElement('li');
            li.className = 'dropdown-item d-flex justify-content-between align-items-center';
            li.style.gap = '10px';
            li.innerHTML = `
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${reminder.title || '(No Title)'}</div>
                    <div class="small text-muted">${reminder.reminder_time ? new Date(reminder.reminder_time.replace(' ', 'T')).toLocaleString() : ''}</div>
                    <div style="font-size:0.97em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${reminder.note}</div>
                </div>
                <div class="d-flex flex-column align-items-center" style="gap:4px;">
                    <form method="POST" action="/notes/${reminder.id}" class="mark-done-form">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="is_done" value="1">
                        <button type="submit" title="Mark as Done" class="btn btn-link p-0" style="color:green;font-size:1.3em;"><i class="bi bi-check-circle-fill"></i></button>
                    </form>
                    <form method="POST" action="/notes/${reminder.id}" class="delete-reminder-form">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" title="Delete" class="btn btn-link p-0" style="color:#d32f2f;font-size:1.3em;"><i class="bi bi-trash-fill"></i></button>
                    </form>
                </div>
            `;
            list.appendChild(li);
        });
    }
    function fetchRemindersAndUpdateBell() {
        fetch('/api/due-reminders')
            .then(res => res.json())
            .then(reminders => {
                renderReminders(reminders);
                // Toast and sound for new reminders
                reminders.forEach(reminder => {
                    if (!notifiedReminders[reminder.id]) {
                        playReminderSound();
                        showReminderToast(reminder);
                    }
                });
            });
    }
    setInterval(fetchRemindersAndUpdateBell, 30000); // Check every 30 seconds
    window.addEventListener('DOMContentLoaded', function() {
        fetchRemindersAndUpdateBell();
        // Fix for Bootstrap dropdowns (ensure they work)
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
                var dropdown = new bootstrap.Dropdown(el);
                dropdown.toggle();
            });
        });
    });
    function removeReminderFromUI(id) {
        // Remove from dropdown
        const list = document.getElementById('reminder-list');
        if (list) {
            const items = list.querySelectorAll('li');
            items.forEach(item => {
                if (item.innerHTML.includes(`/notes/${id}`)) {
                    item.remove();
                }
            });
        }
        // Update badge
        const badge = document.getElementById('reminder-badge');
        if (badge) {
            let count = parseInt(badge.textContent) || 1;
            count = Math.max(0, count - 1);
            badge.textContent = count;
            if (count === 0) badge.style.display = 'none';
        }
        // Remove toast if present
        const toast = document.getElementById('reminder-toast');
        if (toast) toast.remove();
        // Remove from localStorage
        delete notifiedReminders[id];
        localStorage.setItem('notifiedReminders', JSON.stringify(notifiedReminders));
    }
    // AJAX for mark as done and delete
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('mark-done-form') || e.target.classList.contains('delete-reminder-form')) {
            e.preventDefault();
            const form = e.target;
            const action = form.getAttribute('action');
            const idMatch = action.match(/\/notes\/(\d+)/);
            if (!idMatch) return;
            const id = idMatch[1];
            const method = form.classList.contains('mark-done-form') ? 'PUT' : 'DELETE';
            const formData = new FormData(form);
            fetch(action, {
                method: method === 'PUT' ? 'POST' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: formData
            }).then(res => {
                if (res.ok) {
                    removeReminderFromUI(id);
                }
                fetchRemindersAndUpdateBell();
            });
        }
    });
    // Prevent dropdown from closing or row from being selected when clicking tick/trash
    document.addEventListener('click', function(e) {
        if (e.target.closest('.mark-done-form button') || e.target.closest('.delete-reminder-form button')) {
            e.stopPropagation();
        }
    }, true);
    </script>

</body>

</html>
