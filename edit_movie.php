<div id="add-movie-box" class="box-background border border-dark rounded col-lg-6 container p-4 my-4">
    <h3 class="text-center">
        Edit Post
    </h3>
    <form action="action.php" method="post" class="col-12" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?php echo $selectedMovie['post_id'] ?>">
        <label class="col-12 my-3">
            Movie Name :
            <input type="text"
                name="movie-name"
                id="movie-name"
                class="form-control"
                value="<?php  echo $selectedMovie['movie_name'] ?>"
            >
        </label>
        <label class="col-12 my-3">
            Released Date :
            <input type="date"
                name="released-date"
                placeholder="yyyy-mm-dd"
                class="form-control"
                value="<?php  echo $selectedMovie['released_date']; ?>"
            >
        </label>
        <label class="col-12 my-3">
            About this Movie :
            <textarea name="description" class="form-control">
                <?php  echo $selectedMovie['description']; ?>
            </textarea>
        </label>
        <div class="col-12 text-center my-3">
            <button type="button" class="btn btn-danger mt-3" onclick="window.location = 'my_movies.php';">
                <i class="fas fa-arrow-left"></i> Cancel
            </button>
            <button type="submit" class="btn btn-primary mt-3" name="update_movie">
                Update Movie
            </button>
        </div>
    </form>
</div>
