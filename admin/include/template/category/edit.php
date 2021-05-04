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

    //  CategoryId   // category (`CategoryName`, `CategoryDescription`, `Ordering`, `Visibility`, `AllowComments`, `AllowAds`)
    $CategoryId = isset($_GET['CategoryId']) && is_numeric($_GET['CategoryId']) ? $_GET['CategoryId'] : 0; 
    $sql = "SELECT * FROM category WHERE CategoryId  = :CategoryId LIMIT 1";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":CategoryId",$CategoryId,PDO::PARAM_INT);
    if ($stmt->execute())
    {

        $count = $stmt->rowCount();
        if($count > 0)
            {
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $category = array_shift($categories);

                ?>

<div class="container theform">
        <h1> Edit category</h1>
        <form action="?action=cat_update" method="POST" enctype="application/x-www-form-urlencoded form-edit">
            <input type="hidden" value="<?= $CategoryId ?>"  name="CategoryId">
            <div class="mb-3 col-md-6">
                <label for="CategoryName" class="form-label">Category Name </label>
                <input type="text" name="CategoryName" class="form-control check-edit-category" id="CategoryName"
                value="<?= isset($category['CategoryName'])?$category['CategoryName'] : "" ?>"
                required
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="CategoryDescription" class="form-label"> Category Description</label>
                <input type="text" name="CategoryDescription" class="form-control" id="CategoryDescription"
                value="<?= isset($category['CategoryDescription'])?$category['CategoryDescription'] : "" ?>"
                >
            </div>
            <div class="mb-3 col-md-6">
                <label for="Ordering" class="form-label">Ordering Category</label>
                <input type="number" name="Ordering"	 class="form-control check-email" id="Ordering" 
                value="<?= isset($category['Ordering']) ? $category['Ordering'] : 0 ?>"
                min="0" step="1"
                >
              
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">Visibility</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Visibility-yes" name="Visibility" value="yes" 
                      checked
                        >
                        
                        <label for="Visibility-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="Visibility-no" name="Visibility" value="no"
                        <?= add_check_onedit($category,"Visibility")  ?> 
                        >
                        
                        <label for="Visibility-no">no</label>
                    </div>
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">AllowComments</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowComments-yes" name="AllowComments" value="yes"
                        checked
                        >
                        <label for="AllowComments-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowComments-no" name="AllowComments" value="no"
                        <?= add_check_onedit($category,"AllowComments")  ?>
                         >
                        <label for="AllowComments-no">no</label>
                    </div>
            </div>
            <div class="mb-3 col-md-6 check-radio">
                <label class="form-label">AllowAds</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowAds-yes" name="AllowAds" value="yes"
                        checked
                        >
                        <label for="AllowAds-yes">yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="AllowAds-no" name="AllowAds" value="no" 
                        <?= add_check_onedit($category,"AllowAds")  ?>
                        >
                        <label for="AllowAds-no">no</label>
                    </div>
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