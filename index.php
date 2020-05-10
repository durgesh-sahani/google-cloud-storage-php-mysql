<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Tutorials : Google Cloud Platform</title>
    <style>
        .header {
            background: cornflowerblue; color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="text-center" style="margin-top: 5px; padding-top: 0;">Google Cloud Platform(GCP)</h1>
            <hr>
            <h2 class="text-center"><strong>Part11:</strong> Publish PHP & Mysql Based Code on Google Cloud Compute Engine</h2>
        </div>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="file" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" name="upload" class="btn btn-primary form-control">Upload</button>
            </div>
        </form>
        <?php
            include "storage.php";
            include "DbConnect.php";
            $storage = new storage();
            /*Create a new bucket*/
            // $storage->createBucket('durgeshsahani');

            /*List all bucket*/
            // $storage->listBuckets();

            /*Upload a file*/
            if (isset($_POST['upload'])) {
                $db = new DbConnect();
                $conn = $db->connect();
                $sql = "INSERT INTO files values(null, :name, :size, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $_FILES['file']['name']);
                $stmt->bindParam(':size', $_FILES['file']['size']);
                $stmt->execute();
                $storage->uploadObject('durgesh', $_FILES['file']['name'], $_FILES['file']['tmp_name']);
            }

            /*List objects under a bucket*/
            //$storage->listObjects('durgesh');

            /*Delete an object*/
            //$storage->deleteObject('durgesh', 'gcp.png');

            /*Delete a bucket*/
            //$storage->deleteBucket('sahani');

            /*Download file*/
            // $storage->downloadObject('durgesh', 'notes.txt', "D:\\tutorials\\notes_new.txt");

            /*Edit a file*/
           /*$str =  file_get_contents('gs://durgesh/notes.txt');
           echo "<pre>";
           echo $str;
           file_put_contents('gs://durgesh/notes.txt', "LearnWebCoding")*/

        $imageUrl = $storage->getImageUrl('durgesh', 'gcp.png');
        ?>
        <div class="text-center">
            <img src="<?=$imageUrl?>" alt="Google Cloud Platform" class="img-fluid rounded mx-auto d-block" width="500">
        </div>

        <div style="position: fixed; bottom: 10px; right: 10px; color: green;">
            <strong>
                Learn Web Coding
            </strong>
        </div>
    </div>
</body>
</html>