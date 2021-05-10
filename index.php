<?php
    session_start();
     
    if(isset($_POST['enter'])){
        if($_POST['name'] != ""){
            $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        }
        else{
            echo '<span class="error">Please type in a name</span>';
        }
    }

    function loginForm(){
        echo'
        <div id="loginform">
          <p>Please enter your name to continue!</p>
          <form action="index.php" method="post">
            <label for="name">Name &mdash;</label>
            <input type="text" name="name" id="name" />
            <input type="submit" name="enter" id="enter" value="Enter" />
          </form>
        </div>
        ';
    }


    ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
<?php
  if(!isset($_SESSION['name'])){
     loginForm();
     }else{
        
?>
        

        <div id = "wrapper">
            <div id = "menu">
                <p class = "welcome"> Welcome <?php echo $_SESSION["name"];?></p>
                <p class = "logout"><a id = "exit" href="#">Leave</a></p>

                    <?php  if(isset($_GET['logout'])){ 
                        
                        //Simple exit message
                        $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
                        file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
                        
                        session_destroy();
                        header("Location: index.php"); //Redirect the user
                    }
                    ?>
            </div>

            <div id = "chatbox"></div>
                <?php
                    if(file_exists("log.html")&& filesize("log.html") > 0 ){
                        $contents = file_get_contents("log.html");
                        echo $contents;
                
                    }
                ?>

                <form name = "Messages" action="">
                <input type = "text" id = "usermsg" name = "usermsg" >
                <input type = "submit" id = "submitmsg" name = "submitmsg" value = "Send">
            
                </form>
        </div>



        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="" async defer></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                //user ends session
                $("#exit").click(function(){
                    var exit = confirm("are you sure you want to  leave ");
                    if(exit==true){window.location = 'index.php?logout=true';}
                });



            });
        </script>

        </body>



</html>

<?php
        }
?>