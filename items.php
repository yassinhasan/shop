<?php
ob_start();
require_once  "ini.php";
$title = "profile";


get_main_webisite_header();
get_main_webisite_navbar(); 
$message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
echo $message;
$_SESSION['message'] = "";
?>

<div class="item">
   
    <div class="container">
                <?php
                global $conn;
                $itemId = isset($_GET['itemId'])? $_GET['itemId'] : 0 ;
                $sql = "SELECT items.*,users.FullName  FROM items
                JOIN 
                    users
                ON
                    items.userId = users.userId    
                WHERE items.itemId = :itemId
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
                if($stmt->execute())
                {
                    $items = $stmt->fetchAll();
                    $item = array_shift($items);
                    if(is_array($item) && !empty($item))
                    { ?>
                <!-- start item -->
                <h3 class="item-name"><?= $item['itemName'] ?></h3>
            <div class="box">
                        <div class="item-section">
                            <div class="card">
                            <?php
                            if(!empty($item['itemImage']))
                            { ?>
                                <img src="./themes/images/items/<?= $item['itemName']."/".$item['itemImage'] ?>" class="card-img-top" alt="...">
                                <?php 
                            }
                            else
                            { ?>

                                <img src="./themes/images/items/placeholder_new.jpg ?>" alt="test"
                                class="card-img-top" alt="...">
                                
                                
                                <?php 
                            }
                            ?>


                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['itemName'] ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="item-stats">
                            <div class="card">
                                <div class="card-header">
                                    item descpiption
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class='list-group-item'><?= $item['itemDescription'] ?></li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    item price
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class='list-group-item'><?= $item['itemPrice'] ?> SR</li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    date item added
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class='list-group-item'><?= $item['itemsAddDate'] ?></li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    item rating
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class='list-group-item'>

                                    <?php
                                                for($x= 0 ; $x <  $item['itemRating'] ; $x++)
                                                { 
                                                    echo "<span><i class='fas fa-star start-chekced'></i></span>";
                                                    }

                                                    for($x= 0 ; $x < 5 - $item['itemRating'] ; $x++)
                                                    { 
                                                        echo "<span><i class='fas fa-star'></i></span>";
                                                    }
                                                    ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    added by
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class='list-group-item'><a href="profile.php?userId=<?= $item['userId']?>"><?= $item['FullName'] ?></a></li>
                                </ul>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Tags
                                </div>
                                <ul class="list-group list-group-flush">
                                    <?php  
                                    $alltags = explode(",",$item['tags']);
                                    echo "<li class='list-group-item'>";
                                    foreach($alltags as $tag)
                                    { ?>
                                    <span><a href="tags.php?tagname=<?= $tag ?> "> <?= $tag ?>   </a> | 
                                    <span>

                              <?php }
                                    ?>
                                   </li> 
                                </ul>
                            </div>
                        </div>
                        
            </div>
            <!-- END item -->
            <!-- start comments   -->
               <div class="item-comments">
                    <div class="box">
                        <div class="hide-for-comment">

                        </div>
                        <!-- start send comment -->
                        <?php
                           if (isset($_POST['subcomment']) && $_SERVER['REQUEST_METHOD'] == 'POST')
                            {
                                $commentdesc = isset($_POST['com-desc']) ? filter_var($_POST['com-desc'],FILTER_SANITIZE_STRING) : "";
                                  
                                if($commentdesc != "")
                                {

                                    $userid_comment = isset($_SESSION['User']['UserId']) ? $_SESSION['User']['UserId'] : 100;
                                    $userid_comment = isset($_SESSION['Admin']['UserId']) ? $_SESSION['Admin']['UserId'] : 100;
                                    $sql2 = "INSERT INTO `comments` (`commentsDescription`, `userId`, `commentsDate`, `itemId`) VALUES (:cdesc, :cusid, NOW(), :itid);";
                                    $stmt2 = $conn->prepare($sql2);
                                    $stmt2->bindValue(":cdesc",$commentdesc,PDO::PARAM_STR);
                                    $stmt2->bindValue(":cusid",$userid_comment,PDO::PARAM_INT);
                                    $stmt2->bindValue(":itid",$itemId,PDO::PARAM_INT);
                                    if($stmt2->execute())
                                    {
                                        if($stmt2->rowCount() > 0)
                                        {
                                            $_SESSION['message'] ="<p class='alert alert-success'> <strong> ".$stmt2->rowCount() ."</strong> comment add succesfully</p>";
                                            header("refresh: 0");
                                            exit;
                                        }
                                        else
                                        {
                                            $_SESSION['message'] ="<p class='alert alert-danger'>>no cooment  added</p>";
                                            header("refresh: 0");
                                            exit;
                                        }
                                    }
                                }
                            }

                        ?>
                        <div class="form-comment">
                            <form action="<?= $_SERVER['PHP_SELF']."?itemId=".$itemId?>" method="POST" class="form" enctype="multipart/form-data">
                            <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="form-label">leave comment</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="com-desc" required></textarea>
                            <input type="submit" class="btn btn-info" name="subcomment" value="add-comment">
                            </div>
                            </form>
                        </div>
                        <?php
                        $sql = "SELECT comments.*,users.* FROM comments 
                        INNER JOIN users 
                        ON
                        comments.userId = users.UserId
                        WHERE 
                        comments.itemId = :itemId
                        ";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
                        if($stmt->execute())
                        {
                            $comments = $stmt->fetchAll();
                            if(is_array($comments) && !empty($comments))
                            {
                               echo "<h3 class='all-comments'>all comments</h3>";
                             foreach($comments as $comment)
                            {
                            ?>
                                
                                <div class="show-comments">
                                    <div class="user-comment">
                                        <div class="user-comment-ifno">
                                            <div class="box">
                                            <img src="./themes/images/uploads/<?= trim($comment['UserName'])."/".$comment['avatar']?>" class="card-img-top" alt="...">
                                            
                                            <a href="profile.php?userId=<?= $comment['userId']?>"><?= $comment['FullName'] ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment">
                                    <?= $comment['commentsDescription'] ?>
                                    </div>
                                </div>

                            <?php } }
                            else
                            {
                                echo " <h3 class='all-comments'>be first to add comment</h3>";
                                echo "<div class='no-comment'>sorry no comments to show</div>";
                                
                            }
                        }
                        ?>
                    </div>
               </div>                                     
            <!-- end comments   -->
              
            <!-- IF NO ITEMS with this id -->
            <?php
            }
                else
                {
                    echo "sorry no items";
                }
            }
                


            

        
        ?>
    </div>
</div>


<?php  get_main_webisite_footer();
ob_end_flush();
?>