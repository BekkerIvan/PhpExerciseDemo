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










<?php /*
    // foreach ($_POST as $key => $value) {
    //     switch ($key) {
    //         case 'UserNameStr':
    //             $UsernameStr = $value;
    //             break;
    //         case 'UserHashPasswordStr':
    //             $UserHashPasswordStr = $value;
    //             break;
    //         case 'FunctionToExecute':
    //             $FunctionToExecute = $value;
    //             break;
    //         case 'UserID':
    //             $UserID = $value;
    //             break;
    //         case 'UserEmailAddress':
    //             $UserEmailAddress = $value;
    //             break;
    //         case 'UserFirstName':
    //             $UserFirstName = $value;
    //             break; 
    //         case 'UserLastName':
    //             $UserLastName = $value;
    //             break;       
    //         default:
    //             # code...
    //             break;
    //     }
    // }


    $UsernameStr = $_POST["UserNameStr"];
    $UserHashPasswordStr = $_POST["UserHashPasswordStr"];
    $FunctionToExecute = $_POST["FunctionToExecute"];
    $UserID = $_POST["UserID"];

    
    switch ($FunctionToExecute) {
        case "Login":
            $PhpExercise = new PhpExercise($UsernameStr,$UserHashPasswordStr,$UserID);
            // $PhpExercise = new PhpExercise();
            // $PhpExercise->setUsername($UsernameStr);
            // $PhpExercise->setPassword($UserHashPasswordStr)
            $PhpExercise->userLogin();
            break;
        case "GetUserame":
            $PhpExercise = new PhpExercise($UsernameStr,$UserHashPasswordStr,$UserID);
            $PhpExercise->getUsername();
        break;
        case "GetData":
            $PhpExercise = new PhpExercise($UsernameStr,$UserHashPasswordStr,$UserID);
            $PhpExercise->getuserData();
        break;
        case "Logout":
            $PhpExercise = new PhpExercise($UsernameStr,$UserHashPasswordStr,$UserID);
            $PhpExercise->userLogout();
            break;
        case "Update":
            $UserEmailAddress = $_POST["UserEmailAddress"];
            $UserFirstName = $_POST["UserFirstName"];
            $UserLastName = $_POST["UserLastName"];

            $PhpExercise = new PhpExercise( 
                        $UserID, 
                        $UserFirstName,
                        $UserLastName,
                        $UserEmailAddress,
                        $UsernameStr,
                        $UserHashPasswordStr);

            $PhpExercise->updateInfo();
            break;
        case "GetID":
            $PhpExercise = new PhpExercise($UsernameStr,$UserHashPasswordStr,$UserID);
            $PhpExercise->getUserID();
            break;
        default:
            break;
    }

    


    class PhpExercise {
        // public $UserID = "";
        // public $UserFirstName = "";
        // public $UserLastName = "";
        // public $UserEmailAddress = "";
        // public $UsernameStr ="";
        // public $UserHashPasswordStr = "";
        // public $conn;
        // public $SQLCommandStr = "";

        public function __construct() {
            $a = func_get_args();
            $i = func_num_args();
            if (method_exists($this, $f='__construct'. $i)) {
                call_user_func_array(array($this, $f), $a);
            }
        }

        // public function setUsername($Username) {
        //     $this->Username = $Username;
        // }
        // public function getUsername() {
        //     return $this->Username;
        // }
        // public function setPassword($Password) {
        //     $this->Password = $Password;
        // }
        // public function getPassword() {
        //     return $this->Password;
        // }

        public function __construct3($UsernameStr, $UserHashPasswordStr, $UserID) {
            $this->UsernameStr = $UsernameStr;
            $this->UserHashPasswordStr = $UserHashPasswordStr;
            $this->UserID = $UserID;
        }
        public function __construct6(
                $UserID, 
                $UserFirstName,
                $UserLastName,
                $UserEmailAddress,
                $UsernameStr,
                $UserHashPasswordStr) {

            $this->UserID = $UserID;
            $this->FirstName = $UserFirstName;
            $this->LastName = $UserLastName;
            $this->EmailAddress = $UserEmailAddress;
            $this->UsernameStr = $UsernameStr;
            $this->UserHashPasswordStr = $UserHashPasswordStr;
        }


        public function getUserID() {
            $data = array();
            if ($this->openDatabaseConnection()) {
                $data["Connection"] = true;
                $this->SQLCommandStr = "SELECT ID FROM users WHERE Username = '" . $this->UsernameStr . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if($QueryResult->num_rows == 1) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $data["UserID"] = $SelectedRow["ID"];
                    }
                }
                echo json_encode($data);
            } 
        }




        public function updateInfo() {
            $data = array();
            if ($this->openDatabaseConnection()) {
                $data["Connection"] = true;
                $this->SQLCommandStr = "SELECT * FROM users WHERE ID = '" . $this->UserID . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows == 1) {
                    $data["FoundRow"] = true;
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        if (md5($SelectedRow["Password"]) == md5($this->UserHashPasswordStr)) {
                            $data["PasswordMatch"] = true;

                            $this->SQLCommandStr = "UPDATE users SET " . 
                            "FirstName = '" . $this->FirstName . "', " . 
                            "LastName = '" . $this->LastName . "', " .
                            "EmailAddress = '" . $this->EmailAddress . "', " .
                            "Username = '" . $this->UsernameStr . 
                            "' WHERE ID = '" . $this->UserID . "' AND " .
                            "Password = '" . $this->UserHashPasswordStr . "'"; 

                            $this->conn->query($this->SQLCommandStr);
                            $data["FirstName"] = $this->FirstName;
                            setcookie("UserFirstName", $this->FirstName);
                        } else {
                            $data["PasswordMatch"] = false;
                        }
                    }
                } else {
                    $data["FoundRow"] = false;
                }
                $this->closeDatabaseConnection();
            } else {
                $data["Connection"] = false;
            }
            echo json_encode($data);
        }


   

        public function userLogin() {
            $UserInfoArr = array();
            $UserPasswordFetch = "";
            if ($this->openDatabaseConnection()) {
                $this->SQLCommandStr = "SELECT ID, FirstName, LastName, Password FROM users WHERE Username = '" . $this->UsernameStr . "' OR EmailAddress = '" . $this->UsernameStr . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows > 0) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $UserPasswordFetch = $SelectedRow["Password"];
                        setcookie("UserID", $SelectedRow["ID"]);
                        setcookie("UserFirstName", $SelectedRow["FirstName"]);
                        //setcookie("UserLastName",$SelectedRow["LastName"]);
                    }
                    if (md5($UserPasswordFetch) == $this->UserHashPasswordStr) {
                        $UserInfoArr["LoginSuccessful"] = true;
                        $UserInfoArr["PageRedirect"] = "PhpExerciseHomePage.html";
                    } else {
                        $UserInfoArr["LoginSuccessful"] = false;
                        $UserInfoArr["ConnectionStatus"] = "Username / Email and Password mismatch.";
                    }
                    $this->closeDatabaseConnection();
                } else {
                    $UserInfoArr["LoginSuccessful"] = false;
                    $UserInfoArr["ConnectionStatus"] = "No data was found.";
                }
            } else {
                $UserInfoArr["LoginSuccessful"] = false;
                $UserInfoArr["ConnectionStatus"] = "Connection to database failed.";
            }
            echo json_encode($UserInfoArr);
        }



        public function userLogout() {
            //$UserInfoArr = array();
            $UserInfoArr["PageRedirect"] = "PhpExercise.html";
            setcookie("UserID", "", time() - 3600);
            setcookie("UserFirstName", "", time() - 3600);
            setcookie("UserLastName","",time() - 3600);
            echo json_encode($UserInfoArr);
        }


        public function getUsername() {
            if ($this->openDatabaseConnection()) {
                $this->SQLCommandStr = "SELECT Username FROM users WHERE ID = '" . $this->UserID . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows > 0 && $QueryResult->num_rows < 2) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        echo($SelectedRow["Username"]);
                    }
                }
                $this->closeDatabaseConnection();
            }
        }

        public function getuserData() {
            try {
                if($this->openDatabaseConnection()) {
                    $this->SQLCommandStr = "SELECT * FROM users WHERE ID = '" . $this->UserID . "'";
                    $QueryResult = $this->conn->query($this->SQLCommandStr);
                    if ($QueryResult->num_rows > 0 && $QueryResult->num_rows < 2) {
                        while ($SelectedRow = $QueryResult->fetch_assoc()) {
                            $UserInfoArr["FirstName"] = $SelectedRow["FirstName"];
                            $UserInfoArr["LastName"] = $SelectedRow["LastName"];
                            $UserInfoArr["EmailAddress"] = $SelectedRow["EmailAddress"];
                            $UserInfoArr["Username"] = $SelectedRow["Username"];    
                            $UserInfoArr["Password"] = $SelectedRow["Password"];
                        }
                    }
                    $this->closeDatabaseConnection();
                    echo json_encode($UserInfoArr);
                }
            } catch (\Throwable $errorMsg) {
                echo($errorMsg);
            }
        }

        public function openDatabaseConnection() {
            try {
                $ServerName = "localhost";
                $ServerUserName = "root";
                $this->conn = new mysqli($ServerName, $ServerUserName,"", "phpexercise");
                if($this->conn->connect_error) {
                    return false;
                }
                return true;
            } catch (\Throwable $errorMsg) {
                return false;
            }
        }


        public function closeDatabaseConnection() {
            try {
                if ($this->conn->connect_errno) { 
                    die("Connection failed: " . $this->conn->connect_errno);
                } 
                $this->conn->close();
            } catch (\Throwable $th) {
                echo($th);
            }
        }
    }*/
?> 