<?php
    //when you login, you want to store all necessary variables and information about the user in a variable
    // to do that, you can store all those informations inside a SESSION variable

    //when register success, you want to set the session variable
    //when it finally redirect, you HAVE to unset or destroy the session variable

    session_start();

    // Flash message helper
    // Example : flash('register_success','You are now registered')
    // OR
    // you can create custom class : flash('register_fail','Something went wrong','alert alert-danger')
    //display in the view : <?php echo flash('register_success') ; 
    function flash($name='',$message='',$class='alert alert-success'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                //if there is already a session, then we have to unset it
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }
                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }

                //then we reset it
                $_SESSION[$name] = $message;

                //also store the class into the session variable
                $_SESSION[$name . '_class'] = $class;
            } 
                //handle the flash message display
            else if(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name.'_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash"> '.$_SESSION[$name].' </div>';
                
                //after you display it, then you have to unset the session variable
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }
    
    function isLoggedIn(){
        if(isset($_SESSION['currentUser'])){
            return true;
        } else {
            return false;
        }
    }

    function getCurrentid(){
        return $_SESSION['currentUser']->id;
    }
?>

    