<?php
require_once  "ini.php";
$title = "shop";


get_main_webisite_header();
get_main_webisite_navbar(); ?>

<!-- // show all items -->
<div class="items">
<div class="container">
    <div class="item-box">
        <?php
            foreach(get_all('items','WHERE itemApprove = 1','ORDER BY itemId','desc') as $item)
            { ?>
                    <?php 
                        $datat_name = preg_replace('/\s|[0-9]|[%]/',"",$item['itemName']);
                        
                    ?>
                    <div class="item-content all-items" data-name="<?= $datat_name ?>">
                        <a 
                        href="items.php?itemId=<?= $item['itemId']?>"
                        >
                        <?php
                        if(!empty($item['itemImage']))
                        { ?>
                            <img src="./themes/images/items/<?= $item['itemName']."/".$item['itemImage'] ?>" alt="test">
                            <?php 
                        }
                        else
                        { ?>

                            <img src="./themes/images/items/placeholder_new.jpg ?>" alt="test">
                            <?php 
                        }
                        ?>
                        </a>
                        <span class="love-item"><i class="fas fa-heart rate-by-heart"></i></span>
                        <div class="item-info">
                            <p><?= $item['itemName']?></p>
                            <span><?= $item['itemPrice']?> SR</span>
                            <div class="item-rating"> 
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
                            </div>
                        </div>
                        <form action="">
                            <input type="hidden" value="test">
                            <div class="item-add">
                                <a class="add-chart"
                                href="items.php?itemId=<?= $item['itemId']?>"
                                ><i class="fas fa-shopping-cart"></i></a>
                                <div>
                                    <div class="item-add-button">
                                        <button class="add-qty">+</button>
                                        <input type="number" name="item-qty" value="0" min="0" max="12"
                                        class="input-item-qty">
                                        <button class="decrease-qty">-</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>   
                
             <?php 
            
        } ?>
    </div>
</div>
</div>

<?php
// end show all items
 
get_main_webisite_footer();