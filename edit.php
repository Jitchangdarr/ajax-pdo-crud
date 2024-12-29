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
        <h1>Registration form</h1>
        name:<input type="text" id="name"><br>
        adress:<textarea name="adress" id="text" cols="" rows="">
</textarea>
        <br>
        phone:<input type="number" name="" id="phone"><br>
        email:<input type="email" name="" id="email"><br>
        password:<input type="password" name="" id="pass"><br>
        confirm password:<input type="password" name="" id="conform"><br>
        gendar: <input type="radio" id="male" value="male">male
        <input type="radio" id="male" value="female">female
        <br>
        language:<select id="lan">
            <option value="">Select</option>
            <option value="Bengali">Bengali</option>
            <option value="English">English</option>
        </select><br>
        Chosse a file:<input id="file" type="file" name="file"><br>
        <button type="submit" id="btn">Submit</button>
        <div id="div"></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn").click(function() {
                const file = $("#file")[0].files[0];
                if (!file) {
                    alert("Please select a file");
                    return false;
                }
                const formData = new FormData();
                formData.append('file', file);
                formData.append('nm', $("#name").val());
                formData.append('te', $("#text").val());
                formData.append('ph', $("#phone").val());
                formData.append('em', $("#email").val());
                formData.append('pass', $("#pass").val());
                formData.append('con', $("#conform").val());
                formData.append('gen', $('input[name="gendar"]:checked').val());
                formData.append('lang', $("#lan").val());

                $.ajax({
                    type: 'POST',
                    url: 'editaction.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#div").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                    }
                });
            });
        });
    </script>
</body>

</html>