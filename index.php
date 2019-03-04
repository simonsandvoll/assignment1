<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <title>School</title>
</head>

<body>
        <div class="container-fluid">
                <legend>School</legend>
                <form action="data.php" method="post" enctype="multipart/form-data" id="csvForm">
                    <fieldset>
                        
                        <!-- buttons to student and course page -->
                        <a href="student.php?show=true"  class="btn btn-primary">Show students</a>
                        <a href="course.php?show=true"   class="btn btn-primary">Show courses</a>
                        
                        <!-- Form Name -->
                        <h4>Upload csv file</h4>
                        <hr>
 
                        <!-- File Button -->
                        <div class="form-group">
                            <label for="filebutton">Select File</label>
                            <div>
                                <input type="file" accept=".csv" name="file" id="file" class="input-large">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label  for="submit">Upload csv</label>
                            <div>
                                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

</body>
</html>

<?php
// CHECK IF FILE IS UPLOADED, if true echo it. 
if (isset($_GET['upload'])) {
    if ($_GET['upload'] == true) {
        echo 'Upload successful!';
    } else {
        echo 'Upload unsuccessful!';
    }
}


?>