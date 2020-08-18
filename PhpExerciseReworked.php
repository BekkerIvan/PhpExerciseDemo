<?php


class PhpExerciseReworked {

    //Set functions
    public function setUserID($UserIDInt) {
        $this->UserIDInt = $UserIDInt;
    }
    public function setFirstName($FirstNameStr) {
        $this->FirstNameStr = $FirstNameStr;
    }
    public function setLastName($LastNameStr) {
        $this->LastNameStr = $LastNameStr;
    }
    public function setEmailAddress($EmailAddressStr) {
        $this->EmailAddressStr = $EmailAddressStr;
    }
    public function setUsername($UsernameStr) {
        $this->UsernameStr = $UsernameStr;
    }
    public function setPassword($PasswordStr) {
        $this->PasswordStr = $PasswordStr;
    }
    public function setUserPost($UserPost) {
        $this->UserPost = $UserPost;
    }
    public function setDatePosted() {
        $this->DatePosted = date("Y-m-d");
    }

    //Get functions
    public function getUserID() {
        return $this->UserIDInt;
    }
    public function getFirstName() {
        return $this->FirstNameStr;
    }
    public function getLastName() {
        return $this->LastNameStr;
    }
    public function getEmailAddress() {
        return $this->EmailAddressStr;
    }
    public function getUsername() {
        return $this->UsernameStr;
    }
    public function getPassword() {
        return $this->PasswordStr;
    }
    public function getUserPost() {
        return $this->UserPost;
    }
    public function getDatePosted() {
        return $this->DatePosted;
    }

    

    public function userLogin() {
        $ReturnArr = array();
        $UserPasswordFetch = "";
        if ($this->openDatabaseConnection()) {
            $this->SQLCommandStr = "SELECT ID, Username, Password FROM users WHERE Username = '" . $this->getUsername() . "' OR EmailAddress = '" . $this->getUsername() . "'";
            $QueryResult = $this->conn->query($this->SQLCommandStr);
            if ($QueryResult->num_rows == 1) {
                while ($SelectedRow = $QueryResult->fetch_assoc()) {
                    $UserPasswordFetch = $SelectedRow["Password"];
                    setcookie("UserID", $SelectedRow["ID"]);
                    setcookie("Username", $SelectedRow["Username"]);
                } if (md5($UserPasswordFetch) == md5($this->getPassword())) {
                    $ReturnArr["LoginSuccessful"] = true;
                    $ReturnArr["PageRedirect"] = "PhpExerciseHomePageReworked.html";
                } else {
                    $ReturnArr["LoginSuccessful"] = false;
                    $ReturnArr["ConnectionStatus"] = "Username / Email and Password mismatch.";
                }
                $this->closeDatabaseConnection();
            } else {
                $ReturnArr["LoginSuccessful"] = false;
                $ReturnArr["ConnectionStatus"] = "No data was found.";
            }
        } else {
            $ReturnArr["LoginSuccessful"] = false;
            $ReturnArr["ConnectionStatus"] = "Connection to database failed.";
        }
        echo json_encode($ReturnArr);
    }

    public function addPost() {
        if ($this->openDatabaseConnection()) {
            try {
                $this->SQLCommandStr = "INSERT INTO posts (UserID, PostTimeStamp, PostText) VALUES ('" . $this->getUserID() . "', '" . $this->getDatePosted() . "' , '" . $this->getUserPost() . "')";
                $this->conn->query($this->SQLCommandStr);
                $ReturnArr["SuccessStr"] = "Your post is now live.";
                $ReturnArr["PageRefresh"] = true;
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }

    public function Username() {
        if ($this->openDatabaseConnection()) {
            try {
                $this->SQLCommandStr = "SELECT Username FROM users WHERE ID = '" . $this->getUserID() . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows > 0) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $ReturnArr["Username"][] = ($SelectedRow["Username"]);
                    }
                }
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch (\Throwable $th) {
            }
        }
    }

