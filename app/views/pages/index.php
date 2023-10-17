<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="container px-5">

      <!-- row for adding new posts -->
      <div class="row p-3" id="newTweet">
        <div class="col position-relative">
          <div class="profile-image-holder position-absolute mt-3">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-circle" style="height:70px;width: 70px;" alt="profile icon">
          </div>
        </div>
        <div class="col-11">
          <div class="row">
            <div class="col-2 mt-1"><small>@<?php echo $data['userinfo']->name; ?></small></div>
          </div>
          <form action="<?php echo URLROOT ?>/pages/postTweets" id="tweetForm" method="post">
            <div class="row rounded mb-2 ms-0 me-0 border" style="height: 50px;">
              <textarea type="text" cols="30" rows="3" class="form-control" name="tweetInput" id="tweetInput" aria-describedby="postinput" placeholder="What's happening?"></textarea>
            </div>
            <br>
            <hr>
            <div class="row mb-1">
              <div class="col d-flex justify-content-start">
                <button type="button" class="btn btn-outline-primary btn-sm"> <i class="fa-solid fa-image"></i> Image</button>
                <div class="p-1"></div>
              </div>
              <div class="col">
                <div class="col"></div>
              </div>
              <div class="col d-flex justify-content-end">
              </div>
              <div class="col d-flex justify-content-end tweet-share-button">
                <div class="p-1"></div>
                <button type="submit" id="shareButton" value="tweetForm" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-plus"></i> Share</button>
              </div>
            </div>
        </form>
        </div>
      </div>
      <!-- row for adding new posts ENDS -->
      <hr>
      <br>
      <?php flash('upload_success'); ?>
      <?php flash('upload_fail'); ?>
      <?php flash('delete_success'); ?>
      <?php flash('delete_fail'); ?>
      <!-- this page should load all user's friend posts and tweets -->
      <!--loop all posts from here-->
      <?php foreach($data['tweets'] as $tweets): ?>
        <?php 
          $time_tweetPosted = $tweets->postCreated;
          $difference = getTimeInterval($time_tweetPosted);  
        ?>
      <div class="row border p-3">
        <div class="col position-relative">
          <div class="profile-image-holder position-absolute mt-3">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-circle" style="height:70px;width: 70px;" alt="profile icon">
          </div>
        </div>
        <div class="col-11">
          <div class="row">
            <div class="col-2 mt-1"> <a href="<?php echo URLROOT; ?>/pages/viewProfile/<?php echo $tweets->userID; ?>" style="color: black; text-decoration: none;" > <small> @<?php echo $tweets->name; ?></small></a></div>
            <div class="col-2 mt-1"><small><?php echo $difference; ?></small></div>
          </div>
          <div class="row border rounded mb-1 ms-0 me-0">
            <p><?php echo $tweets->body; ?></p>
          </div>
          <div class="row mb-1">
            <div class="col d-flex justify-content-start">
              <button type="button" class="btn btn-outline-danger btn-sm"> <i class="fa-regular fa-heart"></i> Like</button>
              <div class="p-1"></div>
              <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fa-regular fa-comment"></i> Comment</button>
            </div>
            <div class="col">
              <div class="col"></div>
            </div>
            <div class="col d-flex justify-content-end">
            </div>
            <div class="col d-flex justify-content-end">
              <?php if(getCurrentid()==$tweets->userID): ?>
              <div class="p-1"></div>
                <form action="<?php echo URLROOT ?>/pages/deleteTweet/<?php echo $tweets->postID ?>" id="deleteTweet" method="post">
                  <button type="submit" value="deleteTweet" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
<script>
  var shareBtn = document.querySelector('#shareButton');
  shareBtn.disabled = true;
  var tweetInput = document.querySelector('#tweetInput');
    //disable submit button if there is no text input
    tweetInput.addEventListener('keyup',e=>{
      if(e.target.value == ""){
        shareBtn.disabled = true;
      } else {
        shareBtn.disabled = false;
      }
    });
  
    $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
      });
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>