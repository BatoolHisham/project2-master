<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JU-Delivery</title>
    <link rel="icon" href="./images/logo.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php session_start();  // Resume the session
                ?>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#main">
                        <img src="./images/delivery-man.png" width="70px" alt="">
                    </a>
                    <h4 class="special-header" style="color: black;">JU-Delivery</h4>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active pt-3" aria-current="page" href="./restsystem.html" style="color: black;">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-auto d-flex" href="./profilepage.php"><img id="header-profile-image"
                                        width="40px" src="./images/profile logo.png" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Profile Page Content -->
    <div class="centered-container">
        <div class="container profile-box pt-4">
            <div class="row">
                <!-- Profile Picture Section -->
                <div class="col-md-4 mt-3 text-center">
                    <img id="profile-image-preview" src="./images/profile logo.png" alt="Profile Picture"
                        class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <div class="mb-3">
                        <label for="profile-image-upload" class="btn Custom-third mt-3">Change Profile Picture</label>
                        <input type="file" id="profile-image-upload" accept="image/*" class="d-none"><br>
                        <!-- Delete Image Button -->
                        <button type="button" id="delete-profile-image" class="Custom-secondary mt-3 rounded p-2">Delete Image</button>
                    </div>
                </div>

        
                <!-- Form Section -->
                <div class="col-md-8">
                    <form action="update_driver_profile.php" method="post">
                        
                        <div class="form-group mb-3">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" class="form-control" id="phone-number" name="phone-number" value="<?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : '3'; ?>">
                        </div>
                    
                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password"  name="password" placeholder="Enter new password">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="confirm password">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm new password">
                        </div>


                        <button type="submit" id="update-profile" class="btn Custom-secondary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script src="profilepage.js"></script>

    
</body>
</html>
