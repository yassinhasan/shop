<?php 

    // var_dump($_SESSION['message']);
    $message =(isset($_SESSION['message']) && !empty($_SESSION['message'])) ? $_SESSION['message'] : false;
    
    if(false != $message && is_array($message))
    {
        foreach($message as $msg)
        {
            echo $msg;
        }
    }
    $_SESSION['message'] = "";
    $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? $_GET['itemId'] : 0; 
     $join = "SELECT items.*,category.categoryId as categoryId,users.userId as userId FROM items
     INNER JOIN category 
     on items.categoryId = category.categoryId
     INNER JOIN users 
     on items.userId = users.userId
     WHERE itemId  = :itemId LIMIT 1
      ";
    // $sql = "SELECT * FROM items WHERE itemId  = :itemId LIMIT 1";
    global $conn;
    $stmt = $conn->prepare($join);
    $stmt->bindValue(":itemId",$itemId,PDO::PARAM_INT);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $item = array_shift($items);
             

                ?>

<div class="container theform">
        <h1> Edit Item</h1>
                <!-- // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId -->
        <form action="?action=items_update" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?= $itemId ?>"  name="itemId">
            <div class="mb-3 col-md-6">
                <label for="itemName" class="form-label">your name</label>
                <input type="text" name="itemName" class="form-control check-edit-username" id="itemName" 
                required
                value="<?= isset($item['itemName']) ? $item['itemName'] : "" ?> ">
            </div>
            <div class="mb-3 col-md-6">
                    <label for="itemDescription" class="form-label"> Item Description</label>
                    <input type="text" name="itemDescription" class="form-control" id="itemDescription"
                    value="<?= isset($item['itemDescription'])?$item['itemDescription'] : "" ?>"
                    
                    >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="itemPrice" class="form-label">itemPrice </label>
                    <input type="text" name="itemPrice"	 class="form-control" id="itemPrice" 
                    value="<?= isset($item['itemPrice'])?$item['itemPrice'] : "" ?> "
                    >
                </div>         

            <div class="mb-3 col-md-6">
                    <input type="file" name="avatar" class="form-control" id="itemImage">
            </div>
            <div class="mb-3 col-md-6">
                <select class="form-select all-countries" name="itemCountryMade">
                <option value="">chose country</option>
                </select>
            </div> 
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="itemRating">
                    <option value="5">***** </option>
                    <option value="4">****</option>
                    <option value="3">***</option>
                    <option value="2">**</option>
                    <option value="1">*</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="categoryId">
                    <?php 
                    $sql = "SELECT categoryId,categoryName FROM category";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if($stmt->execute())
                    {
                        if($stmt->rowCount() > 0)
                        { 
                            $results = $stmt->fetchAll();
                            foreach($results as $result)
                            { ?>
                                <option value="<?= $result['categoryId']?>"
                               <?= ($result['categoryId'] == $item['categoryId']) ? 'selected' : ''?>
                                ><?= $result['categoryName']?></option>
                     <?php   }
                       }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="userId">
                    <option value="">choose user</option>
                    <?php 
                    $sql = "SELECT userId,userName FROM users";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if($stmt->execute())
                    {
                        if($stmt->rowCount() > 0)
                        { 
                            $results = $stmt->fetchAll();
                            foreach($results as $result)
                            { ?>
                                <option value="<?= $result['userId']?>"
                               <?= ($result['userId'] == $item['userId']) ? 'selected' : '' ?>  >
                                
                                <?= $result['userName']?></option>
                     <?php   }
                       }
                    }
                    
                    ?>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                    <label for="tags" class="form-label">tags Names </label>
                    <input type="text" name="tags" class="form-control" id="tags"
                    value="<?= isset($item['tags'])?$item['tags'] : "" ?>">
            </div>

            <button type="submit" class="btn btn-primary submit" name="save">Submit</button>
            </form>

<h3> item  commnets</h3>
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
            comment by 
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
            // $sql = "SELECT * FROM users WHERE UserI != ". $_SESSION['UserId']."";
            // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId
            // $pening = "";
            // $pening = (isset($_GET['approved']) && $_GET['approved'] == 'pending') ? ' AND RegStatus = 0' : "";
            $sql = "SELECT comments.*,items.itemName as itemName,users.userName as userName FROM comments
            INNER JOIN items 
            on comments.itemId = items.itemId
            INNER JOIN users 
            on comments.userId = users.userId
            WHERE comments.itemId = $itemId;
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
                       <a href="/admin/comments.php?action=comments_edit&commentsId=<?=$comments['commentsId']?>"
                       onclick=" if (! confirm('are you sure to edit'))  return false"
                       title='edite commentss'
                       ><i class="fas fa-edit edit-users"></i>
                       </a> 
                       <a href="/admin/comments.php?action=comments_delete&commentsId=<?=$comments['commentsId']?>"
                       title='delete comments'
                       onclick=" if (! confirm('are you sure to delete'))  return false"
                       ><i class="fas fa-times delete-users"></i>
                       </a> 
                     <?php  if ($comments['commentsApprove'] == 0 )
                     { ?>
                        <a href="/admin/comments.php?action=comments_approve&commentsId=<?=$comments['commentsId']?>"
                        title='approve'
                        onclick=" if (! confirm('are you sure to activate'))  return false"
                        ><i class="fas fa-check active-users"></i>
                    </a>
                     <?php }
                     else
                     { ?>
                        <a href="/admin/comments.php?action=comments_pending&commentsId=<?=$comments['commentsId']?>"
                       onclick=" if (! confirm('are you sure to pending this comments'))  return false"
                       title='pending comments'
                       ><i class="fas fa-user-lock block-users "></i>
                       </a> 

                   <?php  }
                     ?> 

                    </td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
                </div>
                </div>
         <?php   }
            else
            {
                error_redirection("soory eroor");
            }
        }

        
        ?>