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
    $commentsId = isset($_GET['commentsId']) && is_numeric($_GET['commentsId']) ? $_GET['commentsId'] : 0; 
    $join = "SELECT comments.*,items.itemName as itemName,users.userName as userName FROM comments
    INNER JOIN items 
    on comments.itemId = items.itemId
    INNER JOIN users 
    on comments.userId = users.userId
     WHERE commentsId  = :commentsId LIMIT 1
      ";
    // $sql = "SELECT * FROM comments WHERE commentsId  = :commentsId LIMIT 1";
    global $conn;
    $stmt = $conn->prepare($join);
    $stmt->bindValue(":commentsId",$commentsId,PDO::PARAM_INT);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $comment = array_shift($comments);
             

                ?>

<div class="container theform">
        <h1> Edit comment</h1>
         <!-- commentsId commentsDescription commentsApprove userId categoryId commentsDate -->

        <form action="?action=comments_update" method="POST" enctype="application/x-www-form-urlencoded form-edit">
            <input type="hidden" value="<?= $commentsId ?>"  name="commentsId">
            <div class="mb-3 col-md-6">
                <label for="commentsDescription" class="form-label">your name</label>
                <textarea type="textarea" name="commentsDescription" class="form-control" id="commentsDescription" required> <?= isset($comment['commentsDescription']) ? $comment['commentsDescription'] : "" ?> 
                </textarea>
            </div>
     

            <div class="mb-3 col-md-6">
                <select class="chosen-select" name="categoryId">
                    <?php 
                    $sql = "SELECT itemId,itemName FROM items";
                    global $conn;
                    $stmt = $conn->prepare($sql);
                    if($stmt->execute())
                    {
                        if($stmt->rowCount() > 0)
                        { 
                            $results = $stmt->fetchAll();
                            foreach($results as $result)
                            { ?>
                                <option value="<?= $result['itemId']?>"
                               <?= ($result['itemId'] == $comment['itemName']) ? 'selected' : ''?>
                                ><?= $result['itemName']?></option>
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
                               <?= ($result['userId'] == $comment['userId']) ? 'selected' : '' ?>  >
                                
                                <?= $result['userName']?></option>
                     <?php   }
                       }
                    }
                    
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary submit" name="save">Submit</button>
            </form>
</div>

<?php
            }
            else
            {
                error_redirection("soory eroor");
            }
        }

        
        ?>