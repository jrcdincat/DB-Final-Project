<?php
    include('db_connection.php');

    $formID = $_COOKIE['formID'];
    $is_overwrite_popup_visible = false;

    if(isset($_POST['add_book']))
    {
        // Form data
        $isbn = htmlspecialchars($_POST['isbn']);
        $title = htmlspecialchars($_POST['title']);
        $authors = htmlspecialchars($_POST['authors']);
        $edition = htmlspecialchars($_POST['edition']);
        $publisher = htmlspecialchars($_POST['publisher']);
        
        // Try and get book 
        $sql_get_book = "SELECT isbn FROM books WHERE isbn = '".$isbn."' AND formID = '".$formID."'";
        $get_book_result = mysqli_query($conn, $sql_get_book);
        $get_book_data = mysqli_fetch_assoc($get_book_result);
        mysqli_free_result($get_book_result);
        if(!$get_book_data)
        {
            $sql_insert_book = "INSERT INTO books (isbn, title, writers, publisher, formID, b_edition) VALUES ('".$isbn."',
            '".$title."', '".$authors."', '".$publisher."','".$formID."', '".$edition."')"; 
            mysqli_query($conn, $sql_insert_book);
        }
    }

    // Set visibility of add new books form
    $is_add_book_visible = false;
    if(isset($_POST['open_new_book_form']))
    {
        $is_add_book_visible = true;
    }
    if(isset($_POST['close_add_new_book_form']))
    {
        $is_add_book_visible = false;
    }

    // Delete selected books popup
    if(isset($_POST['delete_books']) && isset($_POST['check']))
    {
        $check_array = json_encode($_POST['check']);
        $cookie_name = 'checked';
        setcookie($cookie_name, $check_array, time() + 86400, "/"); // 86400 = 1 day
        $is_select_popup_visible = true;
    }

    if(isset($_POST['delete_form']))
    {
        $is_overwrite_popup_visible = true;
    }

    if(isset($_POST['no_overwrite']))
    {
        $is_overwrite_popup_visible = false;
    }

    // Delete form
    if(isset($_POST['yes_overwrite']))
    {
        // Delete all books with formID
        $sql_del_books_in_form = "DELETE FROM books WHERE formID='".$formID."'";
        mysqli_query($conn, $sql_del_books_in_form);

        // Delete formID
        $sql_del_form = "DELETE FROM forms WHERE formID='".$formID."'";
        mysqli_query($conn, $sql_del_form);
        header('Location: prof_page1.php');
    }        

    // Delete selcted books
    if(isset($_POST['delete_select']))
    {
        $checked_books = json_decode($_COOKIE['checked']);

        foreach($checked_books as $book)
        {
            $sql_delete_selected = "DELETE FROM books WHERE isbn = '".$book."' AND formID = '".$formID."'";
            mysqli_query($conn, $sql_delete_selected);
        }
        $is_select_popup_visible = false;
    }     
    if(isset($_POST['no_delete_select']))
    {
        $is_select_popup_visible = false;
    }       

?>

