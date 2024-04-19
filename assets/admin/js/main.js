//  alert('Hello from main.js!');



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