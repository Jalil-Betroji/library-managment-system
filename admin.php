 <?php

 ?>
 
 
 <!-- =========================================== -->
    <!-- The Start of add announce Modal -->
    <!-- =========================================== -->

    <div class="modal fade" id="add_announces" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Add New Announce
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_new_announce" method="post" enctype="multipart/form-data" class="form-input">
                        <div id="modal_flex">
                            <form class="form-box px-3">
                                <div>
                                    Select image to upload:
                                    <input type="file" name="image" class="border-0">
                                </div>

                                <div class="form-input">
                                    <input type="text" name="Title" placeholder="Title">

                                    <input type="text" name="Rooms" placeholder="Rooms">

                                    <input type="number" name="Amount" placeholder="Amount">

                                    <select>
                                        <option selected>City</option>
                                        <option value="Tanger">Tanger</option>
                                        <option value="Tetouan">Tetouan</option>
                                        <option value="Casablanca">Casablanca</option>
                                        <option value="Hociema">Hociema</option>
                                        <option value="Rabat">Rabat</option>
                                    </select>

                                    <input type="text" name="house_number" placeholder="House Number">

                                    <select name="Category">
                                        <option value="- Select Category -" selected>
                                            - Select Category -
                                        </option>
                                        <option value="Rental" name="Type">Rental</option>
                                        <option value="Sell" name="Type">Sell</option>
                                    </select>

                                </div>

                                <div class="form-input">

                                    <input type="number" name="Area" placeholder="Area">

                                    <input type="tex" name="Bathrooms" placeholder="Bathrooms">

                                    <select>
                                        <option selected>Country</option>
                                        <option value="Morocco">Morocco</option>
                                    </select>

                                    <input type="tex" name="code postal" placeholder="Code Postal">

                                    <input type="tex" name="house_floor" placeholder="House Floor">

                                    <select name="Type">
                                        <option selected>Type</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="House">House</option>
                                        <option value="Villa">Villa</option>
                                        <option value="Office">Office</option>
                                        <option value="Land">Land</option>
                                    </select>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-warning">Add Announce</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
        <!-- =========================================== -->
        <!-- The End of add announce Modal -->
        <!-- =========================================== -->