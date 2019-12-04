<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mason Theme - About</title>
<!--

Template 2094 Mason

http://www.tooplate.com/view/2094-mason

-->
<!-- load stylesheets -->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400">   <!-- Google web font "Open Sans", https://fonts.google.com/ -->
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">           <!-- Font Awesome, http://fontawesome.io/ -->
<link rel="stylesheet" href="css/bootstrap.min.css">                                 <!-- Bootstrap styles, https://getbootstrap.com/ -->
<link rel="stylesheet" href="css/tooplate-style.css">                              	 <!-- Templatemo style -->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body>
    <div class="container-fluid">
        <div class="tm-body">
            <div class="tm-sidebar sticky">
                <section id="welcome" class="tm-content-box tm-banner margin-b-15">
                    <div class="tm-banner-inner">
                        <i class="fa fa-film fa-4x margin-b-40"></i>
                        <h1 class="tm-banner-title">Mason</h1>
                        <p class="tm-banner-subtitle">Photo Sharing</p>                   
                    </div>                    
                </section>
                <nav class="tm-main-nav">
                    <ul class="tm-main-nav-ul">
                        <li class="tm-nav-item"><a href="index.php" class="tm-nav-item-link tm-button">Gallery</a>
                        </li>
                        <li class="tm-nav-item"><a href="timeline.php" class="tm-nav-item-link tm-button">Timeline</a>
                        </li>
                        <li class="tm-nav-item"><a href="upload.php" class="tm-nav-item-link tm-button active">Upload</a>
                    </ul>
                </nav>
            </div>
            <div class="tm-main-content">
                <div class="row mb-5">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center mb-md-0 mb-4"><img src="img/575x400-01.jpg" alt="Image" class="img-fluid"></div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pl-md-4 tm-flex-center">
                        <div class="tm-about-text tm-flexbox-ie-fix">
                            <h2 class="tm-orange-text mb-4">Upload new image</h2>
                            <form action="putObj.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                            </form> 
							<form action="getObj.php" method="get" enctype="multipart/form-data">
							<input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Get Image" name="get">
                            </form> 
                            <form action="uploadToDB.php" method="get" enctype="multipart/form-data">
							<input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Get Image" name="get">
                            </form> 
                        </div>                            
                    </div>
                </div> <!-- row -->
                
            </div>
        </div>
        <footer class="tm-footer text-right">
            <p>Copyright &copy; <span class="tm-current-year">2018</span> Your Company 
            
            - Designed by Tooplate</p>
        </footer> 
    </div> <!-- container-fluid -->

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>     <!-- jQuery (https://jquery.com/download/) -->
    <script>  

        $(document).ready(function(){
            // Update the current year in copyright
            $('.tm-current-year').text(new Date().getFullYear());        
        });

    </script>             

</body>
</html>
