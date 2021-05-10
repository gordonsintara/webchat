<?php
    session_start();
    require_once "php/main.php";
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
        <link rel="stylesheet" href="main.css">
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
 

                    <?php  if(isset($_GET['logout'])){ 
                        
                        //Simple exit message
                        $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
                        file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
                        
                        session_destroy();
                        header("Location: index.php"); 
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
                <div id = "menu">
                <p class = "logout"><a id = "exit" href="#">Leave</a></p>
        </div>



        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="" async defer></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                function loadLog(){     
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
                        $.ajax({
                          url: "log.html",
                          cache: false,
                          success: function(html){        
                           $("#chatbox").html(html); //Insert chat log into the #chatbox div   
             
                                //Auto-scroll           
                                var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                                if(newscrollHeight > oldscrollHeight){
                                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }               
        },
    });
}
                //user ends session
                $("#exit").click(function(){
                    var exit = confirm("are you sure you want to  leave ");
                    if(exit==true){window.location = 'index.php?logout=true';}
                });

                //If user submits the form
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });


setInterval (loadLog, 2500);
            });
        </script>

        </body>



</html>

<?php
        }
?>