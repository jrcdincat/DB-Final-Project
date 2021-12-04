<?php
    include('db_connection.php');

    if(!isset($_COOKIE['email']))
    {
        echo "cookie not set";
    }
    if(!isset($_COOKIE['formID']))
    {
        echo "cookie not set";
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
        // Go to next page after deleting previous form data
        header('Location: prof_page2.php');
    }        

    // Edit form popup button responses
    if(isset($_POST['yes_new']))
    {
        header('Location: prof_page2.php');
    }     
    if(isset($_POST['no_new']))
    {
        $is_new_popup_visible = false;
    }       


    $email = $_COOKIE['email'];
    $formID = $_COOKIE['formID'];

    if(isset($_POST['new_form_submit']))
    {
        // Check if form already exists, if so, prompt for deletion
        $sql = "SELECT * FROM forms where formID = '".$formID."'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0)
        {
            // Request confirmation to overwrite form
            $is_overwrite_popup_visible= true;    
        }
        else
        {
            // No form exists, proceed to next page
            header('Location: prof_page2.php');
        }

        mysqli_free_result($result);
    }
    
    if (isset($_POST['edit_form_submit']))
    {
        $sql = "SELECT * FROM forms where formID = '".$formID."'";
        $result = mysqli_query($conn, $sql);

        // Check if form already exists, if not, prompt to create new form
        if (mysqli_num_rows($result) > 0)
        {
            header('Location: prof_page2.php');
        }
        else
        {
            // Request confirmation to create new form
            $is_new_popup_visible = true;    
        }
    }

    mysqli_close($conn);
?>

<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>
                <?php echo "Select Option"; ?>
            </h1>
            <form action=prof_page1.php method="POST">
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
                    <button name="yes_new" type="submit" class="btn">Continue</button>
                    <form action="prof_page1.php" method="POST">
                        <button name="no_new" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>