<?php
require_once dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR."..\ini.php";
           //  form ## UserName
           if(isset($_POST['UserName']))
           {
               header('Content-type: text/plain');//with header Content type 
               global $conn;
               $UserId = isset($_POST['UserId']) ?$_POST['UserId'] : ""; 
               if((isset($_POST['action']) && $_POST['action'] == 'edit'))
               {
                   $sql = "SELECT * FROM users WHERE UserName = :UserName AND UserId != :UserId";
                   $stmt = $conn->prepare($sql);
                   $stmt->bindValue(":UserName",$_POST['UserName'],PDO::PARAM_STR);
                   $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
               }
               else
               {
               $sql = "SELECT UserName FROM users WHERE UserName  = :UserName";       
               $stmt = $conn->prepare($sql);
               $stmt->bindValue(":UserName",$_POST['UserName'],PDO::PARAM_STR);         
               }

               // $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
               if ($stmt->execute())
               {
                  if($stmt->rowCount() > 0)
                  {
                      echo "yes";
                  }
                   else
                   {
                       echo "no";
                   }
   
               }   
           }
        //  form ## password
        elseif(isset($_POST['Password']))
        {
            header('Content-type: text/plain');//with header Content type 
            global $conn;
            $sql = "SELECT * FROM users WHERE Password  = :Password";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":Password",sha1($_POST['Password']),PDO::PARAM_STR);
            // $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
            if ($stmt->execute())
            {
               if($stmt->rowCount() > 0)
               {
                   echo "no";
               }
                else
                {
                    echo "yes";
                }

            }   
        }

         //  form ## Email
        elseif(isset($_POST['Email']))
        {
            header('Content-type: text/plain');//with header Content type 
            global $conn;
            $UserId = isset($_POST['UserId']) ?$_POST['UserId'] : ""; 
            if((isset($_POST['action']) && $_POST['action'] == 'edit'))
            {
                $sql = "SELECT * FROM users WHERE Email = :Email AND UserId != :UserId";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":Email",$_POST['Email'],PDO::PARAM_STR);
                $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT); 
            }
            else
            {
                $sql = "SELECT * FROM users WHERE Email = :Email";            
             $stmt = $conn->prepare($sql);
            $stmt->bindValue(":Email",$_POST['Email'],PDO::PARAM_STR);      
             }

            // $stmt->bindValue(":UserId",$UserId,PDO::PARAM_INT);
            if ($stmt->execute())
            {
               if($stmt->rowCount() > 0)
               {
                   echo "yes";
               }
                else
                {
                    echo "no";
                }

            }   
        }
        elseif(isset($_POST['CategoryName']))
        {
            header('Content-type: text/plain');//with header Content type 
            global $conn;
            $CategoryId = isset($_POST['CategoryId']) ?$_POST['CategoryId'] : ""; 
            if((isset($_POST['action']) && $_POST['action'] == 'cat_edit'))
            {
                $sql = "SELECT * FROM category WHERE CategoryName = :CategoryName AND CategoryId != :CategoryId";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":CategoryName",$_POST['CategoryName'],PDO::PARAM_STR);
                $stmt->bindValue(":CategoryId",$CategoryId,PDO::PARAM_INT); 
            }
            else
            {
                $sql = "SELECT * FROM category WHERE CategoryName = :CategoryName";            
             $stmt = $conn->prepare($sql);
            $stmt->bindValue(":CategoryName",$_POST['CategoryName'],PDO::PARAM_STR);      
             }
            // $stmt->bindValue(":CategoryId",$UserId,PDO::PARAM_INT);
            if ($stmt->execute())
            {
               if($stmt->rowCount() > 0)
               {
                   echo "yes";
               }
                else
                {
                    echo "no";
                }

            }   
        }