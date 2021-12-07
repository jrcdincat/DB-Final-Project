<?php
    include('db_connection.php');

    if(!isset($_COOKIE['email']))
    {
        echo "cookie not set";
    }

    $email = $_COOKIE['email'];
    function newForm($conn, $email)
    {
        $semester = $_COOKIE['semester'];

        $sql = "INSERT INTO forms (email, semester) VALUES ('".$email."', '".$semester."')";
        mysqli_query($conn, $sql);

        $sql_form = "SELECT formID FROM forms WHERE formID = (SELECT MAX(formID) FROM forms)";
        $form_result = mysqli_query($conn, $sql_form);
        $form = mysqli_fetch_assoc($form_result);
        $newFormID = $form['formID'];
        mysqli_free_result($form_result);
        
        $cookie_name = 'formID';
        setcookie($cookie_name, $newFormID, time() + 86400, "/"); // 86400 = 1 day
    }

    // Set visibility overwrite form popup
    $is_overwrite_popup_visible= false;

    // Set visibility of create new form popup
    $is_new_popup_visible = false;

    if(isset($_POST['no_overwrite']))
    {
        $is_overwrite_popup_visible = false;
    }
    if(isset($_POST['yes_overwrite']))
    {
        $semester = $_COOKIE['semester'];

        // Get formID
        $sql_get_formID =  "SELECT formID FROM forms where email='".$email."' AND semester='".$semester."'";
        $result = mysqli_query($conn, $sql_get_formID);
        $data = mysqli_fetch_assoc($result);
        $formID = $data['formID'];
        mysqli_free_result($result);

        // Delete all books with formID
        $sql_del_books_in_form = "DELETE FROM books WHERE formID='".$formID."'";
        mysqli_query($conn, $sql_del_books_in_form);

        // Delete formID
        $sql_del_form = "DELETE FROM forms WHERE formID='".$formID."'";
        mysqli_query($conn, $sql_del_form);

        // Make new form
        newForm($conn, $email);

        header('Location: prof_page2.php');
    }        

    // Edit form popup button responses
    if(isset($_POST['yes_new']))
    {
        newForm($conn, $email);
        header('Location: prof_page2.php');
    }     
    if(isset($_POST['no_new']))
    {
        $is_new_popup_visible = false;
    }       

    if(isset($_POST['new_form_submit']))
    {
        $semester = $_POST['semester'];
        $cookie_name='semester';
        setcookie($cookie_name, $semester, time() + 86400, "/"); // 86400 = 1 day

        // Check if form already exists, if so, prompt for deletion
        $sql = "SELECT * FROM forms where email='".$email."' AND semester='".$semester."'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            // Request confirmation to overwrite form
            $is_overwrite_popup_visible= true;    
        }
        else
        {
            // No form exists, proceed to next page and create new form

            newForm($conn, $email);
            header('Location: prof_page2.php');
        }

        mysqli_free_result($result);
    }
    
    if (isset($_POST['edit_form_submit']))
    {
        $semester = $_POST['semester'];
        $cookie_name='semester';
        setcookie($cookie_name, $semester, time() + 86400, "/"); // 86400 = 1 day
        $sql = "SELECT formID FROM forms where email='".$email."' AND semester='".$semester."'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) != 0)
        {
            echo mysqli_error($conn);
            $formData = mysqli_fetch_assoc($result);
            $formID = $formData['formID'];
        }
        // Check if form already exists, if not, prompt to create new form
        if (mysqli_num_rows($result) > 0)
        {
            $cookie_name = 'formID';
            setcookie($cookie_name, $formID, time() + 86400, "/"); // 86400 = 1 day
            header('Location: prof_page2.php');
        }
        else
        {
            // Request confirmation to create new form
            $is_new_popup_visible = true;    
        }

        mysqli_free_result($result);
    }

    mysqli_close($conn);
?>

<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/prof_navbar.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Select Option"; ?>
            </h1>
            <form action=prof_page1.php method="POST" id="main-form">
                <select name="semester" id="semester-select">
                    <option value="s2022">Spring 2022</option>
                    <option value="su2022">Summer 2022</option>
                    <option value="f2022">Fall 2022</option>
                    <option value="s2023">Spring 2023</option>
                </select>
                <div class="center" style="margin:15px; text-align:center;">
                        <input type="submit" name="new_form_submit" value="New Form">
                </div>
                <div class="center" style="margin:15px; text-align:center;">
                        <input type="submit" name="edit_form_submit" value="Edit Form">
                </div>
            </form>
            <!-- Overwrite Popup -->
            <div class="form-popup" id="delete_form" <?php if($is_overwrite_popup_visible){echo 'style="display:inline;"';}?>>
                <form action='prof_page1.php' method="POST" class="form-container">
                    <h1>A form already exists and will be overwritten. Would you like to continue?</h1>
                    <button name="yes_overwrite" type="submit" class="btn">Continue</button>
                    <form action="prof_page1.php" method="POST">
                        <button name="no_overwrite" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
            <!-- New Popup -->
            <div class="form-popup" id="new_form" <?php if($is_new_popup_visible){echo 'style="display:inline;"';}?>>
                <form action='prof_page1.php' method="POST" class="form-container">
                    <h1>Form Not Found. Would you like to create a new form?</h1>
                    <button name="yes_new" type="submit" form="main-form" class="btn">Continue</button>
                    <form action="prof_page1.php" method="POST">
                        <button name="no_new" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>