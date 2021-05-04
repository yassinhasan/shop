<?php
ob_start();
require_once  "ini.php";
$title = "profile";


get_main_webisite_header();
get_main_webisite_navbar(); 
?>

<div class="profile">
   
    <div class="container"> 
        <?php
        if(isset($_SESSION['User']))
        {
            $users = get_by_id("users","UserId",$_SESSION['User']['UserId']);
            $user = array_shift($users)
            
        ?>
        <p class="display-4 text-center profile-header">wellcome <?= $user['UserName'] ?></p>
        <div class="box">
            <div class="profile-section">
                <div class="card">
                    <img src="./themes/images/avatar.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $user['UserName'] ?></h5>
                        <p class="card-text">EMAIL : <?= $user['Email']?>.</p>
                        <p class="card-text">FULL Name : <?= $user['FullName']?>.</p>
                        <p class="card-text">DATE OF REFISTER : <?= $user['Reg_Date']?>.</p>
                        <a href="#" class="btn btn-primary">Edit Porfile</a>
                    </div>
                </div>
            </div>
            <div class="profile-stats">
                <div class="card">
                    <div class="card-header">
                        Last comments
                    </div>
                    <ul class="list-group list-group-flush">
                    <?php
                      $comments =   get_by_id("comments","userId",$user['UserId']);
                      
                        if(!empty($comments))
                        {

                            foreach($comments as $comment)
                            { ?>
                                <li class="list-group-item"><?= $comment['commentsDescription']?></li>

                                <?php 
                            }
                        }
                        else
                        {
                            echo "<li class='list-group-item'>there is no comments here</li>";
                        } 
                        
                    ?>
                    </ul>
                </div>
                <div class="card">
                    <div class="card-header">
                        Last Items Added BY You
                    </div>
                    <ul class="list-group list-group-flush">
                    <?php
                      $items =   get_by_id("items","userId",$user['UserId']);
                      if(!empty($items))
                      {
                        foreach($items as $item)
                            { ?>
                            <li class="list-group-item"><?= $item['itemName']?></li>

                            <?php 
                            }
                      }
                      else
                      {
                        echo "<li class='list-group-item'>there is no items click <a href='add-tems.php'> here</a></li>";   
                      }    
                        
                    ?>
                    </ul>
                </div>
            </div>
        </div>
       <?php 
       } 

       else
       { 
           header("location: login.php");
           exit;
        }
       
       
       ?>

        
    </div>
</div>


<?php  get_main_webisite_footer();
ob_end_flush();
?>