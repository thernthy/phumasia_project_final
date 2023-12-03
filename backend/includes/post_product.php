<?php
include "header.php";

if (isset($_POST['p_post'])) {
    $productName = $_POST["productName"];
    $shortDescription = $_POST["shortDescription"];
    $price = $_POST["price"];
        //get data img and conver image nagme
        $image = $_FILES['image'];
        $image_name = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];
        $imageType = $_FILES['image']['type'];
        $imageExt = explode('.', $image_name);
        $imageName_convertor = strtolower(end($imageExt));
        $allowed  = array('jpg', 'jpeg', 'png');
        if(in_array($imageName_convertor,$allowed)){
            if($imageError === 0){
              if($imageSize < 500000){
                  $image_new_name =  uniqid('', true).".".$imageName_convertor;
                  $fileDestination = 'includes/asset/P_images/'.$image_new_name;
                  move_uploaded_file($imageTmpName, $fileDestination);  
                    // SQL query to insert user data into the users table
                    $query = "INSERT INTO products (productName, shortDescription, price, imageName) 
                    VALUES ('{$productName}', '{$shortDescription}', '{$price}', '{$image_new_name}')";
                        // Execute the SQL query
                        $p_post = mysqli_query($conn, $query);
                        if (!$p_post) {
                            echo "Something went wrong: " . mysqli_error($conn); // Debugging statement
                        } else {
                            echo "<script type='text/javascript'>alert('Post successful! new image name:{$image_new_name}')</script>";
                        }
              }else{
                echo "Your image is too big!";
              }
            }else{
              echo "there was an error on your file!";
            }
          }else{
            echo "You can't upload this file!";
          }
}
?>


<!-- Rest of your HTML code -->


<!-- Rest of your HTML code -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
		<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
		<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
		<script src="https://unpkg.com/dropzone"></script>
		<script src="https://unpkg.com/cropperjs"></script>
    <style>
        .image_area {
            position: relative;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .overlay {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.5);
            overflow: hidden;
            height: 0;
            transition: .5s ease;
            width: 100%;
        }

        .image_area:hover .overlay {
            height: 50%;
            cursor: pointer;
        }

        .text {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .btn-warning {
            position: absolute;
            bottom: 30px;
            right: 40%;
            left: 40%;
        }
    </style>

    <br />
    <br />
    <div class="col-md-4">&nbsp;</div>
    <div class="col-md-4">
        <div class="image_area">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="productName">Product Name:</label>
                            <input type="text" class="form-control" name="productName" id="productName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="shortDescription">Short Description:</label>
                            <input type="text" class="form-control" name="shortDescription" id="shortDescription" required>
                        </div>
                        <div class="col-md-4">
                            <label for="price">Price:</label>
                            <input type="text" class="form-control" name="price" id="price" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="upload_image" class="form-control">Select Image (PNG/JPEG/JPG)</label>
                    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept=".png,.jpg,.jpeg" required />
                </div>
                <img src="uploaded/user.png" id="uploaded_image" name="cropImage" class="img-responsive" />
                <button type="submit" name="p_post" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Before Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var $modal = $('#modal');
            var image = document.getElementById('sample_image');
            var cropper;
            $('#upload_image').change(function (event) {
                var files = event.target.files;
                var done = function (url) {
                    image.src = url;
                    $modal.modal('show');
                };

                if (files && files.length > 0) {
                    reader = new FileReader();
                    reader.onload = function (event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function () {
                canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });

                canvas.toBlob(function (blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        $('#croppedImageData').val(base64data); // Set the value of the hidden input field
                        $('#uploaded_image').attr('src', base64data); // Display the cropped image preview
                        $modal.modal('hide');
                    };
                });
            });

        });
    </script>