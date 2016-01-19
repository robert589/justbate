<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\User;


?>

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
                                    <?= $user->first_name ?>
                                    <?= $user->last_name ?>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                Birthday: <?= $user->birthday ?>
                             </div>
                            <div class="col-lg-8">
                                Occupation: <?= $user->occupation ?>
                            </div>
                        </div>
                    </div>

                </div>

                <br>
                <!-- /#page-content-wrapper -->
                <div class="well well-sm">
                    <h4>Recent Activity</h4>
                </div>

        </div>
        </div>
     </div>


        
        



    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    
</body>
