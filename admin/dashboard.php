<?php
require_once "../ini.php";
$title = "dashboard";
gettheheader();
    if(! isset($_SESSION['Adminuser'])  )
    {
 //     $_SESSION['access'] ="<p class='alert alert-danger'> sorry  account   not allowed to acces this page</p>";
       $_SESSION['access'] = '<div class="alert alert-danger alert-dismissible fade show login-alert" role="alert">
    Wellcome<strong>  sorry  account   not allowed to acces this page </strong>.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>'; 
       header("location: /admin/");
       session_write_close();
       exit();
    }

    get_dashboard_navbar();
    ;
    ?>
   
    <!-- here start dashboard -->
    <div class="dashboard-stats">
      <div class="container">
         
      <h1 class="text-center members-heading">
         Members stats
      </h1>
      

         <div class="member-container">
            <div class="box members-count">
                  <h3>
                     all members
                  </h3>
                  <span>
                  <a href="members.php?action=newmembers"> <?= get_count("Count(UserId)","users") ?></a>
                  </span>
            </div>
            <div class="box pending-member">
                  <h3>
                  pending members
                  </h3>
                  <span>
                     <a href="members.php?action=newmembers&approved=pending"> <?= get_count("Count(UserId)","users",'WHERE RegStatus = 0') ?></a>
                  </span>
            </div>
            <div class="box comment-count">
                  <h3>
                     all items 
                  </h3>
                  <span>
                  <a href="items.php?action=newitems"> <?= get_count("Count(itemId)","items") ?></a>
                  </span>
            </div>
            <div class="box blocked-member">
                  <h3>
                     all comments 
                  </h3>
                  <span>
                  <a href="comments.php?action=allcomments"> <?= get_count("Count(commentsId)","comments") ?></a>
                  </span>
            </div>

            </div>

            <!-- start lest stats -->
            <div class="last-stats">
            <div class="card">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> Items</h3>
                  </div>
                  <ul class="list-group list-group-flush">
                     <?PHP 
                     $result = get_last_by_order('*','items','itemId','DESC',NULL, $limit);
                     foreach($result as $item)
                     {
                        if(!empty($item))
                        {
                           if($item['itemApprove'] == 0)
                           {?>
   
                            <li class="list-group-item list-activae-member">
                            <span><?= $item['itemName']?></span>
                            <a href="/admin/items.php?action=item_approve&itemId=<?=$item['itemId']?>&dash=yes "
                            title='activate'
                               onclick=" if (! confirm('are you sure to activate'))  return false"
                               ><i class="fas fa-check active-item"></i></a> 
                            </li>
                           <?php }
                              
                              else {?>
                              
                              <li class="list-group-item"><?= $item['itemName']?></li>
                              <?php }
                        }
                        else
                        {
                           echo "thers is no item\'s here";
                        }
                     }

                     ?>
                  </ul>
               </div>
               <!-- start last members -->
            <div class="card">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> memebers</h3>
                  </div>
                  <ul class="list-group list-group-flush">
                     <?PHP 
                     $result = get_last_by_order('*','users','UserId','DESC',NULL, $limit);
                     foreach($result as $user)
                     {
                        if($user['RegStatus'] == 0)
                        {?>

                         <li class="list-group-item list-activae-member">
                         <span><?= $user['UserName']?></span>
                         <a href="/admin/members.php?action=activate&UserId=<?=$user['UserId']?>&dash=yes "
                         title='activate'
                            onclick=" if (! confirm('are you sure to activate'))  return false"
                            ><i class="fas fa-check active-user"></i></a> 
                         </li>
                        <?php }
                       
                       else {?>
                     
                     <li class="list-group-item"><?= $user['UserName']?></li>
                  <?php }}

                     ?>
                  </ul>
               </div>

                        <!-- end last members -->
              <!-- start comments card -->
              <div class="card">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> comments</h3>
                  </div>
                  <ul class="list-group list-group-flush dashboard-comments">
                     <?PHP 
                     $sql = "SELECT comments.*,items.itemName as itemName,users.userName as userName FROM comments
                     INNER JOIN items 
                     on comments.itemId = items.itemId
                     INNER JOIN users 
                     on comments.userId = users.userId ORDER BY commentsId DESC LIMIT $limit;
                     ";
                     global $conn;
                     $stmt = $conn->prepare($sql);
                     $stmt->execute();
                     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     // <!-- commentsId commentsDescription commentsApprove userId itemId commentsDate -->
                     foreach($results as $comment)
                     { ?>

                     <li class="list-group-item list-group-comment">
                           <span class="author"><a href="/admin/members.php?action=newmembers&UserId=<?=$comment['userId']?>&dash=yes"><?= $comment['userName'] ?></a></span>
                           <span class="author-comment"><?= $comment['commentsDescription'] ?></span>
                         
                     </li>
                  <?php }

                     ?>
                  </ul>
               </div>
              <!-- END comments card -->
              <!-- start TEST card -->
              <div class="card">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> memebers</h3>
                  </div>
                  <ul class="list-group list-group-flush">
                     <li class="list-group-item"> there's no item to show</li>
                  </ul>
               </div>
              <!-- END TEST card -->
              <!-- start comments card -->
              <div class="card">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> comments</h3>
                  </div>
                  <ul class="list-group list-group-flush dashboard-comments">
                     <?PHP 
                     $sql = "SELECT comments.*,items.itemName as itemName,users.userName as userName FROM comments
                     INNER JOIN items 
                     on comments.itemId = items.itemId
                     INNER JOIN users 
                     on comments.userId = users.userId ORDER BY commentsId DESC LIMIT $limit;
                     ";
                     global $conn;
                     $stmt = $conn->prepare($sql);
                     $stmt->execute();
                     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     // <!-- commentsId commentsDescription commentsApprove userId itemId commentsDate -->
                     foreach($results as $comment)
                     { ?>

                     <li class="list-group-item list-group-comment">
                           <span class="author"><a href="/admin/members.php?action=newmembers&UserId=<?=$comment['userId']?>&dash=yes"><?= $comment['userName'] ?></a></span>
                           <span class="author-comment"><?= $comment['commentsDescription'] ?></span>
                         
                     </li>
                  <?php }

                     ?>
                  </ul>
               </div>
              <!-- END comments card -->
              <!-- start TEST card -->
              <div class="card" id="com">
                  <div class="card-header">
                    <?php $limit = 5; ?>
                     <h3>last <strong> <?= $limit?></strong> memebers</h3>
                  </div>
                  <ul class="list-group list-group-flush">
                     <li class="list-group-item"> there's no item to show</li>
                  </ul>
               </div>
              <!-- END TEST card -->

            </div>
         </div>
      </div>
    </div>
    <!-- end dashbaord -->
   <?php
    getthefooter(); ?>


 