<?php

class Sort extends Dbh
{
    public function sort()
    {
        if (isset($_POST['Book'])) {
            $Book = $_POST['Book'];
            $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Type_Name = :book";

            $statement = $this->connect()->prepare($query);
            $statement->bindParam(":book", $Book);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
        if (isset($_POST['CD'])) {
            $CD = $_POST['CD'];
            $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Type_Name = :cd";

            $statement = $this->connect()->prepare($query);
            $statement->bindParam(":cd", $CD);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
        if (isset($_POST['DVD'])) {
            $DVD = $_POST['DVD'];
            $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Type_Name = :dvd";

            $statement = $this->connect()->prepare($query);
            $statement->bindParam(":dvd", $DVD);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
        if (isset($_POST['magazine'])) {
            $magazine = $_POST['magazine'];
            $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Type_Name = :magazine";

            $statement = $this->connect()->prepare($query);
            $statement->bindParam(":magazine", $magazine);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
        if (isset($_POST['research dissertation'])) {
            $research_Dissertation = $_POST['research dissertation'];
            $query = "SELECT collection.Collection_ID,collection.Type_ID,Title,Author_Name,
            Cover_Image,state,types.Type_Name
            FROM collection INNER JOIN types ON collection.Type_ID = types.Type_ID WHERE Type_Name = :research_Dissertation";

            $statement = $this->connect()->prepare($query);
            $statement->bindParam(":research_Dissertation", $research_Dissertation);
            $statement->execute();
            $libraryList = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $libraryList;
        }
    }
}
$library = new Sort();
$libraryList = $library->sort();

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