<?php

// Admin page content
function student_crud_page() {
    global $wpdb;
    
    // Handle actions: edit or delete student
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];
        if ($action === 'edit_student') {
            $student = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}students WHERE id = %d", $id), ARRAY_A);
            ?>
            <div class="wrap">
                <h2>Edit Student</h2>
                <form method="post" action="">
                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                    <input type="text" name="student_name" value="<?php echo $student['name']; ?>" placeholder="Student Name" required>
                    <input type="email" name="student_email" value="<?php echo $student['email']; ?>" placeholder="Student Email" required>
                    <input type="submit" name="submit_update_student" value="Update Student">
                </form>
            </div>
            <?php
        } elseif ($action === 'delete_student') {
            delete_student($id);
            // Redirect back to the student list after deletion
            echo "<script>window.location.href='admin.php?page=student-crud';</script>";
            exit;
        }
    }

    // Handle form submissions
    if (isset($_POST['submit_add_student'])) {
        $name = $_POST['student_name'];
        $email = $_POST['student_email'];
        add_student($name, $email);
        // Refresh page after adding student
        echo "<meta http-equiv='refresh' content='0'>";
    }

    if (isset($_POST['submit_update_student'])) {
        $id = $_POST['student_id'];
        $name = $_POST['student_name'];
        $email = $_POST['student_email'];
        update_student($id, $name, $email);
        // Refresh page after updating student
        echo "<meta http-equiv='refresh' content='0'>";
    }

    ?>
    <div class="wrap">
        <h2>Manage Students</h2>
        <!-- Add New button -->
        <button id="addNewButton">Add New</button>
        <!-- Form for adding new student (initially hidden) -->
        <div id="addNewForm" style="display: none;">
            <h3>Add New Student</h3>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="email" name="student_email" placeholder="Student Email" required>
                <input type="submit" name="submit_add_student" value="Add Student">
            </form>
        </div>

        <!-- Display existing student records -->
        <h3>Existing Students</h3>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $students = get_students();
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>{$student['id']}</td>";
                    echo "<td>{$student['name']}</td>";
                    echo "<td>{$student['email']}</td>";
                    echo "<td><a href='admin.php?page=student-crud&action=edit_student&id={$student['id']}'>Edit</a> | <a href='admin.php?page=student-crud&action=delete_student&id={$student['id']}'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        // JavaScript to toggle visibility of the Add New Student form
        document.getElementById('addNewButton').addEventListener('click', function() {
            document.getElementById('addNewForm').style.display = 'block';
        });
    </script>
    <?php
}
