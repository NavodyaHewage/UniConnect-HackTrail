<?php

require_once __DIR__ . '/../models/ClassListing.php';
require_once __DIR__ . '/../models/ClassEnrollment.php';

class ClassController
{
    private ClassListing $classModel;
    private ClassEnrollment $enrollmentModel;

    public function __construct()
    {
        $this->classModel      = new ClassListing();
        $this->enrollmentModel = new ClassEnrollment();
    }

    public function index(): void
    {
        $classes = $this->classModel->all('open');
        require __DIR__ . '/../views/classes/class_feed.php';
    }

    public function show(int $id): void
    {
        $class = $this->classModel->find($id);
        $enrollments = $class ? $this->enrollmentModel->allByClass($id) : [];
        $seatsTaken = $class ? $this->enrollmentModel->countActiveByClass($id) : 0;
        require __DIR__ . '/../views/classes/class_detail.php';
    }

    public function showCreateForm(): void
    {
        require __DIR__ . '/../views/classes/post_class.php';
    }

    public function store(): void
    {
        $classType = ($_POST['class_type'] ?? 'individual') === 'group' ? 'group' : 'individual';
        $maxStudents = $classType === 'group'
            ? max(2, (int) ($_POST['max_students'] ?? 2))
            : 1;

        $this->classModel->create([
            'tutor_id'     => $_SESSION['user_id'],
            'tutor_name'   => trim($_POST['tutor_name'] ?? ''),
            'tutor_phone'  => trim($_POST['tutor_phone'] ?? ''),
            'subject'      => trim($_POST['subject'] ?? ''),
            'title'        => trim($_POST['title'] ?? ''),
            'description'  => trim($_POST['description'] ?? '') ?: null,
            'class_type'   => $classType,
            'price'        => $_POST['price'] ?? 0,
            'max_students' => $maxStudents,
            'schedule'     => trim($_POST['schedule'] ?? '') ?: null,
        ]);

        header('Location: ' . url('/skills/classes/my'));
    }

    public function myClasses(): void
    {
        $classes = $this->classModel->allByTutor($_SESSION['user_id']);
        foreach ($classes as &$class) {
            $enrollments = $this->enrollmentModel->allByClass((int) $class['class_id']);
            $confirmed = array_filter($enrollments, fn ($e) => $e['status'] === 'confirmed');
            $class['enrollments'] = $enrollments;
            $class['earnings'] = count($confirmed) * (float) $class['price'];
        }
        unset($class);

        require __DIR__ . '/../views/classes/my_classes.php';
    }

    public function enroll(int $id): void
    {
        $class = $this->classModel->find($id);
        if (!$class || $class['status'] !== 'open') {
            header('Location: ' . url('/skills/classes'));
            return;
        }

        $seatsTaken = $this->enrollmentModel->countActiveByClass($id);
        if ($seatsTaken >= (int) $class['max_students']) {
            $_SESSION['error'] = 'This class is already full.';
            header('Location: ' . url('/skills/classes/' . $id));
            return;
        }

        $this->enrollmentModel->create([
            'class_id'      => $id,
            'student_id'    => $_SESSION['user_id'],
            'student_name'  => trim($_POST['student_name'] ?? ($_SESSION['user_name'] ?? '')),
            'student_phone' => trim($_POST['student_phone'] ?? ''),
        ]);

        header('Location: ' . url('/skills/classes/' . $id));
    }

    public function updateStatus(int $id): void
    {
        $class = $this->classModel->find($id);
        if ($class && (int) $class['tutor_id'] === (int) $_SESSION['user_id']) {
            $status = $_POST['status'] ?? 'open';
            $this->classModel->updateStatus($id, $status);
        }

        header('Location: ' . url('/skills/classes/my'));
    }

    public function destroy(int $id): void
    {
        $class = $this->classModel->find($id);
        if ($class && (int) $class['tutor_id'] === (int) $_SESSION['user_id']) {
            $this->classModel->delete($id);
        }

        header('Location: ' . url('/skills/classes/my'));
    }

    public function updateEnrollmentStatus(int $enrollmentId): void
    {
        $enrollment = $this->enrollmentModel->find($enrollmentId);
        if ($enrollment) {
            $class = $this->classModel->find((int) $enrollment['class_id']);
            if ($class && (int) $class['tutor_id'] === (int) $_SESSION['user_id']) {
                $status = $_POST['status'] ?? 'pending';
                $this->enrollmentModel->updateStatus($enrollmentId, $status);
            }
        }

        header('Location: ' . url('/skills/classes/my'));
    }
}
