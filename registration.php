<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include Bootstrap JavaScript from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Registration Form</h2>

    <form id="registrationForm">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="button" class="btn btn-primary" id="registerBtn">Register</button>
    </form>

    <div id="response" class="mt-3"></div>
</div>

<script>
    $(document).ready(function () {
        $("#registerBtn").click(function () {
            debugger;
            // Serialize the form data as an array
            var formDataArray = $("#registrationForm").serializeArray();
            // Convert the array to a JSON object
            var formDataJSON = {};
            $.each(formDataArray, function (index, field) {
                formDataJSON[field.name] = field.value;
            });

            // Convert the JSON object to a string
            var jsonString = JSON.stringify(formDataJSON);

            // Make the AJAX request with the JSON data
            $.ajax({
                type: "POST",
                url: "registrationbackend.php",
                data: jsonString,
                contentType: "application/json; charset=utf-8", // Set content type to JSON
                dataType: "json", // Expect JSON response
                success: function (response) {
                    $("#response").html(response);
                }
            });
        });
    });
</script>

</body>
</html>
