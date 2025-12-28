// === Sidebar Admin Toggle & Collapse ===
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const dashboard = document.querySelector('.admin-dashboard');
    const sidebar = document.getElementById('adminSidebar');

    if (sidebarToggle && dashboard && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            dashboard.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('collapsed');
            // Salva stato in cookie solo su desktop
            if (window.innerWidth >= 768) {
                const isCollapsed = dashboard.classList.contains('sidebar-collapsed');
                document.cookie = "adminSidebarCollapsed=" + isCollapsed + "; path=/; max-age=31536000";
            }
        });

        // Chiudi sidebar su click fuori (mobile)
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                !dashboard.classList.contains('sidebar-collapsed')) {
                dashboard.classList.add('sidebar-collapsed');
                sidebar.classList.add('collapsed');
            }
        });

        // Chiudi sidebar su click link (mobile)
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    dashboard.classList.add('sidebar-collapsed');
                    sidebar.classList.add('collapsed');
                }
            });
        });

        // Stato iniziale sidebar
        if (window.innerWidth < 768) {
            dashboard.classList.add('sidebar-collapsed');
            sidebar.classList.add('collapsed');
        } else {
            // Desktop: carica da cookie
            const cookies = document.cookie.split(';');
            for (let cookie of cookies) {
                const [name, value] = cookie.trim().split('=');
                if (name === 'adminSidebarCollapsed' && value === 'true') {
                    dashboard.classList.add('sidebar-collapsed');
                    sidebar.classList.add('collapsed');
                    break;
                }
            }
        }

        // Aggiorna stato su resize
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                dashboard.classList.add('sidebar-collapsed');
                sidebar.classList.add('collapsed');
            } else {
                const cookies = document.cookie.split(';');
                let isCollapsed = false;
                for (let cookie of cookies) {
                    const [name, value] = cookie.trim().split('=');
                    if (name === 'adminSidebarCollapsed' && value === 'true') {
                        isCollapsed = true;
                        break;
                    }
                }
                if (isCollapsed) {
                    dashboard.classList.add('sidebar-collapsed');
                    sidebar.classList.add('collapsed');
                } else {
                    dashboard.classList.remove('sidebar-collapsed');
                    sidebar.classList.remove('collapsed');
                }
            }
        });
    }
});
// main.js - Main JavaScript file

// Utility functions
function showToast(message, type = 'info') {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '1060';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toastDiv = document.createElement('div');
    toastDiv.className = `toast align-items-center text-white bg-${type} border-0`;
    toastDiv.setAttribute('role', 'alert');
    toastDiv.setAttribute('aria-live', 'assertive');
    toastDiv.setAttribute('aria-atomic', 'true');

    // Set icon based on type
    let iconClass = 'fa-info-circle';
    if (type === 'success') iconClass = 'fa-check-circle';
    else if (type === 'warning') iconClass = 'fa-exclamation-triangle';
    else if (type === 'danger' || type === 'error') iconClass = 'fa-times-circle';

    toastDiv.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas ${iconClass} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    toastContainer.appendChild(toastDiv);

    // Initialize and show toast
    const toast = new bootstrap.Toast(toastDiv, {
        autohide: true,
        delay: 5000
    });
    toast.show();

    // Remove from DOM after hiding
    toastDiv.addEventListener('hidden.bs.toast', () => {
        toastDiv.remove();
    });
}

// Keep showAlert for backward compatibility
function showAlert(message, type = 'info') {
    showToast(message, type);
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

// AJAX helper
function ajaxRequest(url, method = 'GET', data = null) {
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'same-origin',
        body: data ? JSON.stringify(data) : null
    })
    .then(response => response.json())
    .catch(error => {
        console.error('AJAX Error:', error);
        showAlert('Errore di connessione', 'danger');
    });
}

// Quiz functionality
let quizTimer;
let quizTimeLeft;
let currentQuestionIndex = 0;
let quizAnswers = [];

function startQuiz(quizId, timeLimit) {
    quizTimeLeft = timeLimit * 60; // Convert to seconds
    quizAnswers = [];
    currentQuestionIndex = 0;

    updateTimer();
    quizTimer = setInterval(updateTimer, 1000);

    loadQuestion(quizId, 0);
}

function updateTimer() {
    const minutes = Math.floor(quizTimeLeft / 60);
    const seconds = quizTimeLeft % 60;
    document.getElementById('quiz-timer').textContent =
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    if (quizTimeLeft <= 0) {
        clearInterval(quizTimer);
        submitQuiz();
    }
    quizTimeLeft--;
}

