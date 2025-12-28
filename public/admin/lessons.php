<?php
$page_title = 'Gestisci Lezioni Corso di Teoria';
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireAdmin();

$current_page = basename(__FILE__);

// Handle delete lesson
if (isset($_GET['delete'])) {
    $lesson_id = (int)$_GET['delete'];
    $stmt = $db->prepare("DELETE FROM lessons WHERE id = ?");
    $stmt->execute([$lesson_id]);
    header('Location: lessons.php?course=' . $selected_course_id);
    exit;
}

// Handle add/edit lesson
$message = '';
$message_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = (int)($_POST['course_id'] ?? 0);
    $title = sanitize($_POST['title'] ?? '');
    $content = sanitize($_POST['content'] ?? '');
    $video_url = sanitize($_POST['video_url'] ?? '');
    $lesson_order = (int)($_POST['lesson_order'] ?? 0);
    $lesson_id = $_POST['lesson_id'] ?? null;

    if ($course_id && $title && $content) {
        if ($lesson_id) {
            // Update
            $stmt = $db->prepare("UPDATE lessons SET course_id = ?, title = ?, content = ?, video_url = ?, lesson_order = ? WHERE id = ?");
            $stmt->execute([$course_id, $title, $content, $video_url, $lesson_order, $lesson_id]);
            $message = 'Lezione aggiornata con successo.';
            $message_type = 'success';
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO lessons (course_id, title, content, video_url, lesson_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$course_id, $title, $content, $video_url, $lesson_order]);
            $message = 'Lezione aggiunta con successo.';
            $message_type = 'success';
        }
    } else {
        $message = 'Per favore, compila tutti i campi obbligatori.';
        $message_type = 'warning';
    }
}

// Get courses (only theory course)
$stmt = $db->prepare("SELECT * FROM courses WHERE id = 4");
$stmt->execute();
$courses = $stmt->fetchAll();

// Get selected course (default to theory course)
$selected_course_id = 4;

// Get lessons for selected course
$lessons = [];
if ($selected_course_id) {
    $stmt = $db->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_order");
    $stmt->execute([$selected_course_id]);
    $lessons = $stmt->fetchAll();
}

// Get lesson for editing
$edit_lesson = null;
if (isset($_GET['edit'])) {
    $lesson_id = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM lessons WHERE id = ?");
    $stmt->execute([$lesson_id]);
    $edit_lesson = $stmt->fetch();
}

require_once '../../includes/header_dashboard.php';
?>

<!-- AdminLTE Wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Benvenuto, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</span>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <?php include '../../includes/sidebar_admin.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Gestisci Lezioni Corso di Teoria</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Lezioni</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Course Selector -->
                <div class="card">
                    <div class="card-body">
                        <form method="get" class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="course" class="form-label">Seleziona Corso</label>
                                <select class="form-control" id="course" name="course" onchange="this.form.submit()">
                                    <option value="">Seleziona un corso...</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?php echo $course['id']; ?>" <?php echo $selected_course_id == $course['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($course['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if ($selected_course_id): ?>
        <!-- Hidden elements for JavaScript toast messages -->
        <?php if ($message): ?>
        <div data-php-message="<?php echo htmlspecialchars($message); ?>" data-php-message-type="<?php echo htmlspecialchars($message_type); ?>" style="display: none;"></div>
        <?php endif; ?>

        <!-- Lesson Form -->
        <div class="dashboard-card" id="lessonForm" style="<?php echo $edit_lesson ? '' : 'display: none;'; ?>">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> <?php echo $edit_lesson ? 'Modifica Lezione' : 'Aggiungi Nuova Lezione'; ?></h4>
                <button class="btn btn-sm btn-outline-secondary" onclick="toggleForm()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="card-body">
                <form method="post" id="lessonFormData">
                    <?php if ($edit_lesson): ?>
                        <input type="hidden" name="lesson_id" value="<?php echo $edit_lesson['id']; ?>">
                    <?php endif; ?>
                    <input type="hidden" name="course_id" value="<?php echo $selected_course_id; ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-label">Titolo Lezione *</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($edit_lesson['title'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lesson_order" class="form-label">Ordine</label>
                                <input type="number" class="form-control" id="lesson_order" name="lesson_order" value="<?php echo $edit_lesson['lesson_order'] ?? (count($lessons) + 1); ?>" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="video_url" class="form-label">URL Video (opzionale)</label>
                        <input type="url" class="form-control" id="video_url" name="video_url" value="<?php echo htmlspecialchars($edit_lesson['video_url'] ?? ''); ?>" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label for="content" class="form-label">Contenuto Lezione *</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required><?php echo htmlspecialchars($edit_lesson['content'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> <?php echo $edit_lesson ? 'Aggiorna Lezione' : 'Aggiungi Lezione'; ?>
                        </button>
                        <?php if ($edit_lesson): ?>
                            <a href="lessons.php?course=<?php echo $selected_course_id; ?>" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Annulla
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lessons List -->
        <div class="dashboard-card">
            <div class="card-header">
                <h4><i class="bi bi-list"></i> Lezioni del Corso (<?php echo count($lessons); ?>)</h4>
                <div class="card-tools">
                    <input type="text" id="searchInput" class="form-control form-control-sm d-inline-block" placeholder="Cerca lezioni..." style="width: 200px; margin-right: 10px;">
                    <button class="btn btn-primary btn-sm" onclick="toggleForm()">
                        <i class="bi bi-plus"></i> Nuova Lezione
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($lessons)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">Nessuna lezione trovata</h5>
                        <p>Crea la tua prima lezione per questo corso.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="lessonsTable">
                            <thead>
                                <tr>
                                    <th>Ordine</th>
                                    <th>Titolo</th>
                                    <th>Contenuto</th>
                                    <th>Video</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lessons as $lesson): ?>
                                    <tr>
                                        <td><?php echo $lesson['lesson_order']; ?></td>
                                        <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($lesson['content'] ?? '', 0, 100)) . (strlen($lesson['content'] ?? '') > 100 ? '...' : ''); ?></td>
                                        <td>
                                            <?php if ($lesson['video_url']): ?>
                                                <i class="bi bi-play-circle-fill text-success"></i> Sì
                                            <?php else: ?>
                                                <i class="bi bi-dash text-muted"></i> No
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="lessons.php?course=<?php echo $selected_course_id; ?>&edit=<?php echo $lesson['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifica">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="lessons.php?course=<?php echo $selected_course_id; ?>&delete=<?php echo $lesson['id']; ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Sei sicuro di voler eliminare questa lezione?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2025 <?php echo SITE_NAME; ?>.</strong> All rights reserved.
    </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
// Initialize components
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-toggle="popover"]').popover();
    
    // Table filtering
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#lessonsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Toggle form visibility
function toggleForm() {
    const form = document.getElementById('lessonForm');
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}
</script>

</body>
</html>
