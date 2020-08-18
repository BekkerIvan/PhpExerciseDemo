function userLogin() {
    if (checkConnection()) {
            if (checkInputs($("#txtUsername").val(),$("#txtPassword").val())) {
                $.post("PhpExercise.php", {
                    UsernameStr : $("#txtUsername").val(),
                    PasswordStr : $("#txtPassword").val(),
                    FunctionToExecuteStr : "Login"
                }, function(data) {
                    data = JSON.parse(data);
                    if(data["LoginSuccessful"]) {
                        window.location.href = data["PageRedirect"];
                    } else {
                        alert("Username not found or password mismatch.");
                        
                    }
                })
            } else {
                alert("Connection Error.");
            }
    }

}


function pageLoadUserInfo() {
    if (checkConnection()) {
        let UserIDInt = document.cookie.split(";")[0].split("=")[1];
        $.post("PhpExercise.php",{
            UserIDInt : UserIDInt,
            FunctionToExecuteStr : "GetUserData"
        },function(data) {
            data = JSON.parse(data);
            $("#txtFirstName").val(data["FirstName"]);
            $("#txtLastName").val(data["LastName"]);
            $("#txtEmailAddress").val(data["EmailAddress"]);
            $("#txtUsername").val(data["Username"]);
        })
    }

}


function GetUsername() {

    if (checkConnection()) {
        if (checkCookies()) {
            $CookieData = document.cookie.split(";");
            $("#UserInfoSettings").html($CookieData[1].split("=")[1]);
        } else {
            alert("User is not logged in.");
            $.post("PhpExercise.php",{
                PageRedirectLocation : "Login"
            },function(data) {
                window.location.href = "PhpExercise.html";
            });
        }

    }
}


function getAllPosts() {
    if (checkConnection()) {
        $.post("PhpExercise.php",{
            FunctionToExecuteStr : "GetPostsAll"
        }, function(data) {
            data = JSON.parse(data);
            if (data["UserID"].length > 1) {
                let DivCounter = 0;
                data["UserID"].forEach(userID => {
                    let divPosts = document.createElement("div");
                    let divUsernameAndDatePosted = document.createElement("div");
                    let PostTimeStamp = data["PostTimeStamp"][DivCounter];
                    divPosts.innerHTML = data["PostText"][DivCounter];
                    $.post("PhpExercise.php",{
                        UserIDInt : userID,
                        FunctionToExecuteStr : "GetUsername"
                    },function(data) {
                        data = JSON.parse(data);
                        divUsernameAndDatePosted.innerHTML = "Date Posted :" + PostTimeStamp + "<br>" + "User :" + data["Username"];
                    });
                    divPosts.id = "divPost" + DivCounter;
                    divPosts.className = "divPosts";
                    divUsernameAndDatePosted.className ="aTimeStamp";
                    document.getElementById("Posts").appendChild(divPosts);
                    document.getElementById("divPost" + DivCounter).appendChild(divUsernameAndDatePosted);

                    DivCounter++;
                });
            } else {
            }
        }); } else {
        alert("Connection Error.");
    }
}

function searchPost() {
    if (checkConnection()) {
        if (checkInputs($("#txtSearch").val())) {
            $("#Posts").html("");
            let DivCounter = 0;
            $.post("PhpExercise.php",{
                FunctionToExecuteStr : "GetUserID",
                UsernameStr : $("#txtSearch").val(),
            },function(data) {
                data = JSON.parse(data);
                if (data["Status"]) {
                    $.post("PhpExercise.php",{
                        FunctionToExecuteStr : "GetPost" ,
                        UserIDInt : data["UserID"]
                    }, function(data) {
                        data = JSON.parse(data);
                        if(data["Status"]) {
                            if (data["PostText"].length > 0) {
                                data["PostText"].forEach(posts => {
                                    let divPosts = document.createElement("div");
                                    let divUsernameAndDatePosted = document.createElement("div");
                                    let PostTimeStamp = data["PostTimeStamp"][DivCounter];
                                    divPosts.innerHTML = data["PostText"][DivCounter];
                                    divUsernameAndDatePosted.innerHTML = "Date Posted :" + PostTimeStamp + "<br>" + "User :" + $("#txtSearch").val();
                                    divPosts.id = "divPost" + DivCounter;
                                    divPosts.className = "divPosts";
                                    divUsernameAndDatePosted.className ="aTimeStamp";
                                    document.getElementById("Posts").appendChild(divPosts);
                                    document.getElementById("divPost" + DivCounter).appendChild(divUsernameAndDatePosted);
                                    DivCounter++;
                            });} else {
                                alert($("#txtSearch").val() + " has not posted anything as of yet.");
                        }} else {
                                alert(data["Message"]);
                        }});} else {
                                alert(data["Message"]);
            }});} else {
                location.reload();
    }} else {
        alert("Connection Error.");
    }
}


