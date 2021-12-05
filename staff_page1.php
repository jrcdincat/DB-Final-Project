<?php
    include('db_connection.php');

    // If the request is a POST, get the f_name, l_name, and email from the form and insert into the database
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];

        $sql = "INSERT INTO Professors (f_name, l_name, email) VALUES ('$f_name', '$l_name', '$email')";
        $result = mysqli_query($conn, $sql);
        // If the query succeeded, reload the page with a get request
        if ($result) {
            header("Location: staff_page1.php");
        }
    }

    if(!isset($_COOKIE['email']))
    {
        echo "cookie not set";
    }

    $email = $_COOKIE['email'];
    //mysqli_close($conn);
?>


<html>
    <!-- Add Jquery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section class="container" style="text-align: center;">
        <table style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 3%;">ALL <input id='maincheck' type='checkbox' name='professor_id[]'  checked></th>
                            <th style="width:18%">First Name</th>
                            <th style="width:18%">Last Name</th>
                            <th style="width:18%">E-mail</th>
                        </tr>
                    </thead>
                    <h1>Add a Faculty</h1>
                    <!-- Create a form with three inputs that take the first name, last name, and email of the faculty -->
                    <form action="staff_page1.php" method="post">
                        <input type="text" name="f_name" placeholder="First Name" required>
                        <input type="text" name="l_name" placeholder="Last Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="submit" value="Add Faculty">
                    </form>
                    <hr>
                    <h1>Faculty List</h1>
                    <tbody>
                        <?php
                                $sql = "SELECT * FROM Professors";
                                $results = mysqli_query($conn, $sql);
                                $professor_data = mysqli_fetch_all($results, MYSQLI_ASSOC);

                                // Loop through each professor display f_name, l_name, and email
                                foreach ($professor_data as $data) {
                                    echo "<tr>";
                                    echo "<td><input class='prof' type='checkbox' name='professor_id[]' value='" . $data['Email'] . "' checked></td>";
                                    echo "<td>".$data['f_name']."</td>";
                                    echo "<td>".$data['l_name']."</td>";
                                    echo "<td>".$data['Email']."</td>";
                                    echo "</tr>";
                                }
                        ?>
                    </tbody>
                    <?php                                     
                        mysqli_close($conn);
                    ?>
                </table>
                <!-- Create a button to submit the form containing all of the professors that are checked -->
                <button id="submit" type="submit" name="sendemail" class="btn btn-primary">SEND EMAIL(S)</button>
                <button id="deleteselected" type="submit" name="delete" class="btn btn-primary">DELETE SELECTED</button>
        </section>
    <?php include ('templates/footer.php'); ?>

    <script>
        // Check all checkboxes
        $('#maincheck').click(function(){
            if($(this).is(':checked')){
                $('input[type="checkbox"]').prop('checked', true);
            } else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        });

        // When the submit button is clicked, check to see if any checkboxes are checked and if so, save the email of the checked checkboxes to a cookie
        $('#submit').click(function(){
            var checked = $('input[type="checkbox"]:checked').length;
            if(checked > 0){
                var emails = [];
                $('input[class="prof"]:checked').each(function(){
                    emails.push($(this).val());
                });
                // TODO: PROCESS THE EMAILS TO PASS TO NEXT PAGE
                console.log(emails);
            }
        });

    </script>
</html>