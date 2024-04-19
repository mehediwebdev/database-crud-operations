<div class="wrap">
    <h1>Custom Table Data</h1>
    <button id="addNewButton">Add New <span>+</span></button>
        <!-- Popup form -->
        <div id="popupForm" class="popup">
        <form id="addNewForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

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
            // Retrieve data to populate the table (you should replace this with your own data retrieval logic)
            global $wpdb;
            $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}custom_data_table");

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>{$row->id}</td>";
                echo "<td>{$row->name}</td>";
                echo "<td>{$row->email}</td>";
                echo "<td><button>Edit</button> <button>Delete</button></td>"; // Example action buttons
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>




<script>
    // JavaScript to toggle popup form
    document.getElementById("addNewButton").addEventListener("click", function() {
        document.getElementById("popupForm").style.display = "block";
    });

    // JavaScript to hide popup form when clicking outside of it
    window.addEventListener("click", function(event) {
        var popupForm = document.getElementById("popupForm");
        if (event.target == popupForm) {
            popupForm.style.display = "none";
        }
    });
</script>
