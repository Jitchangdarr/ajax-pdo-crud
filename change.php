<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div>
        oldpassword<input type="text" name="" id="od"><br>
        newpassword<input type="text" name="" id="ne"><br>
        confirmpassword <input type="text" name="" id="co"><br>
        <button type="submit" id="btn">Submit</button>
        <div id="div"></div>
    </div>
    <script>
        $(document).ready(function() {
            $("#btn").click(function() {
                if (!oldPassword || !newPassword || !confirmPassword) {
                    $("#div").html("All fields are required.");
                    return;
                }

                if (newPassword !== confirmPassword) {
                    $("#div").html("New password and confirm password do not match.");
                    return;
                }
                const formData = new FormData();
                formData.append('old', $("#od").val());
                formData.append('ne', $("#ne").val());
                formData.append('co', $("#co").val());

                $.ajax({
                    type: 'POST',
                    url: 'changeaction.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#div").html(response)
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                    }

                })
            })
        })
    </script>
</body>

</html>