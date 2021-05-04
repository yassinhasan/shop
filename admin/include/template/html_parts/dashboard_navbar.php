<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/pharmacy/index.php">PH-27</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= set_active_class('add','newmembers');?>"
          href="members.php?action=newmembers" id="navbarDropdownadd"
          role="button" data-bs-toggle="dropdown" aria-expanded="false"
          ><?= lang("members") ?></a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownadd">
          <li><a class="dropdown-item" href="members.php?action=newmembers">all members</a></li>
            <li><a class="dropdown-item" href="members.php?action=add">add new member</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= set_active_class('cat_add','newcategories');?>"  
          href="category.php?action=newcategories" id="navbarDropdownadd"
          role="button" data-bs-toggle="dropdown" aria-expanded="false"
          ><?= lang("category") ?></a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownadd">
          <li><a class="dropdown-item" href="category.php?action=newcategories">all category</a></li>
            <li><a class="dropdown-item" href="category.php?action=cat_add">add new category</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= set_active_class('items_add','newitems');?>"  
          href="items.php?action=newitems" id="navbarDropdownadd"
          role="button" data-bs-toggle="dropdown" aria-expanded="false"
          ><?= lang("items") ?></a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownadd">
          <li><a class="dropdown-item" href="items.php?action=newitems">all items</a></li>
            <li><a class="dropdown-item" href="items.php?action=items_add">add new items</a></li>
          </ul>
        </li>



        <li class="nav-item">
          <a class="nav-link <?= set_active_class('comments','allcomments');?>"  href="comments.php?action=allcomments"><?= lang("comments") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= set_active_class('dashboard');?>"
           href="/admin/dashboard.php"><?= lang("dashboard") ?></a>
        </li>
      </ul>
      
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-right custom-nav">
           <li class="menu-list">
              <a href="../../../../config/changelang/lang.php"  class="lang-href"><?= lang("lang") ?></a>
          </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= set_active_class('edit','settings');?>"
          href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?= $_SESSION['Admin']['UserName']?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?action=edit&UserId=<?= $_SESSION['Admin']['UserId']?>">edit profile</a></li>
            <li><a class="dropdown-item" href="/settings"> settins</a></li>
            <li><a class="dropdown-item" href="/index.php" target="_blank"> visit shop</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/admin/include/template/logout.php">log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>