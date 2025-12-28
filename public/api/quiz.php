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

    $quiz_id = $_GET['quiz_id'] ?? 0;
    $question_index = (int)($_GET['question'] ?? 0);

    $user_id = $_SESSION['user_id'];

    // Use consistent seed for random order per user and quiz
    $seed = crc32($user_id . $quiz_id);
    mt_srand($seed);

    $stmt = $db->prepare("SELECT * FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quiz_id]);
    $all_questions = $stmt->fetchAll();

    // Shuffle questions for random order
    shuffle($all_questions);

    // Get the question at the requested index
    $question = $all_questions[$question_index] ?? null;

    if ($question) {
        $options = [
            $question['option_a'],
            $question['option_b'],
            $question['option_c'],
            $question['option_d']
        ];
        
        // Find correct index
        $correct_index = ord($question['correct_answer']) - ord('a');
        
        // Shuffle options
        $shuffled_options = $options;
        shuffle($shuffled_options);
        
        // Find new correct index after shuffle
        $new_correct_index = array_search($options[$correct_index], $shuffled_options);
        
        echo json_encode([
            'success' => true,
            'question' => [
                'id' => $question['id'],
                'question' => $question['question'],
                'options' => $shuffled_options
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Domanda non trovata']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Errore: ' . $e->getMessage()]);
}
?>