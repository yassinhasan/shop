
<?=  
    
    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
    $_SESSION['message'] = "";
?>

<div class="all-members">
<div class="add-member">
<button class="btn btn-success btn-sm"> <a href="?action=items_add"> Add New memeber
<i class="fas fa-plus"></i>
</a></button>
</div>
<h3> All items</h3>
<div class="table-responsive">
<table class="table table-bordered text-center table-hover table-striped">
    <thead class="table-dark">
    <!-- // itemId	itemName	itemDescription	itemPrice	itemsAddDate	itemCountryMade	itemImage	itemStatus	itemRating	categoryId	userId -->
        <tr>
            <th>
            item ID
            </th>
            <th>
            itemName
            </th>
            <th>
            itemDescription
            </th>
            <th>
            itemPrice
            </th>
            <th>
            itemsAddDate
            </th>
            <th>
            itemCountryMade
            </th>
            <th>
            NO OF COMMENTS
            </th>
            <th>
            item approved
            </th>
            <th>
            itemRating
            </th>
            <th>
            category
            </th>
            <th>
            user
            </th>
            <th>
            tags
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
            $sql = "SELECT items.*,category.categoryName as categoryName,users.userName as userName FROM items
            INNER JOIN category 
            on items.categoryId = category.categoryId
            INNER JOIN users 
            on items.userId = users.userId
             ";
            global $conn;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
            foreach($items as $item)
            { ?>
                <tr class="<?= ($item['itemApprove'])== 0 ? 'pending' : '' ?>">
                    <td>
                    <?= $item['itemId'] ?>
                    </td>
                    <td>
                    <?= $item['itemName'] ?>
                    </td>
                    <td>
                    <?= $item['itemDescription'] ?>
                    </td>
                    <td>
                    <?= $item['itemPrice'] ." S.R"?>
                    </td>
                    <td>
                    <?= $item['itemsAddDate'] ?>
                    </td>
                    <td>
                    <?= $item['itemCountryMade'] ?>
                    </td>
                    <td>
                    <a href="/admin/comments.php?action=allcomments&itemId=<?=$item['itemId']?>">
                    <?= get_count("Count(commentsId)","comments"," WHERE itemId = ". $item['itemId'] )?>
                    </a>
                    </td>
                    <td>
                    <?= ($item['itemApprove'] == 0)? 'pending' : 'approved' ?>
                    </td>
                    <td>
                    <?=  get_rating($item['itemRating']) ?>
                    </td>
                    <td>
                    <?= $item['categoryName'] ?>
                    </td>
                    <td>
                    <?= $item['userName'] ?>
                    </td>
                    <td>
                    <?= $item['tags'] ?>
                    </td>
                    <td class="edit-action">
                       <a href="?action=items_edit&itemId=<?=$item['itemId']?>"
                       onclick=" if (! confirm('are you sure to edit'))  return false"
                       title='edite items'
                       ><i class="fas fa-edit edit-users"></i></a> 
                       <a href="?action=items_delete&itemId=<?=$item['itemId']?>"
                       title='delete items'
                       onclick=" if (! confirm('are you sure to delete'))  return false"
                       ><i class="fas fa-times delete-users"></i>
                       <?php 
                       
                       if($item['itemApprove'] == 0)
                       { ?>
</a> 
                        <a href="?action=item_approve&itemId=<?=$item['itemId']?>"
                            title='approve'
                            onclick=" if (! confirm('are you sure to activate'))  return false"
                            ><i class="fas fa-check active-users"></i>
                        </a> 
                      <?php  }else
                       { ?>
                        <a href="?action=item_pending&itemId=<?=$item['itemId']?>"
                       onclick=" if (! confirm('are you sure to pending this item'))  return false"
                       title='pending item'
                       ><i class="fas fa-user-lock block-users "></i>
                       </a> 

                      <?php    } 
                       
                       ?>
                  

                    </td>
             </tr>
            <?php }
        ?>
    </tbody>
</table>
</div>
</div>
