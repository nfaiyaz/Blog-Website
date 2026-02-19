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


    <!--------------- Slider --------------->

    <section id="feedback">
      <div class="section-title">
        <h3 class="text-center">Easygoing Creative Blog</h3>

      </div>

      <div class="row">
        <div class="col-lg-12">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <!-- <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div> -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <p>1. Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, rem!</p>

                <!-- <img class="feedback-img rounded-circle" src="Blog1.png" alt=""> -->
                <h6>Faiyaz Noor</h6>
              </div>
              <div class="carousel-item">
                <p>2. Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, rem!</p>

                <!-- <img class="feedback-img rounded-circle" src="Blog2.png" alt=""> -->
                <h6>Samiul Hasan Sayad</h6>
              </div>
              <div class="carousel-item">
                <p>3. Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit, rem!</p>

                <!-- <img class="feedback-img rounded-circle" src="Blog3.png" alt=""> -->
                <h6>Rafid Tasnim Nabil</h6>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!--------------- Post --------------->

  <div class="container mt-3">
    <!-- <div class="div1"> -->
    <div class="row">
      <div class="col-lg-8">

      

        <?php
        // Assuming your database connection details
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname = "blog_website";

        // // Create connection
        // $conn = new mysqli($servername, $username, $password, $dbname);

        // // Check connection
        // if ($conn->connect_error) {
        //   die("Connection failed: " . $conn->connect_error);
        // }
        include_once './PHP/db_connection.php';

        // SQL query to retrieve data from the Posts and PostCategories tables
        $sql = "SELECT Posts.*, GROUP_CONCAT(Categories.CategoryName SEPARATOR ', ') AS CategoryNames
        FROM Posts
        LEFT JOIN PostCategories ON Posts.PostID = PostCategories.PostID
        LEFT JOIN Categories ON PostCategories.CategoryID = Categories.CategoryID
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
            
              <!-- <p class="truncate-text">' . $row["Content"] . '</p>-->
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
        //$conn->close();
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
            // $servername = "localhost";
            // $username = "root";
            // $password = "";
            // $dbname = "blog_website";

            // // Create connection
            // $conn = new mysqli($servername, $username, $password, $dbname);

            // // Check connection
            // if ($conn->connect_error) {
            //   die("Connection failed: " . $conn->connect_error);
            // }

            include_once './PHP/db_connection.php';

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



  <!--------------- Footer --------------->
  <div class="footer" style="background-color: #d6d6d6;">
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