function openPostWindow() {
    if (checkConnection()) {
        $("#PostWindow").css({"display" : "block"});
    } else {
        alert("Connection Error.");
    }
}

function updateUserInfo() {
    if (checkConnection()) {
        if ($("#txtPassword").val() == $("#txtRePassword").val()) {
            if (checkValidEmail($("#txtEmailAddress").val())) {
                if (checkInputs(
                    $("#txtFirstName").val(),  
                    $("#txtLastName").val(), 
                    $("#txtEmailAddress").val(),
                    $("#txtUsername").val(),
                    $("#txtPassword").val(),
                    $("#txtRePassword").val())) {
                        $.post("PhpExercise.php",{
                            UserFirstNameStr : $("#txtFirstName").val(),
                            UserLastNameStr : $("#txtLastName").val(),
                            UserEmailAddressStr : $("#txtEmailAddress").val(),
                            UsernameStr : $("#txtUsername").val(),
                            PasswordStr :  $("#txtPassword").val(),
                            UserIDInt : document.cookie.split(";")[0].split("=")[1],
                            FunctionToExecuteStr : "UpdateUser"  
                        },function(data) {        
                            alert(data);
                            data = JSON.parse(data);
                            if (data["PasswordMatch"]) {
                                alert(data["Status"]);
                                window.location.href = data["PageRedirect"];
                            } else {
                                alert(data["Status"]);
                                $("#txtPassword").val("");
                                $("#txtRePassword").val("");
                            }});
                } else {
                    alert("Field(s) cannot be empty.");
                }
            } else {
                $("#txtEmailAddress").css("color","red");
                alert("Invalid email entered.");
            }
        } else {
            alert("Passwords entered does not match.");
            $("#txtPassword").val("");
            $("#txtRePassword").val("");
        }
    } else {
        alert("Connection Error.");
    }
}


function addNewPost() {
    if(checkConnection()) {
        let CheckInputsBool = checkInputs($("#txtUserPost").val());
        let PostLengthInt = $("#txtUserPost").val().length
        if (CheckInputsBool && PostLengthInt < 255) {
            $.post("PhpExercise.php",{
                UserPostStr : $("#txtUserPost").val(),
                UserIDInt : $CookieData[0].split("=")[1],
                FunctionToExecuteStr : "AddNewPost"
            },function(data) {
                data = JSON.parse(data);
                if(data["PageRefresh"]) {
                    alert(data["SuccessStr"]);
                    location.reload();
                }
            });
        } if (!CheckInputsBool) {
            $("#txtUserPost").attr("placeholder","You need to write something to post.");
        } if (PostLengthInt > 255) {
            $("#lblErrorLable").html("You are wanting to say to much, please scale down");
        }
    } else {
        alert("Connection Error.");
    }
}


function clearErrorLabel() {
    $("#lblErrorLable").html("");
}



function closePostWindow() {
    window.onclick = function(event) {
        if (event.target == document.getElementById("PostWindow")) {
            $("#PostWindow").css({"display" : "none"});
        }
    }
}



function cancelOpp() {
    $.post("PhpExercise.php",{
        PageRedirectLocation : "HomePage"
    },function(data) {
        window.location.href = JSON.parse(data);
    });
}


function userLogout() {
    if (checkConnection()) {
        $.post("PhpExercise.php", {
        FunctionToExecuteStr : "Logout"
        },
        function(data) {
            data = JSON.parse(data);
            window.location.href = data["PageRedirect"];
        });
    } else {
        alert("Connection Error.");
    }

}




/*  VALIDATION FUNCTIONS    */

function checkConnection() {
    let CheckConnection = window.navigator.onLine;
    if (CheckConnection) {
        return true;
    } else {
        return false;
    }
}

function checkInputs() {
    let returnBool = true;
    for (let index = 0; index < arguments.length; index++) {
        if (arguments[index] == "") {
            returnBool = false;
        }
    }
    return returnBool;
}

function checkValidEmail(PersonEmailStr) {
    if (PersonEmailStr != "") {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(PersonEmailStr)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkCookies() {
    if (document.cookie.length != 0) {
        return true;
    } else {
        return false;
    }
}