    public function getUserIDPost() {
        if ($this->openDatabaseConnection()) {
            try {
                $this->SQLCommandStr = "SELECT ID FROM users WHERE Username = '" . $this->getUsername() . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows == 1) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $ReturnArr["UserID"] = $SelectedRow["ID"];
                        $ReturnArr["Status"] = true;
                    }
                } else {
                    $ReturnArr["Status"] = false;
                    $ReturnArr["Message"]= "No data was found with username " . $this->getUsername();
                }
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch (\Throwable $th) {
            }
        }
    }

    public function getUserInfo() {
        if ($this->openDatabaseConnection()) {
            try {
                $this->SQLCommandStr = "SELECT * FROM users WHERE ID = '" . $this->getUserID() . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows == 1) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $ReturnArr["FirstName"] = ($SelectedRow["FirstName"]);
                        $ReturnArr["LastName"] = ($SelectedRow["LastName"]);
                        $ReturnArr["EmailAddress"] = ($SelectedRow["EmailAddress"]);
                        $ReturnArr["Username"] = ($SelectedRow["Username"]);
                    }
                }
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch(\Throwable $th) {
            } 
        }
    }

    public function updateUserInfo() {
        if ($this->openDatabaseConnection()) {
            try {
                $ChangesBool = false;
                $ReturnArr["PasswordMatch"] = false;
                $this->SQLCommandStr = "SELECT * FROM users WHERE ID = '" . $this->getUserID() . "'";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows == 1) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        if (md5($SelectedRow["Password"]) == md5($this->getPassword())) {  
                            $ReturnArr["PasswordMatch"] = true;
                            $this->SQLCommandStr = "UPDATE users SET ";
                            if ($SelectedRow["FirstName"] != $this->getFirstName()) {
                                $this->SQLCommandStr .= " FirstName = '" . $this->getFirstName() . "',";
                                $ChangesBool = true;
                            }
                            if ($SelectedRow["LastName"] != $this->getLastName()) {
                                $this->SQLCommandStr .= " LastName = '" . $this->getLastName() . "',";
                                $ChangesBool = true;
                            }
                            if ($SelectedRow["EmailAddress"] != $this->getEmailAddress()) {
                                $this->SQLCommandStr .= " EmailAddress = '" . $this->getEmailAddress() . "',";
                                $ChangesBool = true;
                            }
                            if ($SelectedRow["Username"] != $this->getUsername()) {
                                $this->SQLCommandStr .= " Username = '" . $this->getUsername() . "',";
                                setcookie("Username", $this->getUsername());
                                $ChangesBool = true;
                            }
                            $this->SQLCommandStr = rtrim($this->SQLCommandStr,",");

                            if ($ChangesBool) {
                                $this->SQLCommandStr .= " WHERE ID = '" . $this->getUserID() . "'";
                                $ReturnArr["SQLStr"] = $this->SQLCommandStr;
                                $this->conn->query($this->SQLCommandStr);
                                $ReturnArr["Status"] = "User info has been updated.";
                                $ReturnArr["PageRedirect"] = "PhpExerciseHomePageReworked.html";
                            } else {
                                $ReturnArr["Status"] = "No data was changed.";
                                $ReturnArr["PageRedirect"] = "PhpExerciseHomePageReworked.html";
                            }
                        } else {
                            $ReturnArr["Status"] = "Password mismatch.";
                        }
                    }
                } else {
                    $ReturnArr["Status"] = "Unforseen error loading table.";
                }
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch (\Throwable $th) {
            }
        }
    }

    public function logout() {
        $ReturnArr["PageRedirect"] = "PhpExercise.html";
        setcookie("UserID", "", time() - 3600);
        setcookie("Username", "", time() - 3600);
        echo json_encode($ReturnArr);
    }

        /* Open and close database functions  */
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
        } catch (\Throwable $errorMsg) {
            echo($errorMsg);
        }
    }
}
?>