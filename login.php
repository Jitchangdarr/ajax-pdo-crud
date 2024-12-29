<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #form {
            position: relative;
            justify-content: center;
            text-align: center;
            border: 4px solid;
            padding: 1rem;


        }

        div input {
            margin: 1rem;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="form">
        <h1> Login</h1>
        name:<input type="text" id="name"><br>
        email:<input type="email" id="email"><br>
        password:<input type="password" id="pass"><br>
        <button type="submit" id="btn">Login</button>
        <div id="div"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn").click(function() {
                const formData = new FormData();
                formData.append('nm', $("#name").val());
                formData.append('em', $("#email").val());
                formData.append('pa', $("#pass").val());
                $.ajax({
                    type: 'POST',
                    url: 'loginaction.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#div").html(response);
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