<?php
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
require_once dirname(realpath(__FILE__)) . DS. "ini.php";

$CategoryId = isset($_GET['CategoryId']) && is_numeric($_GET['CategoryId']) ? $_GET['CategoryId'] : 0; 
$CategoryName =  isset($_GET['CategoryName']) ? $_GET['CategoryName'] :" 0";

$title = $CategoryName;


//header
get_main_webisite_header();
//navbar
get_main_webisite_navbar();
//content
?>
    <p class="text-center display-1 category-heading"><?= $CategoryName ?></p>
    <div class="items">
        <div class="container">
            <div class="item-box">
                <?php
                if(empty(get_items($CategoryId)))
                    {
                        echo "<p class='alert alert-warning'>soory no items herer</p>";
                    }
                    else
                    {
                    foreach(get_items($CategoryId) as $items)
                    { ?>
                            <div class="item-content">
                                <img src="//cdn-aldawaa.com/media/catalog/product/cache/4af02630f79858b92879ba1184cb0894/1/0/101975_2.jpg" alt="test">
                                <span class="love-item"><i class="fas fa-heart rate-by-heart"></i></span>
                                <div class="item-info">
                                    <p><?= $items['itemName']?></p>
                                    <span><?= $items['itemPrice']?> SR</span>
                                    <div class="item-rating"> 
                                        <?php
                                    for($x= 0 ; $x <  $items['itemRating'] ; $x++)
                                    { 
                                        echo "<span><i class='fas fa-star start-chekced'></i></span>";
                                        }

                                        for($x= 0 ; $x < 5 - $items['itemRating'] ; $x++)
                                        { 
                                            echo "<span><i class='fas fa-star'></i></span>";
                                         }
                                        ?>
                                    </div>
                                </div>
                                <form action="">
                                    <input type="hidden" value="test">
                                    <div class="item-add">
                                        <button class="add-chart"><i class="fas fa-shopping-cart"></i></button>
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
                    }
                } ?>
            </div>
        </div>
    </div>

 <?php //footer
get_main_webisite_footer();




