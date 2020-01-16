<div class="panel panel-popup float-fade-in" id="category-creation">
    <div class="panel-content">
        <div class="box-list float-fade-in">
            <div class="box-list-item">
                <div class="box-container">
                    <h3>Create A Category</h3>
                </div>
                <div class="box-list box-list-small">
                    <h6>Category Title</h6>
                    <p>The title should be short while easily being able to provide the reader with a general idea of what your assignment is about!</p>
                    <div class="box-list-item input-item">
                        <input type="text" name="assignment-title">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>Assignment Category</h6>
                    <p>This will help you be able to better manage and organize current and past assignments. If you don't see a category that will fit this assignment, then you can make one! Unlike stories, it is good to generalize the category (but not too much!).</p>
                    <div class="box-list-item input-item">
                        <dropdown>
                            <dropdown-head>
                                <dropdown-current>Pick A Category</dropdown-current>
                                <input type="hidden" name="categoryid">
                            </dropdown-head>
                            <dropdown-options>
                            <?php
                                $categoryList = Assignments::getCategories($_POST["storyID"], 'Story');
                                foreach($categoryList as $category) {
                                    echo '<dropdown-options-item data-id="'.$category["categoryID"].'">['.$category["department"].'] - '.$category["category"].'</dropdown-options-item>';
                                }
                            ?>
                            </dropdown-options>
                        </dropdown>
                    </div>
                    <button id="createCategory">Create A New Category</button>
                </div>
                <button id="createAssignment">Create Assignment!</button>
                <button id="cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>