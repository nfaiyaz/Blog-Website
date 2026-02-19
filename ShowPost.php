<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>

    <!-- bootstrap5 cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- javascript cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./Style/HomePage.css">
</head>

<body>



<?php include './navbar.html'; ?>

    <!--------------- Post --------------->

    <div class="container mt-3" style="padding-top: 80px;">
        <!-- <div class="div1"> -->
        <div class="row">
        <?php
    // Assuming your database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "blog_website";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if PostID is set in the URL
    if (isset($_GET['postID'])) {
        $postID = $_GET['postID'];

        // SQL query to retrieve data from the Posts table by PostID
        $sql = "SELECT * FROM Posts WHERE PostID = $postID";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data of the first (assuming PostID is unique) row
            $row = $result->fetch_assoc();

            // Access the values
            $userID = $row["UserID"];
            $postTitle = $row["Title"];
            $postContent = $row["Content"];
            $postTimestamp = $row["Timestamp"];
            $categoryID = $row["CategoryID"];
            $author = $row["Author"];

            // Use the values as needed
            echo '<div class="col-lg-8">


            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-start align-items-center">
                        <!--<img class="rounded-circle shadow-1-strong me-3"
                            src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar"
                            width="60" height="60" />-->
                        <div>
                        <h3 class="fw-bold text-primary mb-1">'. $postTitle .'</h3>
                            <h6 class="fw-bold text-primary mb-1">written by - '. $author .'</h6>
                            <p class="text-muted small mb-0">
                            '. $postTimestamp .'
                            </p>
                        </div>
                    </div>

                    <p class="mt-3 mb-4 pb-2">
                        '. $postContent .'
                    </p>

                    <div class="small d-flex justify-content-start">
                        <a href="#!" class="d-flex align-items-center me-3">
                            <i class="far fa-thumbs-up me-2"></i>
                            <p class="mb-0">Like</p>
                        </a>
                        <a href="#!" class="d-flex align-items-center me-3">
                            <i class="far fa-comment-dots me-2"></i>
                            <p class="mb-0">Comment</p>
                        </a>
                        <a href="#!" class="d-flex align-items-center me-3">
                            <i class="fas fa-share me-2"></i>
                            <p class="mb-0">Share</p>
                        </a>
                    </div>
                </div>
                <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                    <div class="d-flex flex-start w-100">
                        <!--<img class="rounded-circle shadow-1-strong me-3"
                            src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar"
                            width="40" height="40" />-->
                        <div class="form-outline w-100">
                            <textarea class="form-control" id="textAreaExample" rows="4"
                                style="background: #fff;"></textarea>
                            <label class="form-label" for="textAreaExample">Message</label>
                        </div>
                    </div>
                    <div class="float-end mt-2 pt-1">
                        <button type="button" class="btn btn-primary btn-sm">Post comment</button>
                        <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
                    </div>
                </div>
            </div>



        </div>';
        } else {
            echo "No post found with the specified PostID";
        }
    } else {
        echo "PostID not provided in the URL";
    }

    // Close the database connection
    $conn->close();
    ?>
            

            <!--------------- Categories --------------->

            <div class="col-lg-4">
                <div>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                            Categories
                        </a>


                        <?php
                        // Assuming your database connection details
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "blog_website";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // SQL query to select all rows from Categories table
                        $sql = "SELECT * FROM Categories";

                        // Execute the query
                        $result = $conn->query($sql);

                        // Check if there are any results
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                //echo "CategoryID: " . $row["CategoryID"] . " - CategoryName: " . $row["CategoryName"] . "<br>";
                                echo ' <a href="#" class="list-group-item list-group-item-action">' . $row["CategoryName"] . '</a>';
                            }
                        } else {
                            echo "0 results";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>

                    </div>
                </div>
            </div>

        </div>
        <!-- </div> -->

    </div>



    <!--------------- Footer --------------->
    <!-- <div class="footer" style="background-color: #d6d6d6;">
        <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
                </ul>
                <p class="text-center text-body-secondary">&copy; 2024 Company, Inc</p>
            </footer>
        </div>
    </div> -->


    <!-- javascript, popper, bootstrap cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>

</html>