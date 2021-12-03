<?php

    if(isset($_POST['new_form_submit']))
    {
        // Check if form already exists, if so, prompt for deletion

        // Send to new form
        header('Location: prof_page2.php');
    }
    
    if (isset($_POST['edit_form_submit']))
    {
        // Check if form already exists, if not, prompt to create new form

        // Send to form edit
        header('Location: prof_page2.php');
    }

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