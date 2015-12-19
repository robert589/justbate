<!DOCTYPE html>
<html lang="en">

<head>

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="web/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="web/css/simple-sidebar.css" rel="stylesheet">
    <link href="frontend/web/css/style.css" rel="stylesheet">
</head>



<body>
    
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Feeds
                    </a>
                </li>
                <li> 
                    <a href="#">All Activity</a>
                </li>
                <li>
                    <a href="#">Critique</a>
                </li>
                <li>
                    <a href="#">Solution</a>
                </li>
                <li>
                    <a href="#">Proposal</a>
                </li>
                <li>
                    <a href="#">Followers <span class="badge">5</span></a>
                </li>
                <li>
                    <a href="#">Following <span class="badge">5</span></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <div id="page-content">

        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        <img src="girl.jpg" alt="Profile Picture" style="width:180px;height:180px;"> </div>
                        <div class="col-lg-8">
                            <div id="displayName">
                                <p>Grace Christina</p> <!--need to extract from database-->
                            </div>
                            <div id="displayDetails">
                                <p>Write description about yourself</p> <!--can update here-->
                                <button type="button" class="btn btn-primary">Followers <span class="badge">100</span></button>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        <div class="well well-sm">
            <h4>Basic Information</h4>      
        </div>
       
        <div class="well well-sm">
            <h4>Contact Information</h4>      
        </div>
        <div class="well well-sm">
            <h4>Additional Information</h4>      
        </div>

        <a href='#textboxid' onclick='document.getElementById("textboxid").focus();'>Click me</a>
        
    </div>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>
