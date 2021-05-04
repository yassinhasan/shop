<?=  
    
    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
    $_SESSION['message'] = "";
?>

<div class="categories">
    <div class="container">
        <div class="card">
        <div class="card-header">
            Main category 
            <span class="oredring">
            <button class="full active" data-view='full'> <i class="fas fa-compress-alt"></i></button>
            <button  class="classic" data-view='classic'> <i class="fas fa-compress-arrows-alt classic"></i></button>
            <a href="?action=cat_add" class=""><i class="fas fa-plus" title="add category"></i></a> 
            <a href="category.php?action=newcategories&sort=asc"
                       title='sort ascnding'
                       ><i class="fas fa-chevron-up"></i></a> 
            <a href="category.php?action=newcategories&sort=desc"
                       title='sort descding'
                       ><i class="fas fa-chevron-down"></i></a>                     
            </span>
        </div>

    <?php

$sort = isset($_GET['sort']) ?$_GET['sort']: 'asc' ;

$sql = "SELECT * FROM category ORDER BY Ordering $sort ";
global $conn;
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($categories as $category)
{ ?>

        <div class="card-body">
            <h5 class="card-title"> <?=  "#".$category['CategoryId']." ".$category['CategoryName'] ?></h5>
            <p class="card-text">  <?= $category['CategoryDescription'] ?>.</p>
            <div class="cat-box">
                <div class="cat-info">
                <?= ($category['Visibility'] == "no") ? "<span class='hidden'> hidden to all</span> ": "<span class='show'> avaible to all </span> " ?>
                <?= ($category['AllowComments'] == "no") ? "<span class='dis-com'> Disabled Comments </span> " :"<span class='allow-com'> Allowed Comments </span> " ?>
                <?= ($category['AllowAds'] == "no") ? "<span class='DisAds'> Disabled Ads </span> " :"<span class='AllowAds'> Allowed Ads </span> " ?>
                </div>
                <div class="cat-edit-div">
                <a href="?action=cat_edit&CategoryId=<?=$category['CategoryId']?>"
                    onclick=" if (! confirm('are you sure to edit'))  return false"
                    title='edite category'
                    class="edit-cat"
                    ><i class="fas fa-edit edit-users"></i></a> 
                    <a href="?action=cat_delete&CategoryId=<?=$category['CategoryId']?>"
                    title='delete category'
                    class="cat-delete"
                    onclick=" if (! confirm('are you sure to delete'))  return false"
                    ><i class="fas fa-times delete-users"></i></a> 
                </div>

            </div>
           
        </div>
<?php }?>
        </div>

    </div>
</div>