function loadQuestion(quizId, questionIndex) {
    ajaxRequest(`/api/quiz.php?quiz_id=${quizId}&question=${questionIndex}`)
        .then(data => {
            if (data.success) {
                displayQuestion(data.question, questionIndex);
            } else {
                showAlert('Errore nel caricamento della domanda', 'danger');
            }
        });
}

function displayQuestion(question, index) {
    const container = document.getElementById('quiz-container');
    let optionsHtml = '';
    question.options.forEach((option, i) => {
        optionsHtml += `
            <div class="option form-check mb-2" data-option="${i}">
                <input class="form-check-input" type="radio" name="answer" value="${i}">
                <label class="form-check-label">${option}</label>
            </div>
        `;
    });
    
    container.innerHTML = `
        <div class="question-card card">
            <div class="card-header">
                Domanda ${index + 1}
            </div>
            <div class="card-body">
                <h5 class="card-title">${question.question}</h5>
                <div class="options mt-5">
                    ${optionsHtml}
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            ${index > 0 ? '<button class="btn btn-secondary me-2" onclick="previousQuestion()">Precedente</button>' : ''}
            <button class="btn btn-primary" onclick="nextQuestion()">${index === totalQuestions - 1 ? 'Consegna Quiz' : 'Successiva'}</button>
        </div>
    `;

    // Add click handlers for options
    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.querySelector(`input[value="${this.dataset.option}"]`).checked = true;
        });
    });
}

function nextQuestion() {
    const selectedOption = document.querySelector('input[name="answer"]:checked');
    if (selectedOption) {
        quizAnswers[currentQuestionIndex] = selectedOption.value;
    }

    currentQuestionIndex++;
    if (currentQuestionIndex >= totalQuestions) {
        submitQuiz();
    } else {
        loadQuestion(quizId, currentQuestionIndex);
    }
}

function previousQuestion() {
    currentQuestionIndex--;
    loadQuestion(quizId, currentQuestionIndex);
}

function submitQuiz() {
    clearInterval(quizTimer);
    ajaxRequest('/api/submit_quiz.php', 'POST', {
        quiz_id: quizId,
        answers: quizAnswers
    })
    .then(data => {
        if (data.success) {
            showResults(data.results);
        } else {
            showAlert('Errore nell\'invio del quiz', 'danger');
        }
    });
}

function showResults(results) {
    const container = document.getElementById('quiz-container');
    container.innerHTML = `
        <div class="card">
            <div class="card-header">
                Risultati Quiz
            </div>
            <div class="card-body text-center">
                <h3>Punteggio: ${results.score}%</h3>
                <p class="lead ${results.passed ? 'text-success' : 'text-danger'}">
                    ${results.passed ? 'Superato!' : 'Non superato'}
                </p>
                <a href="/student/dashboard.php" class="btn btn-primary">Torna alla Dashboard</a>
            </div>
        </div>
    `;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add form validation to all forms
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this.id)) {
                e.preventDefault();
                showAlert('Per favore, compila tutti i campi richiesti.', 'warning');
            }
        });
    });

    // === AdminLTE Sidebar Collapse Persistence ===
    // Load sidebar state from localStorage
    const sidebarCollapsed = localStorage.getItem('AdminLTE:sidebar-collapse');
    if (sidebarCollapsed === 'true') {
        document.body.classList.add('sidebar-collapse');
    }

    // Listen for sidebar toggle events and save state
    const pushMenuButton = document.querySelector('[data-widget="pushmenu"]');
    if (pushMenuButton) {
        pushMenuButton.addEventListener('click', function() {
            // Wait for AdminLTE to toggle the class, then save state
            setTimeout(() => {
                const isCollapsed = document.body.classList.contains('sidebar-collapse');
                localStorage.setItem('AdminLTE:sidebar-collapse', isCollapsed);
            }, 300); // Increased timeout
        });
    }

    // Also listen for body class changes using MutationObserver as backup
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const isCollapsed = document.body.classList.contains('sidebar-collapse');
                localStorage.setItem('AdminLTE:sidebar-collapse', isCollapsed);
            }
        });
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });

    // === Show PHP Messages as Toast ===
    // Check for PHP messages and show them as toast
    const phpMessage = document.querySelector('[data-php-message]');
    const phpMessageType = document.querySelector('[data-php-message-type]');

    if (phpMessage && phpMessageType) {
        const message = phpMessage.getAttribute('data-php-message');
        const type = phpMessageType.getAttribute('data-php-message-type');

        if (message && type) {
            // Map PHP message types to Bootstrap toast types
            let toastType = 'info';
            if (type === 'success') toastType = 'success';
            else if (type === 'error' || type === 'danger') toastType = 'danger';
            else if (type === 'warning') toastType = 'warning';

            showToast(message, toastType);
        }
    }
});