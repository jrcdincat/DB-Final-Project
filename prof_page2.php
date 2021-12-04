<?php
    include('db_connection.php');

    $formID = $_COOKIE['formID'];

    if(isset($_POST['add_book']))
    {
        // Form data
        $isbn = htmlspecialchars($_POST['isbn']);
        $title = htmlspecialchars($_POST['title']);
        $authors = htmlspecialchars($_POST['authors']);
        $edition = htmlspecialchars($_POST['edition']);
        $publisher = htmlspecialchars($_POST['publisher']);
        
        // Try and get book 
        $sql_get_book = "SELECT isbn FROM books WHERE isbn = '".$isbn."'";
        $get_book_result = mysqli_query($conn, $sql_get_book);
        $get_book_data = mysqli_fetch_assoc($get_book_result);
        mysqli_free_result($get_book_result);
        if(!$get_book_data)
        {
            $sql_insert_book = "INSERT INTO books (isbn, Title, Writers, Publisher, form, b_edition) VALUES ('".$isbn."',
            '".$title."', '".$authors."', '".$publisher."','', '".$edition."')"; 
            mysqli_query($conn, $sql_insert_book);
        }

        $sql_check = "SELECT * FROM forms WHERE formID = '".$formID."' AND isbn = '".$isbn."'";
        $result_check = mysqli_query($conn, $sql_check);
        if(mysqli_num_rows($result_check) == 0)
        {
            $sql_add_book_to_form = "INSERT INTO forms (formID, isbn) VALUES ('".$formID."', '".$isbn."')";
            mysqli_query($conn, $sql_add_book_to_form);
        }
        mysqli_free_result($result_check);
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

    // Delete selected books
    if(isset($_POST['delete_books']))
    {
        $checked_books = $_POST['check'];
        foreach($checked_books as $book)
        {
            $sql_delete_selected = "DELETE FROM forms WHERE isbn = '".$book."'";
            mysqli_query($conn, $sql_delete_selected);
            
            // Delete book from books table if no more forms use that book
            $sql_check_delete_from_books = "SELECT * FROM forms WHERE isbn = '".$book."'";
            if(mysqli_num_rows(mysqli_query($conn, $sql_check_delete_from_books)) == 0)
            {
                $sql_delete_selected = "DELETE FROM books WHERE isbn = '".$book."'";
                mysqli_query($conn, $sql_delete_selected);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <!-- Add header to webpage -->
    <?php include ('templates/header.php'); ?>
        <section style="text-align: center;">

            <!-- Table -->
            <form class="table-form" action="prof_page2.php" method="POST">
            <h1>
                <?php echo "Books"; ?>
            </h1>
            <div style="overflow: auto;">
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 3%;"></th>
                            <th style="width:18%">Title</th>
                            <th style="width:18%">Author(s)</th>
                            <th style="width:18%">Edition</th>
                            <th style="width:18%">Publisher</th>
                            <th style="width:18%">ISBN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $sql = "SELECT * FROM forms WHERE formID = '".$formID."'";
                                $results = mysqli_query($conn, $sql);
                                $form_data = mysqli_fetch_all($results, MYSQLI_ASSOC);
                                mysqli_free_result($results);
                            
                                // generate books form table
                                foreach ($form_data as $data):
                                    $isbn_val = $data['isbn'];
                                    $sql_get_request_data = "SELECT * FROM books WHERE isbn = '".$isbn_val."'";
                                    $request_results = mysqli_query($conn, $sql_get_request_data);
                                    $request_data = mysqli_fetch_assoc($request_results);
                        ?>
                        <tr>
                            <td><input type="checkbox" name="check[]" value="<?php echo $isbn_val?>"></td>
                            <td><?php echo $request_data['Title'];?></td>
                            <td><?php echo $request_data['Writers'];?></td>
                            <td><?php echo $request_data['b_edition'];?></td>
                            <td><?php echo $request_data['Publisher'];?></td>
                            <td><?php echo $request_data['isbn'];?></td>
                        </tr>
                    </tbody>
                    <?php                                     
                        mysqli_free_result($request_results);
                        mysqli_close($conn);
                        endforeach; 
                    ?>
                </table>
            </div>
                <button name="delete_books" class="btn-options" type="submit" class="btn" style="top: 355px;">Delete Books</button>
            </form>

            <!-- Button Options -->
            <form action="prof_page2.php" method="POST">
                <button name="open_new_book_form" class="btn-options" type="submit" class="btn">Add New Book</button>
                <button name="delete_form" class="btn-options" type="submit" class="btn" style="top: 410px;">Delete Form</button>
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
        </section>
    <?php include ('templates/footer.php'); ?>
</html>