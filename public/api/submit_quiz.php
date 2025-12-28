<?php
header('Content-Type: application/json');
try {
    require_once __DIR__ . '/../../includes/config.php';
    require_once __DIR__ . '/../../includes/auth.php';
    require_once __DIR__ . '/../../includes/db.php';

if (!isStudent()) {
    echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

$quiz_id = $data['quiz_id'] ?? 0;
$answers = $data['answers'] ?? [];

if (!$quiz_id || empty($answers)) {
    echo json_encode(['success' => false, 'message' => 'Dati mancanti']);
    exit;
}

// Get all questions for this quiz
$user_id = $_SESSION['user_id'];

// Use consistent seed for random order per user and quiz
$seed = crc32($user_id . $quiz_id);
mt_srand($seed);

$stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->execute([$quiz_id]);
$questions = $stmt->fetchAll();

// Shuffle questions for random order
shuffle($questions);

$correct_answers = 0;
$total_questions = count($questions);

foreach ($questions as $index => $question) {
    $user_answer = $answers[$index] ?? null;
    
    // Calculate correct index for shuffled options
    $options = [
        $question['option_a'],
        $question['option_b'],
        $question['option_c'],
        $question['option_d']
    ];
    $correct_index = ord($question['correct_answer']) - ord('a');
    
    // Shuffle options with same seed
    $shuffled_options = $options;
    shuffle($shuffled_options);
    
    // Find new correct index after shuffle
    $new_correct_index = array_search($options[$correct_index], $shuffled_options);
    
    if ($user_answer == $new_correct_index) {
        $correct_answers++;
    }
}

$score = round(($correct_answers / $total_questions) * 100);

// Get passing score
$stmt = $db->prepare("SELECT passing_score FROM quizzes WHERE id = ?");
$stmt->execute([$quiz_id]);
$passing_score = $stmt->fetch()['passing_score'];

$passed = $score >= $passing_score;

// Save attempt
$stmt = $db->prepare("INSERT INTO quiz_attempts (user_id, quiz_id, score, passed) VALUES (?, ?, ?, ?)");
$stmt->execute([$user_id, $quiz_id, $score, $passed]);

echo json_encode([
    'success' => true,
    'results' => [
        'score' => $score,
        'passed' => $passed,
        'correct_answers' => $correct_answers,
        'total_questions' => $total_questions
    ]
]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Errore interno del server']);
}
?>