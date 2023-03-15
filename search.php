<?php

class Library extends Dbh
{

    public function getLibraryList()
    {
        if (isset($_POST['searchbtn'])) {
            $book_Search = $_POST['book_Search'];

            $statement = $this->connect()->prepare("SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Title LIKE '%$book_Search%'");
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
        if (isset($_POST['RS_Searchbtn'])) {
            $reservation_ID = $_POST['reservation_search'];
            $statement = $this->connect()->prepare("SELECT collection.Collection_ID, collection.Type_ID, Title, Author_Name, Cover_Image, state, types.Type_Name, reservation.Reservation_ID
            FROM collection 
            INNER JOIN types ON collection.Type_ID = types.Type_ID 
            INNER JOIN reservation ON reservation.Collection_ID = collection.Collection_ID
            WHERE reservation.Reservation_ID = :reservation_ID");
            $statement->bindParam(":reservation_ID", $reservation_ID);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
    }
}

$library = new Library();
$libraryList = $library->getLibraryList();

foreach ($libraryList as $values) {
    ?>
    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="property-item rounded overflow-hidden">
            <div class="position-relative overflow-hidden">
                <a href=""><img class="size img-fluid" src="img/<?php echo $values['Cover_Image'] ?>" alt=""></a>
                <div class="bg-color rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                    <?php echo $values['Type_Name'] ?>
                </div>
                <div class="bg-white rounded-top text-color position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                    <?php echo $values['state'] ?>
                </div>
            </div>
            <div class="p-4 pb-0">
                <a class="d-block h5 mb-2" href="">
                    <?php echo $values['Title'] ?>
                </a>
                <p><i class="fa-solid fa-pen-nib text-color me-2"></i>
                    <?php echo $values['Author_Name'] ?>
                </p>
            </div>

            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#more_details_modal"
                onclick="getMore_Details(<?php echo $values['Collection_ID']; ?>)">More Details</button>
        </div>
    </div>
    <?php

}
?>