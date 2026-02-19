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

    <div class="text-white">
        <header>

            <?php include './navbar.html'; ?>
        </header>


        <!--------------- Post --------------->

        <div class="container mt-3">
            <!-- <div class="div1"> -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-lg-8">

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

                    // Initialize search input
                    $searchInput = "";

                    // Check if search form is submitted
                    if (isset($_GET['searchinput'])) {
                        $searchInput = $conn->real_escape_string($_GET['searchinput']);
                    }

                    // SQL query to retrieve data from the Posts and PostCategories tables with a search condition
                    $sql = "SELECT Posts.*, GROUP_CONCAT(Categories.CategoryName SEPARATOR ', ') AS CategoryNames
            FROM Posts
            LEFT JOIN PostCategories ON Posts.PostID = PostCategories.PostID
            LEFT JOIN Categories ON PostCategories.CategoryID = Categories.CategoryID
            WHERE Posts.Title LIKE '%$searchInput%'
            GROUP BY Posts.PostID
            ORDER BY Posts.Timestamp DESC";

                    // Execute the query
                    $result = $conn->query($sql);

                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card">
                    <div class="card-header">
                        <h2>' . $row["Title"] . '</h2>
                        <a href="">
                            <time class="text-dark" datetime="2023-07-03 20:00">' . $row["Timestamp"] . '</time>
                        </a>
                        <a class="ms-3 text-dark" href="" rel="tag">Tags: ' . $row["CategoryNames"] . '</a>
                    </div>
                    <div class="card-body">
                        ' . $row["Content"] . '
                        <a class="btn btn-primary bg-dark" href="./ShowPost.php?postID=' . $row["PostID"] . '" role="button" style="border-color: black;">Learn more...</a>
                    </div>
                    <div class="card-footer">
                        <footer class="blockquote-footer mt-3">
                            ' . $row["Author"] . '
                        </footer>
                    </div>
                </div>';
                        }
                    } else {
                        echo "No posts found";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>

                    <hr>
                </div>

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
                                    echo ' <a href="./searchCategory.php?ctgname=' . $row["CategoryName"] . '" class="list-group-item list-group-item-action">' . $row["CategoryName"] . '</a>';

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

            <a class="btn btn-primary ms-2 mt-3" href="#" role="button">Older posts</a>
        </div>






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