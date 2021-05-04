
<?=  
    
    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
    $_SESSION['message'] = "";
?>

<div class="all-members">

<h3> All commnets</h3>
<div class="table-responsive">
<table class="table table-bordered text-center table-hover table-striped">
    <thead class="table-dark">
    <!-- commentsId commentsDescription commentsApprove userId categoryId commentsDate -->
        <tr>
            <th>
            commentsId
            </th>
            <th>
            comments Descr
            </th>
            <th>
            user 
            </th>
            <th>
            category
            </th>
            <th>
            comments Date
            </th>
            <th class="action">
                action
            </th>
        </tr>
    </thead>
    <tbody>
        <?php

            $where = "";
            if(isset($_GET['itemId']))
            {
                $itemId = $_GET['itemId'];
                $where = " WHERE comments.itemId = $itemId"; 
            }

            
    
            // $sql = "SELECT * FROM users WHERE UserI != ". $_SESSION['UserId']."";
            // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId
            // $pening = "";
            // $pening = (isset($_GET['approved']) && $_GET['approved'] == 'pending') ? ' AND RegStatus = 0' : "";
            $sql = "SELECT comments.*,items.itemName as itemName,users.userName as userName FROM comments
            INNER JOIN items 
            on comments.itemId = items.itemId
            INNER JOIN users 
            on comments.userId = users.userId $where
             ";
            global $conn;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // <!-- commentsId commentsDescription commentsApprove userId itemId commentsDate -->
            foreach($comments as $comments)
            { ?>
                <tr class="<?= ($comments['commentsApprove'])== 0 ? 'pending' : '' ?>">
                    <td>
                    <?= $comments['commentsId'] ?>
                    </td>
                    <td>
                    <?= $comments['commentsDescription'] ?>
                    </td>
                    <td>
                    <?= $comments['userName']?>
                    </td>
                    <td>
                    <?= $comments['itemName'] ?>
                    </td>
                    <td>
                    <?= $comments['commentsDate'] ?>
                    </td>
                    <td class="edit-action">
                       <a href="?action=comments_edit&commentsId=<?=$comments['commentsId']?>"
                       onclick=" if (! confirm('are you sure to edit'))  return false"
                       title='edite commentss'
                       ><i class="fas fa-edit edit-users"></i>
                       </a> 
                       <a href="?action=comments_delete&commentsId=<?=$comments['commentsId']?>"
                       title='delete comments'
                       onclick=" if (! confirm('are you sure to delete'))  return false"
                       ><i class="fas fa-times delete-users"></i>
                       </a> 
                     <?php  if ($comments['commentsApprove'] == 0 )
                     { ?>
                        <a href="?action=comments_approve&commentsId=<?=$comments['commentsId']?>"
                        title='approve'
                        onclick=" if (! confirm('are you sure to activate'))  return false"
                        ><i class="fas fa-check active-users"></i>
                    </a>
                     <?php }
                     else
                     { ?>
                        <a href="?action=comments_pending&commentsId=<?=$comments['commentsId']?>"
                       onclick=" if (! confirm('are you sure to pending this comments'))  return false"
                       title='pending comments'
                       ><i class="fas fa-user-lock block-users "></i>
                       </a> 

                   <?php  }
                     ?> 

                    </td>
             </tr>
            <?php }
        ?>
    </tbody>
</table>
</div>
</div>
