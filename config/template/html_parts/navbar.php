<header>
    <div class="container">
        <div class="nav-row">
            <!-- will dissapper at mob size -->
            <div class="logo">
                <a href="/pharmacy/index.php">
                    PH-27
                </a>
            </div>
            <!-- will dissapper at mob size -->
            <div class="nav">
                <ul class="nav-menu">
                    <?php
                        if(isset($_SESSION['Admin']) || isset($_SESSION['User']))
                        { ?>
                            <li class="menu-list drop-test">
                                <i class="fas fa-cog"></i>
                                <a href="#">manage Item</a>
                                <ul class="sub">
                                    <li> <a href="add-items.php"><i class="fas fa-plus"></i> Add Item</a></li>
                                    <li> <a href="add-items.php"><i class="fas fa-heart"></i> favorite Item</a></li>
                                    <li> <a href="add-items.php">Add Item</a></li>
                                    <li> <a href="add-items.php">Add Item</a></li>
                                </ul>
                            </li>
                                        <?php  
                        }

                    ?>
                    <li class="menu-list">
                        <i class='fas fa-user'></i>
                    <?php 
                        
                        if(! isset($_SESSION['User']) && ! isset($_SESSION['Admin']) )
                        {
                            echo "<a href='login.php'>log in
                            </a>";
                        }
                        elseif(isset($_SESSION['User']) && ! isset($_SESSION['Adminuser']))
                        {
                            echo "<a href='profile.php'>". $_SESSION['User']['UserName']."</a>";
                        }
                        elseif(isset($_SESSION['Admin']) && isset($_SESSION['Adminuser']))
                        {
                            echo "<a href='/admin/dashboard.php'>". $_SESSION['Admin']['UserName']."</a>";
                        }
                           
                        ?>
                    </li>
                    <?php 
                        
                        if(isset($_SESSION['User']) ||  isset($_SESSION['Admin']))
                        {
                            echo "<li class='menu-list'>
                            <i class='fas fa-sign-out-alt'></i>
                                <a href='logout.php'>logout</a>
                            </li>";
                        }
                        ?>
                    <li class="menu-list">
                        <i class="fas fa-globe"></i>
                        <a href="/config/changelang/lang.php"><?= lang("lang") ?></a>
                    </li>
                </ul>
            </div>
            <!-- will show at mob size -->
            <div class="open">
                <div class="open-nav">
                    <span></span>
                </div>
                <a href="/config/changelang/lang.php" class="change-lang"><?= lang("lang") ?></a>
            </div>
            <!-- will show at mob size -->
            <div class="start-logo">
                <img src="https://cdn-aldawaa.com/media/logo/stores/1/logo.svg">
            </div>
            <!-- will show at mob size -->
            <div class="media-nav">
            <i class='fas fa-user'></i>
                    <?php 
                        
                        if(! isset($_SESSION['User']) )
                        {
                            echo "<a href='login.php'>log in
                            </a>";
                        }
                        elseif(isset($_SESSION['User']) && ! isset($_SESSION['Adminuser']))
                        {
                            echo "<a href='profile.php'>". $_SESSION['User']['UserName']."</a>";
                        }
                        else
                        {
                            echo "<a href='/admin/dashboard.php'>". $_SESSION['User']['UserName']."</a>";
                        }
                           
                        ?>
            </div>
        </div>
        <!-- second wrow consist of logo and input search -->
        <div class="logo-row">
            <div class="dawa-logo">
                <img src="https://cdn-aldawaa.com/media/logo/stores/1/logo.svg">
            </div>
            <div class="input-search">
                <input type="search" class="search-input" placeholder="Search for products, categories, ...">
            </div>
        </div>
        <!-- overlay when menu open -->
        <div class="overlay"></div>
        <!-- desktop menu will show ony at desktop and convert to sidebar at mob -->
        <section class="desktop-menu">
            <!--  header of sidebar menu-->
            <div class="desktop-menu-header">
                <strong>Menu</strong>
                <div class="close-menu">
                    <i class="fas fa-times close"></i>
                </div>
            </div>
            <!-- menu of sidebar -->
            <div class="desktop-menu-box">
                <ul class="menu">
                    <?php
                    foreach(get_categories() as $category)
                    {  ?>
                            <li class="menu-item">
                                <i class="fas fa-home"></i>
                                <a
                                    class="<?= set_active_class($category['CategoryName'])?> category-link"
                                    href="/category.php?CategoryId=<?= $category['CategoryId']?>&CategoryName=<?= $category['CategoryName'];?>"> <?= $category['CategoryName'];?>
                                </a>
                            </li>
                         
                         <?php 
                        
                    }
                    ?>
                    <!-- <li class="menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home</a>
                    </li>
                    <li class="menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home</a>
                    </li> -->
                    <!-- menu has submenu -->
                    <!-- <li class="menu-list menu-has-children menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li> <a href="#">nested home</a></li>
                            <li> <a href="#">nested home</a></li>
                            <li> <a href="#">nested home</a></li>
                            <li> <a href="#">nested home</a></li>
                        </ul>
                    </li>
                    <li class="menu-list menu-has-children menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li> test</li>
                            <li> test</li>
                            <li> test</li>
                            <li> test</li>
                        </ul>
                    </li>
                    </li>
                    <li class="menu-list menu-has-children menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home and mom
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li> test</li>
                            <li> test</li>
                            <li> test</li>
                            <li> test</li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home</a>
                    </li>
                                                    <li class="menu-item">
                        <i class="fas fa-home"></i>
                        <a href="#"> home</a>
                    </li> -->
                
                </ul>
            </div>
        </section>
        <div>
</header>