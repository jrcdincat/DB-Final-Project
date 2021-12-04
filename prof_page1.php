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

    $email = $_COOKIE['email'];
    $formID = $_COOKIE['formID'];

    if(isset($_POST['new_form_submit']))
    {
        // Check if form already exists, if so, prompt for deletion
        $sql = "SELECT * FROM forms where formID = '".$formID."'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0)
        {
            // Request deletion first
            echo "record found";
        }
        else
        {
            // Go to next page to add books
            echo "No records";
        }

        mysqli_free_result($result);
        // Send to new form
        header('Location: prof_page2.php');
    }
    
    if (isset($_POST['edit_form_submit']))
    {
        // Check if form already exists, if not, prompt to create new form
        if (mysqli_num_rows($result) > 0)
        {
            // Request deletion first
            echo "record found";
        }
        else
        {
            // Go to next page to add books without populating values
            echo "No records";
        }

        // Send to form edit
        header('Location: prof_page2.php');
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
        </section>
    <?php include ('templates/footer.php'); ?>
</html>