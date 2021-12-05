<?php
    include('db_connection.php');

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
                    <h1>Faculty List</h1?<br><hr>
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
                <button id="submit" type="submit" name="submit" class="btn btn-primary">Submit</button>
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