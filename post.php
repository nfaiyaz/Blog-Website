<?php
session_start();

// Function to fetch drafts from the database
function getDrafts($userId)
{
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "blog_website";

    // $conn = new mysqli($servername, $username, $password, $dbname);

    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    include_once './PHP/db_connection.php';

    $sql = "SELECT * FROM Drafts WHERE UserID = $userId";
    $result = $conn->query($sql);

    $drafts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $drafts[] = $row;
        }
    }

    //$conn->close();

    return $drafts;
}

// Fetch drafts for the current user
$userId = $_SESSION["UserID"];
$drafts = getDrafts($userId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Upload</title>
    <link rel="stylesheet" href="./Style/post.css">
    <!-- API-KEY: jtp7t1hjek69tycvowk8zb5v6wdhgxdw80xgwnyd1e9zqe1v -->
    <script src="https://cdn.tiny.cloud/1/jtp7t1hjek69tycvowk8zb5v6wdhgxdw80xgwnyd1e9zqe1v/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            plugins: 'image',
            toolbar: 'image',
            images_upload_url: './PHP/imgUpload.php', // Change this to your server-side image upload script
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            }
        });

        function submitPost() {
            // Retrieve the HTML content of the editor
            var content = tinymce.get('mytextarea').getContent();

            // Set the HTML content to a hidden input field
            document.getElementById('htmlInput').value = content;
            document.getElementById('contentType').value = "post";

            // Submit the form
            document.getElementById("postForm").submit();
        }

        function submitDraft() {
            // Retrieve the HTML content of the editor
            var content = tinymce.get('mytextarea').getContent();

            // Set the HTML content to a hidden input field
            document.getElementById('htmlInput').value = content;
            document.getElementById('contentType').value = "draft";

            // Submit the form
            document.getElementById("postForm").submit();
        }

        // Function to load draft content into the editor
        // function loadDraft(draftId) {
        //     // Implement the logic to load the selected draft into the editor
        //     // You can use AJAX to fetch the draft content from the server
        //     // and then set it as the content of the editor
        //     // Example using jQuery AJAX:
        //     $.ajax({
        //         url: 'loadDraft.php',
        //         method: 'POST',
        //         data: { draftId: draftId },
        //         success: function (response) {
        //             tinymce.get('mytextarea').setContent(response);
        //         },
        //         error: function () {
        //             alert('Error loading draft.');
        //         }
        //     });
        // }

        function setValues(title, content) {
            // Set the draft title and content in the form
            document.getElementById('title').value = title;
            tinymce.get('mytextarea').setContent(content);
        }

        

    </script>
</head>

<body>
    <header>
        <h1>Blog Post Upload</h1>
    </header>

    <div class="container">
    <div id="drafts" method="post">
    <h3>Drafts</h3>
    <!-- Display drafts here -->
    <?php foreach ($drafts as $draft): ?>
        <div class="card" data-draft-id="<?php echo $draft['DraftID']; ?>">
            <h3 class="card-title">
                <?php echo $draft['Title']; ?>
            </h3>
            <div class="card-content">
                <?php echo $draft['Content']; ?>
            </div>
            <button onclick="setValues('<?php echo addslashes($draft['Title']); ?>', '<?php echo addslashes($draft['Content']); ?>')">Load Draft</button>
            
            <a href="./PHP/deleteDraft.php?draftid=<?php echo $draft['DraftID']; ?>"><button>Delete Draft</button></a>

        </div>
        <hr>
    <?php endforeach; ?>
</div>


        <form id="postForm" action="./PHP/uploadPost.php" method="post" enctype="multipart/form-data">
            <label for="title">Blog Post Title:</label>
            <input type="text" id="title" name="title" required>

            <!-- Add a dropdown for selecting multiple categories -->
            <div class="mb-3" style="margin-bottom: 20px;">
                <label for="categories" class="form-label">Select Categories:</label>
                <select class="form-select" id="categories" name="categories[]" multiple required>
                    <?php
                    // Load categories from the database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "blog_website";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM Categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["CategoryID"] . '">' . $row["CategoryName"] . '</option>';
                        }
                    } else {
                        echo '<option disabled>No categories found</option>';
                    }

                    $conn->close();
                    ?>
                </select>
            </div>

            <label for="content">Blog Post Content:</label>
            <textarea id="mytextarea" name="mytextarea" rows="8" required></textarea>

            <!-- Hidden input fields to store the HTML content and content type -->
            <input type="hidden" id="htmlInput" name="htmlInput">
            <input type="hidden" id="contentType" name="contentType">

            <input type="submit" value="Upload Post" onclick="submitPost()">
            <input type="submit" value="Save Draft" onclick="submitDraft()">
            <a id="goBack" href="./HomePage.php">Go Back</a>
        </form>
    </div>
</body>

</html>