<!DOCTYPE html>
<html>
    <!-- Add Jquery Script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
    <?php include ('templates/prof_navbar.php'); ?>

    <section style="text-align: center;">

        <!-- Table -->
        <form class="table-form" action="prof_page2.php" method="POST" id='table-form'>
            <?php 
                $term = $_COOKIE['semester'];
                $copy = $term;
                // if there's 'su' in term, create a variable that will save 'Summer' + the digits of term
                // if there's 'f' in term, create a variable that will save 'Fall' + the digits of term
                // if there's 's' in term, create a variable that will save 'Spring" + the digits of term
                if(strpos($term, 'su') !== false){
                    $copy = 'Summer ' . substr($term, 2);
                }
                else if(strpos($term, 'f') !== false){
                    $copy = 'Fall ' . substr($term, 1);
                }
                else if(strpos($term, 's') !== false){
                    $copy = 'Spring ' . substr($term, 1);
                }                
            
                echo "<h1> $copy Books</h1>"; 
            ?>
        <div style="overflow: auto;">
            <table style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 3%;">ALL <input id='maincheck' type='checkbox' name='main' unchecked></th>
                        <th style="width:18%">Title</th>
                        <th style="width:18%">Author(s)</th>
                        <th style="width:18%">Edition</th>
                        <th style="width:18%">Publisher</th>
                        <th style="width:18%">ISBN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            $sql = "SELECT * FROM books WHERE formID = '".$formID."'";
                            $results = mysqli_query($conn, $sql);
                            $form_data = mysqli_fetch_all($results, MYSQLI_ASSOC);
                            mysqli_free_result($results);
                        
                            // generate books form table
                            foreach ($form_data as $data):
                                $isbn_val = $data['isbn'];
                                $sql_get_request_data = "SELECT * FROM books WHERE isbn = '".$isbn_val."' AND formID = '".$formID."'";
                                $request_results = mysqli_query($conn, $sql_get_request_data);
                                $request_data = mysqli_fetch_assoc($request_results);
                    ?>
                    <tr>
                        <td><input type="checkbox" name="check[]" value="<?php echo $isbn_val?>"></td>
                        <td><?php echo $request_data['title'];?></td>
                        <td><?php echo $request_data['writers'];?></td>
                        <td><?php echo $request_data['b_edition'];?></td>
                        <td><?php echo $request_data['publisher'];?></td>
                        <td><?php echo $request_data['isbn'];?></td>
                    </tr>
                </tbody>
                <?php                                     
                    mysqli_free_result($request_results);
                    endforeach; 
                ?>
            </table>
        </div>
        <div style="text-align:right; margin-top:5px">
            <button name="delete_books" type="submit" id="delete_select"class="btn">Delete Selected</button>
        </div>
        </form>

        <!-- Button Options -->
        <form action="prof_page2.php" method="POST">
            <button name="open_new_book_form" class="btn-options" type="submit" style="top:345px;">Add New Book</button>
            <button name="delete_form" class="btn-options" type="submit" class="btn" style="top: 400px;">Delete Form</button>
        </form>

        <!-- Add new books popup -->
        <div class="form-popup" id="add_book_form" <?php if($is_add_book_visible){echo 'style="display:inline;"';}?>>
            <form action='prof_page2.php' method="POST" class="form-container">
                <h1>Add Book</h1>

                <label for="Title"><b>Title</b></label>
                <input type="text" placeholder="Enter Title" name="title" maxlength="100">

                <label for="Author(s)"><b>Author(s)</b></label>
                <input type="text" placeholder="Enter Author(s)" name="authors">

                <label for="Edition"><b>Edition</b></label>
                <input type="text" placeholder="Enter Edition" name="edition" maxlength="3">

                <label for="Publisher"><b>Publisher</b></label>
                <input type="text" placeholder="Enter Publisher" name="publisher" maxlength="60">

                <label for="ISBN"><b>ISBN</b></label>
                <input type="text" placeholder="Enter ISBN" name="isbn" maxlength="13">

                <button name="add_book" type="submit" class="btn">Add</button>
                <form action="prof_page2.php" method="POST">
                    <button name="close_add_new_book_form" type="submit" class="btn cancel">Cancel</button>
                </form>
            </form>
        </div>
        <div class="form-popup" id="delete_form" <?php if($is_overwrite_popup_visible){echo 'style="display:inline;"';}?>>
                <form action='prof_page2.php' method="POST" class="form-container">
                    <h1>Are you sure you want to delete form?</h1>
                    <button name="yes_overwrite" type="submit" class="btn">Continue</button>
                    <form action="prof_page2.php" method="POST">
                        <button name="no_overwrite" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
            <!-- Delete Selected Popup -->
            <div class="form-popup" id="delete_selected" <?php if($is_select_popup_visible){echo 'style="display:inline;"';}?>>
                <form action='prof_page2.php' method="POST" class="form-container">
                    <h1>Are you sure you want to delete books?</h1>
                    <button name="delete_select" type="submit" form="table-form" class="btn">Continue</button>
                    <form action="prof_page2.php" method="POST">
                        <button name="no_delete_select" type="submit" class="btn cancel">Cancel</button>
                    </form>
                </form>
            </div>
    </section>
    <?php mysqli_close($conn); include ('templates/footer.php'); ?>
    <script>
        // Check all checkboxes
        $('#maincheck').click(function(){
            if($(this).is(':checked')){
                $('input[type="checkbox"]').prop('checked', true);
            } else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        });

        //     // When the deleteselected button is clicked, check to see if any checkboxes are checked and if so, save the email of the checked checkboxes to a cookie
        //         $('#delete_select').click(function(){
        //     var checked = $('input[class="adm"]:checked').length;
        //     if(checked > 0){

        //         // Confirm with the user if he wants to delete the professors with a confirmation alert
        //         var r = confirm("Are you sure you want to delete the " +checked+ " selected?");
        //         if (r == true) {
        //             // Send a POST request to this page with the emails of the professors to be deleted
        //             $.post("prof_page2.php", {emails: emails, intent: 'delete'}, function(data){
        //                 // Reload the page
        //                 location.reload();
        //             });
        //         } else {
        //             return;
        //         }
        //     }
        // });

    </script>
</html>
