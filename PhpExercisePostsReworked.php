<?php
include "PhpExerciseReworked.php";
class PhpExercisePostsReworked extends PhpExerciseReworked  {

    public function getAllPosts()
    {
       if ($this->openDatabaseConnection()) {
           try {
            $this->SQLCommandStr = "SELECT UserID, PostTimeStamp, PostText FROM posts ORDER BY PostTimeStamp DESC";
            $QueryResult = $this->conn->query($this->SQLCommandStr);
            if ($QueryResult->num_rows > 0) {
                while ($SelectedRow = $QueryResult->fetch_assoc()) {
                    $ReturnArr["UserID"][] = $SelectedRow["UserID"];
                    $ReturnArr["PostTimeStamp"][] = $SelectedRow["PostTimeStamp"];
                    $ReturnArr["PostText"][] = $SelectedRow["PostText"];
                }
            } else {
                $ReturnArr["Status"] = "No posts was found.";
            }
            $this->closeDatabaseConnection();
            echo json_encode($ReturnArr);
           } catch (\Throwable $th) {
               //throw $th;
           }
       }
    }

    public function getPost() {
        if ($this->openDatabaseConnection()) {
            try {
                $this->SQLCommandStr = "SELECT PostTimeStamp, PostText FROM posts WHERE UserID = '". $this->getUserID() ."' ORDER BY PostTimeStamp DESC";
                $QueryResult = $this->conn->query($this->SQLCommandStr);
                if ($QueryResult->num_rows > 0) {
                    while ($SelectedRow = $QueryResult->fetch_assoc()) {
                        $ReturnArr["PostTimeStamp"][] = $SelectedRow["PostTimeStamp"];
                        $ReturnArr["PostText"][] = $SelectedRow["PostText"];
                        $ReturnArr["Status"] = true;
                    }
                } else {
                    $ReturnArr["Status"] = false;
                    $ReturnArr["Message"] = "User has not posted anything yet.";
                }
                $this->closeDatabaseConnection();
                echo json_encode($ReturnArr);
            } catch (\Throwable $th) {
            }
            
        }
    }

}?>