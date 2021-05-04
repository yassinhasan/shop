
<?=  
    
    $message =isset( $_SESSION['message']) ?$_SESSION['message']:"";
    $_SESSION['message'] = "";
?>

<div class="all-members">
<div class="add-member">
<button class="btn btn-success"> <a href="?action=add"> Add New memeber
<i class="fas fa-plus"></i>
</a></button>
</div>
<h3> All members</h3>
<div class="table-responsive">
<table class="table table-bordered text-center table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>
                User ID
            </th>
            <th>
                name
            </th>
            <th>
                full name
            </th>
            <th>
                email
            </th>
            <th>
                registeraion date
            </th>
            <th>
                action
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
            // $sql = "SELECT * FROM users WHERE UserI != ". $_SESSION['UserId']."";
            $where = "";
            if(isset($_GET['UserId']))
            {
                $UserId = $_GET['UserId'];
                $where = " AND UserId = $UserId"; 
            }
            $pening = "";
            $pening = (isset($_GET['approved']) && $_GET['approved'] == 'pending') ? ' AND RegStatus = 0' : "";
            $sql = "SELECT * FROM users WHERE GroupID != 1 $pening $where";
            global $conn;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($users as $user)
            { ?>
                <tr class=" <?= (isset($user['RegStatus']) && $user['RegStatus'] == 0) ? 'pending-members' : 'active-members'?>">
                    <td>
                    <?= $user['UserId'] ?>
                    </td>
                    <td>
                    <?= $user['UserName'] ?>
                    </td>
                    <td>
                    <?= $user['FullName'] ?>
                    </td>
                    <td>
                    <?= $user['Email'] ?>
                    </td>
                    <td>
                    <?= $user['Reg_Date'] ?>
                    </td>
                    <td class="edit-action">
                       <a href="?action=edit&UserId=<?=$user['UserId']?>"
                       onclick=" if (! confirm('are you sure to edit'))  return false"
                       title='edite member'
                       ><i class="fas fa-edit edit-users"></i></a> 
                       <a href="?action=delete&UserId=<?=$user['UserId']?>"
                       title='delete member'
                       onclick=" if (! confirm('are you sure to delete'))  return false"
                       ><i class="fas fa-times delete-users"></i></a> 
                       <?php
                        if ($user['RegStatus'] == 0)
                        { ?>
                            <a href="?action=activate&UserId=<?=$user['UserId']?>"
                            title='activate'
                            onclick=" if (! confirm('are you sure to activate'))  return false"
                            ><i class="fas fa-check active-user"></i></a> 
                       <?php
                       
                        }
                        else
                        {
                       ?>
                       <a href="?action=blocked&UserId=<?=$user['UserId']?>"
                       onclick=" if (! confirm('are you sure to block this member'))  return false"
                       title='block member'
                       ><i class="fas fa-user-lock block-users "></i>
                       </a> 
                       <?php  } ?>
                    </td>
             </tr>
            <?php }
        ?>
    </tbody>
</table>
</div>
</div>
