<?php

    include "PhpExercisePostsReworked.php";

    foreach ($_POST as $key => $value) {
        switch ($key) {
            case 'UsernameStr':
                $UsernameStr = $value;
                break;
            case 'PasswordStr':
                $PasswordStr = $value;
                break;
            case 'FunctionToExecuteStr':
                $FunctionToExecuteStr = $value;
                break;
            case 'UserIDInt':
                $UserIDInt = $value;
                break;
            case 'UserEmailAddressStr':
                $EmailAddressStr = $value;
                break;
            case 'UserFirstNameStr':
                $FirstNameStr = $value;
                break;
            case 'UserLastNameStr':
                $LastNameStr = $value;
                break;
            case 'UserPostStr':
                $UserPostStr = $value;
                break;
            default:
                $PageRedirectLocation = $value;
                $FunctionToExecuteStr = "";
                break;
        }
    }

    $PhpExercise = new PhpExercisePostsReworked();

    switch ($FunctionToExecuteStr) {
        case 'Login':
            $PhpExercise->setUsername($UsernameStr);
            $PhpExercise->setPassword($PasswordStr);
            $PhpExercise->userLogin();
            break;
        case 'GetUsername':
            $PhpExercise->setUserID($UserIDInt);
            $PhpExercise->Username();
            break;
        case 'GetUserData':
            $PhpExercise->setUserID($UserIDInt);
            $PhpExercise->getUserInfo();
            break;
        case 'Logout':
            $PhpExercise->logout();
            break;  
        case 'UpdateUser':
            $PhpExercise->setUsername($UsernameStr);
            $PhpExercise->setPassword($PasswordStr);
            $PhpExercise->setUserID($UserIDInt);
            $PhpExercise->setFirstName($FirstNameStr);
            $PhpExercise->setLastName($LastNameStr);
            $PhpExercise->setEmailAddress($EmailAddressStr);
            $PhpExercise->updateUserInfo();
            break;
        case 'AddNewPost':
            $PhpExercise->setUserPost($UserPostStr);
            $PhpExercise->setUserID($UserIDInt);
            $PhpExercise->setDatePosted();
            $PhpExercise->addPost();
            break;
        case 'GetPostsAll':
            $PhpExercise->getAllPosts();
            break;
        case 'GetUserID':
            $PhpExercise->setUsername($UsernameStr);
            $PhpExercise->getUserIDPost();
            break; 
        case 'GetPost':
            $PhpExercise->setUserID($UserIDInt);
            $PhpExercise->getPost();
            break;       
        default:
            pageRedirectLocation($PageRedirectLocation);
            break;
    }


    function pageRedirectLocation($PageRedirectLocation) {
        switch ($PageRedirectLocation) {
            case 'HomePage':
                $PageRedirectLocation = "PhpExerciseHomePageReworked.html";
                break;
            case 'Login' :
                $PageRedirectLocation = "PhpExercise.html";
                break;
            case 'Update':
                $PageRedirectLocation = "PhpExerciseUserUpdatePage.html";
                break;
            default:
                # code...
                break;
        }
        echo json_encode($PageRedirectLocation);
    }
?>