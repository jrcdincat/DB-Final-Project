<html>
    <!-- Check if email cookie exists and it's valid -->
    <?php
        // If the email cookie doesn't exist or it expired, redirect to login page (staff.php)
        if(!isset($_COOKIE['email']) || $_COOKIE['email'] == "") {
            header("Location: staff.php");
        }
    ?>
    <!-- Add Jquery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/navbar.php'); ?>
        <section class="container" style="text-align: center;">
            <h1>Staff Home</h1>
            <!-- Create a welcome page with three buttons to navigate to the home, admin and staff pages -->
            <p>Welcome to the staff home page. Please select an option from the navigation <strong>menu above</strong>.</p>
        </section>
    <?php include ('templates/footer.php'); ?>
</html>