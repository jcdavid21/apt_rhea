$(document).ready(function(){
    $('#submit').on('click', function(e){
        e.preventDefault(); // Prevent the default form submission
        
        // Retrieve form data
        var formData = $('#clinicForm').serialize();
        console.log(formData);
        
        // Send form data to the server-side PHP script using AJAX
        $.ajax({
            type: "POST",
            url: "insert.php", // Replace "process_form.php" with the actual filename of your PHP script
            data: formData,
            success: function(response){
               alert("Added successfully");
               window.location.reload();
            }
        });
    });
});
