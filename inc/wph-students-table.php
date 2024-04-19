<div class="wrap">
    <h1>Custom Table Data</h1>
    <button id="addNewButton">Add New <span>+</span></button>
        <!-- Popup form -->
        <div id="popupForm" class="popup">
        <form id="addNewForm" action="" method="post">
        <?php wp_nonce_field('database-crud-nonce-action', 'database-crud-nonce'); ?>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <button type="submit" name="submit">Submit</button>
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
    $table_name = $wpdb->prefix . 'wph_students';
    $sql_students =  "SELECT * FROM $table_name ORDER BY id ASC";
    $items = $wpdb->get_results($sql_students);

    foreach ($items as $item) {
    ?>

    <tr>
    <th scope="row"><?php echo $item->id; ?></th>
    <td><?php echo $item->name; ?></td>
    <td><?php echo $item->email; ?></td>

    <td>
      <!-- <a type="button" class="btn btn-primary">Edit</a> -->
      <!-- <a href="#" class="btn btn-primary">Delete</a> -->
      <a href="<?php echo admin_url('admin.php?page=database-crud&action=edit&id=' . $item->id ) ?>" onclick="return confirm('are you sure ?')" class="btn btn-danger">Edit</a>
      <a href="<?php echo admin_url('admin.php?page=database-crud&action=delete&id=' . $item->id ) ?>" onclick="return confirm('are you sure ?')" class="btn btn-danger">Delete</a>
      </td>
    </tr>
     

 <?php   } ?>
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


