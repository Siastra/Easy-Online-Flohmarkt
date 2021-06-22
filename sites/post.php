<style>
    .main-card-container {
        position: relative;
        margin: 5px;
        display: flex;
        justify-content: flex-end;
        margin-top: -4.5vh;
        font-family: cursive;
    }

    .card {
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27);
        width: 23rem;
        height: 55vh;
        border: 1px solid black;
        background-color: rgb(229, 235, 247);
    }

    .message-area {
        height: 80%;
        overflow-y: scroll;
    }

    .card .card-header {
        border: 1px solid black;
        margin: 1px;
        height: 13%;
        display: flex;
        justify-content: space-between;

    }

    .card .message-area {

        border: 1px solid black;
        margin: 1px;
        height: 74%;
        width: auto;
    }

    .hide-box .btn {
        border: none;
        color: red;
        font-weight: bold;
    }

    .name-header,
    .hide-box {
        width: auto;
        height: 2.5rem;
        display: flex;
        align-self: center;
        border-radius: 5px;
        padding: 2px;
        font-weight: bold;
    }

    .name-header {
        display: flex;
        align-items: center;
    }

    .name-header img {
        width: 15%;
        height: 2.5rem;
        border-radius: 50%;
    }


    .name-header p {
        margin: 5px 5px 5px 8px;
    }

    .card-header p {
        margin-top: 5px;
    }

    .friend-list {
        border: 10px solid black;
        width: 9%;
        height: 65%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        overflow-y: scroll;
        border-radius: 70px 70px 0px 0px;
        border: 1px solid black;
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27);
        background-color: lightgray;
    }

    .friend-list::-webkit-scrollbar {
        width: 5px;
    }

    .friend-list::-webkit-scrollbar-track {
        border-radius: 10px;
        margin-top: 80px;
        margin-bottom: 70px;
        background-color: lightgray;
        margin-right: 20px;
    }

    .friend-list::-webkit-scrollbar-thumb {
        background-color: gray;
    }

    .interested-person img {
        width: 70%;
        height: 60%;
        margin: 4px;
        border-radius: 50%;
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27);
    }

    .interested-person {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 5px;
    }

    .interested-person p {
        font-family: cursive;
        text-align: center;
    }

    .interested-person img:hover {
        cursor: pointer;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .my-card p {
        margin: 2px;
        font-family: cursive;
        font-size: 12px;
        display: flex;
    }

    .footer p {
        margin: 2px;
        font-family: cursive;
        font-size: 10px;
        font-weight: bold;
    }

    .my-card {
        display: flex;
        width: 90%;
        height: auto;
        border: 1px solid;
        border: 1px solid rgb(106, 131, 141);
        margin: 5px;
        border-radius: 3px;
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27)
    }

    .my-card img {
        width: 10%;
        height: 2rem;
        border-radius: 50%;
        margin-top: 2px;
    }

    .botton-area button {
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27);
        background-image: linear-gradient(to right top, #a0d9d1, #9adcd5, #93dfda, #8ce1df, #84e4e5);
    }

    .botton-area input {
        box-shadow: 0px 1px 15px 3px rgba(15, 29, 255, 0.27);
        background-color: lightgray;
    }

    .interested-person #ip{
        margin-top: 50%;
        font-size: 50%;
    }

    .friendPersonList .personList img{
        border-radius: 50%;
        height: 5rem;
        width: 5rem;
        margin: 5px;
    }
    .friendPersonList .personList{
        position: fixed;
        margin-top: -20%;
        margin-left: -2rem;
        display: flex;
        flex-direction: column;
        align-items: start;
    }
    .friendPersonList .personList li{
        margin-top: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;

    }
    .friendPersonList .personList li:hover{
    cursor: pointer;
    }
    .friendPersonList .personList img:hover{
        height: 7rem;
        width: 7rem;
    }
    .friendPersonList  ul {
        font-family: cursive;
    list-style-type: none;
}
</style>



<?php
    include_once $_SESSION["path"] . "/backend/utility/DB.php";
    $db = new DB();
    $post = $db->getAdById(intval($_REQUEST["id"]));
    $comments = $db->getCommentsByUser($post->getUser()->getId());
    $id = $post->getId();
    $category = $post->getCategory();

    $images = scandir($_SESSION["path"]."/pictures/Adds/$id/full/");
    $images = array_filter($images, function($el){
        return $el != "." && $el != "..";
    });
?>
<section class="container">
<div class="row d-flex">
    <h5 class="container row mb-2"><?= $category?$category["name"]:"" ?></h5>
    <h1 class="mr-auto"><?= $post->getTitle() ?></h1>

    <?php if (isset($user)) : ?>
        <?php if ($user->haveFavorite($post->getId()))  :?>
    <a id = "js-favorite" class="btn btn-outline-primary mt-2" style ="height: 60%" href="#"><i class="fas fa-star"></i> favorite</a>
    <?php else :?>
    <a id = "js-favorite" class="btn btn-outline-primary mt-2" style ="height: 60%" href="#"><i class="far fa-star"></i> favorite</a>
    <?php endif; ?>
    <?php endif; ?>

    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-8 image mr-auto">
                <div class="row mx-auto">
                    <?php
                        if (count($images)) {
                            $limage = array_shift($images);
                        } else {
                            $limage = "/res/images/No-Image-Found.png";
                        }
                    ?>
                    <a href="<?=$_SESSION["relPath"]."/pictures/Adds/$id/full/".$limage?>" data-lightbox="roadtrip">
                        <img class = "col-12" alt="<?=$limage?>" src="<?=$_SESSION["relPath"]."/pictures/Adds/$id/half/".$limage?>" >
                    </a>
                </div>
                <div class="row col-12 mt-2 ">
                    <?php if (count($images)) : ?>
                        <?php foreach($images as $image): ?>
                            <a class = "col-3 p-0" href="<?=$_SESSION["relPath"]."/pictures/Adds/$id/full/".$image?>" data-lightbox="roadtrip">
                                <img class = "col-12 p-1" alt="<?=$image?>" src = "<?=$_SESSION["relPath"]."/pictures/Adds/$id/thumbnail/".$image?>" >
                            </a>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-4 price px-0">
                <div class="row">  
                <div class="col-12 text-center"  style = "font-size: larger; font-weight: 600; background-color: yellow; padding: 15px; margin-top: 20px;"><?= $post->getPrice()?>€ </div>
            </div>
            <div class="row"> 
                <a href="#" class="button btn-primary p-2 my-2 col-12 text-center">Chat</a>
            </div>
            <div class="row"> 
                <div class="container"><div class="row"><?= $post->getUser()->getFname() ?> <?= $post->getUser()->getLname() ?></div>
                <div class="row"><?= $post->getUser()->getAddress() ?></div>
                <div class="row">
                <div class="score">
                <?= sprintf("%01.2f", $post->getUser()->getScore());?>
                </div>
                <div class="score_star">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php $tmp = $post->getUser()->getScore() - $i;?>
                    <?php if ($tmp >= 0): ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ($tmp > -1): ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                </div>
                <a href="#" id="js-showcomments">See comments</a>
                </div></div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 description">
            <?= $post->getDescription() ?>
            </div>
        </div>
    </div>
</section>
<section class="single-chat-box">
        <div class="main-card-container">
            <div class="card message-box">
                <div class="card-header">
                    <div class="name-header">
                        <img id="nameHeaderPic" src="" alt="">
                        <p id="nameHeader">Farasat</p>
                    </div>
                    <div class="hide-box">
                        <button class="btn">X</button>
                    </div>
                    <!-- all headers -->
                </div>

                <div class="message-area" id="m-area">
                    <!-- through javascript -->
                </div>

                <div class="botton-area " style="display: flex; height: 13%;">
                    <input style="width: 80%;" type="text" name="message" id="userMessage" placeholder="message">
                    <input class="hiddenBox" type="hidden" name="id" placeholder="message">
                    <input class="hiddenBox2" type="hidden" name="post_id">
                    <button class="submit-btn" style="width: 20%;">Send</button>
                </div>

            </div>

        </div>

    </section>

    <section class="friendPersonList" id="friendList">
    
    </section>

<form action="" class="modal_form" style="display: none">
<?php if (isset($user) && $user->getId() != $post->getUser()->getId() && count($db->getCommentsByThisUser($post->getUser()->getId(), $user->getId())) == 0):  ?>
<i id="1" class="fas fa-star js-score"></i>
<i id="2" class="far fa-star js-score"></i>
<i id="3" class="far fa-star js-score"></i>
<i id="4" class="far fa-star js-score"></i>
<i id="5" class="far fa-star js-score"></i>
<?php endif;  ?>
<i id="js-mfClose" class="fas fa-times " style="position : absolute; right : 0px; top: 0px; font-size: 20px;"></i>
<?php if (isset($user) && $user->getId() != $post->getUser()->getId()&& count($db->getCommentsByThisUser($post->getUser()->getId(), $user->getId())) == 0):  ?>
<input type="hidden" id="score" value="1">
<br>
<textarea name="comment" id="comment" style="width: 100%" rows="3"></textarea>
<br>
<a href="#" id="js-submit" class="button btn btn-primary">Save</a>
<?php endif;  ?>
<div id = "comments">
<?php if(count($comments) == 0) :?>
    <div class = "row"><div class="col-12 text-center align-middle">No comments yet</div></div>
<?php endif;  ?>
<?php foreach($comments as $comment) :?>
<hr>
<div class = "row">
<div class = "col-3 text-center align-middle my-auto">
<?php $c_User = $db->getUserById($comment["author_id"]); ?>   
<?php if (!is_null($c_User )):  ?>
<img src="<?= $c_User->getPicture();  ?>" style="width: 50px">
<?php else:  ?>
<img src="/res/images/user.svg" style="width: 50px">
<?php endif;  ?>
</div>
<div class = "col-8">
<div class = "row">
<?php if (!is_null($c_User )):  ?>
<?= $c_User->getFname();  ?>
<?= $c_User->getLname();  ?>
<?php else:  ?>
noname
<?php endif;  ?>
</div>
<div class = "row">
<div class="score_star">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php $tmp = (int)$comment["score"] - $i;?>
                    <?php if ($tmp >= 0): ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ($tmp > -1): ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                </div>
</div>
<div class = "row">
<?= $comment["comment"]; ?>
</div>
<div class = "row">
<?= $comment["created_at"]; ?>
</div>
</div>
</div>
    <?php endforeach;?>
</div>
</form>

<?php
 $post_ID = $_GET['id'];
 $isUserInSession = false;
 echo"
 <script>
 let isActiv = false;
 const post_id = $post_ID;
 
  </script>";
 if(isset($_SESSION['email'])){
     $isUserInSession = true;
     echo "
     <script>
     isActiv = $isUserInSession;
     console.log(isActiv);
 
  </script>";
  
 }
 else{
     $isUserInSession = false;
     echo "
     <script>
     isActiv = $isUserInSession;
 
  </script>";
 }

?>

<script>
    
    //#region farsatWorkStarts
            let pName = '';
            let sId;
            let sPic;
            let isSessUser = false;
            isOpen = false;
            let sessionUserName;
            let sessionUserId;
            if (isActiv == 0) {
                $('.main-card-container').hide();
                $('.friend-list').hide();
                $('.friendPersonList').hide();
                console.log("false area");
                $('#chat-btn').hide();
            } else {
                console.log("true area");
                $('.botton-area .hiddenBox2').attr('value', post_id);

                const interestedPersons = document.getElementById('i-list');
                const friendList = document.getElementById('friendList');
                console.log(interestedPersons);
                isPersonalPost();

                let isPersonal = false;

                function isPersonalPost() {
                    let obj = {};
                    obj = {
                        _post_id: post_id
                    };
                    let jsonObj = JSON.stringify(obj);
                    console.log(jsonObj);
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/check-personal-post.api.php"?>",
                        data: jsonObj,
                        success: function(ex) {
                            if (Object.values(ex) == 'true') {
                                console.log(ex);
                                const chatBtn = document.getElementById('chat-btn');
                                chatBtn.innerText = "Show Interested person list."
                                isPersonal = true;
                            } else {
                                console.log(ex);
                                isPersonal = false;
                                fetchUserNameById(jsonObj);
                            }
                        },
                        error: function(e) {
                            alert("new error");
                        }
                    });
                }

                function isSessionUser() {
                    console.log("in session function");
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/check-session-user-api.php"?>",
                        success: function(response) {
                            sessionUserName = response[0]['fname'];
                            console.log(response);
                        },
                        error: function(e) {
                            alert("is session user error");
                        }

                    });
                }

                function fetchBuyerId() {
                    $.ajax({
                        type: "GET",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/fetch-buyer-id-api.php"?>",
                        success: function(data) {
                            console.log(data);
                            openChat(data['id']);
                        }
                    });
                }

                // function one

                function ShowInterestedPersonList() {
                    let obj = {};
                    obj = {
                        _post_id: post_id
                    };
                    let jsonObj = JSON.stringify(obj);
                    console.log(jsonObj);
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/fetch-buyer-by-postId.api.php"?>",
                        data: jsonObj,
                        success: function(data) {
                           if(data.length !== 0){

                            // interestedPersons.innerHTML = "";
                            friendList.innerHTML = "";
                                     const interestedBuyer = document.createElement('ul');
                                    interestedBuyer.setAttribute('class', 'personList');
                                for (let index = 0; index < data.length; index++)
                                {
                                    const list = document.createElement('li');
                                        list.setAttribute('onclick', 'openChat(' + data[index]['id'] + ')');
                                    list.setAttribute('id', data[index]['id']);
                                   
                                    const imgTag = document.createElement('img');
                                    imgTag.setAttribute('src', data[index]['picture']);
                                   
                                    const pTag = document.createElement('p');
                                    pTag.innerText = data[index]['fname'];
                                    list.appendChild(imgTag);
                                    list.appendChild(pTag);
                                    interestedBuyer.appendChild(list);
                            }
                            friendList.appendChild(interestedBuyer);
                           }
                        }
                    });
                }

                $('.main-card-container').hide();
                $('.friend-list').hide();
                 $('.friendPersonList').hide();
                $('#chat-btn').on('click', function() {
                    if (isActiv) {
                        if (!isPersonal) {
                            $('.main-card-container').show('fast');
                              if(isOpen == false){
                                 CreateChat();
                                fetchBuyerId();
                               }
                        } else {
                            console.log("here-list");
                            ShowInterestedPersonList();
                            // $('.friend-list').show('fast');
                             $('.friendPersonList').show();
                        }
                    }
                });

                $('.hide-box').on('click', function() {
                    $('.main-card-container').hide('fast');
                    // $('.friend-list').show('fast');
                     $('.friendPersonList').show();
                    isOpen = false;
                });

                $(".submit-btn").on("click", function() {

                    let values = $(".botton-area input:lt(3)").serializeArray();
                    console.log(values);
                    const message = document.querySelectorAll('#userMessage')[0];
                    message.value = '';
                    if (values.length == 3) {
                        if(values[0].value !== ''){
                            let jsonObj1 = ConvertMessageInToJSONObject(values);
                             console.log(jsonObj1);
                            InsertMessageInDatabase(jsonObj1);
                        }
                        else{
                            // alert("Cant be empty!");
                        }
                    }
                });

                function ConvertMessageInToJSONObject(data) {
                    let obj = {};
                    for (let index = 0; index < data.length; index++) {
                        obj[data[index].name] = data[index].value;
                    }

                    let jsonObj = JSON.stringify(obj);

                    return jsonObj;
                }

                function updateScroll() {
                    var element = document.getElementById("m-area");
                    element.scrollTop = element.scrollHeight;
                }

                function fetchUserNameById(obj) {
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/fetch-user-api.php"?>",
                        data: obj,
                        success: function(message) {
                            console.log(message);
                            pName = message[0]['fname'];
                            sId = message[0]['id'];
                            sPic = message[0]['picture'];
                            sessionUserId = message[0]['id'];
                        },
                        error: function() {
                         alert("fetch username by id error");
                        }
                    });
                }

                function fetchUserById(id) {
                    if(id == null){
                        return;
                    }
                    let obj = {};
                    obj = {
                        userId: id
                    };
                    let jsonObj = JSON.stringify(obj);
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/fetch-user-by-id-api.php"?>",
                        data: jsonObj,
                        success: function(message) {
                            console.log(message);
                            pName = message[0]['fname'];
                            sId = message[0]['id'];
                            sPic = message[0]['picture'];
                        },
                        error: function() {
                             alert("fetch user by id error");
                        }
                    });
                }

                function openChat(id) {
                    isOpen = true;

                    fetchUserById(id);

                    $('.main-card-container').show();
                    $('.friend-list').hide();
                     $('.friendPersonList').hide();
                    $('.botton-area .hiddenBox').attr('value', id);
                    const nameHeader = document.getElementById('nameHeader');
                    const nameHeaderPic = document.getElementById('nameHeaderPic');
                    nameHeader.innerText = pName;
                    if(sPic != null){
                        console.log("Working");
                        nameHeaderPic.setAttribute('src', sPic)
                    }

                    let obj = {};
                    obj = {
                        postId: post_id,
                        userId: id
                    };
                    let jsonObj = JSON.stringify(obj);
                    console.log(jsonObj);
                    showMessages(jsonObj);
                    setTimeout(() => {
                        if (isOpen == true) {
                            openChat(id)
                            updateScroll();
                        }
                    }, 500);
                }

                function showMessages(jsonObj) {
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/fetch-message-api.php"?>",
                        data: jsonObj,
                        success: function(message) {
                            console.log(message);
                            if(message != null)
                                show(message);
                        },
                        error: function() {
                         alert("create chat error");
                        }
                    });
                }

                function show(messages) {
                    const messageArea = document.getElementById('m-area');
                    messageArea.innerHTML = '';
                    for (let index = 0; index < messages.length; index++) {

                        isSessionUser();

                        const myCard = document.createElement('div');
                        myCard.setAttribute('class', 'my-card special');

                        const cardImg = document.createElement('img');
                        cardImg.setAttribute('class', 'card-img-top');
                        console.log("test-start");
                        console.log(messages[index]);
                        console.log(messages[index]['senderPic']);
                        cardImg.setAttribute('src', messages[index]['senderPic']);

                        const cardBody = document.createElement('div');
                        cardBody.setAttribute('class', 'card-body');

                        const cardText = document.createElement('p');
                        cardText.setAttribute('class', 'card-text');
                        cardText.innerText = messages[index]['message'];

                        const cardFooter = document.createElement('div');
                        cardFooter.setAttribute('class', 'footer');

                        const datePara = document.createElement('p');
                        datePara.setAttribute('class', 'message-date');
                        datePara.innerText = messages[index]['timesstamp'];

                        const senderName = document.createElement('p');
                        senderName.setAttribute('class', 'message-sender');
                        senderName.innerText = "sent by " + messages[index]['senderName'];

                        myCard.appendChild(cardImg);
                        myCard.appendChild(cardBody);
                        cardBody.appendChild(cardText);
                        cardBody.appendChild(cardFooter);

                        cardFooter.appendChild(datePara);
                        cardFooter.appendChild(senderName);

                        messageArea.appendChild(myCard);

                        if (sessionUserName === messages[index]['senderName']) {
                            myCard.style.marginLeft = "30px";
                        }

                    }
                }

                function InsertMessageInDatabase(message) {
                    console.log(message);
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/insert-message-api.php"?>",
                        data: message,
                        success: function(response) {
                            console.log(response);
                        },
                        error: function() {
                         alert("error");
                        }
                    });
                }

                function CreateChat() {

                    let obj = {};
                    obj = {
                        _post_id: post_id
                    };
                    console.log("here-create");
                    let jsonObj = JSON.stringify(obj);
                    console.log(jsonObj);
                    $.ajax({
                        type: "POST",
                        url: "<?=$_SESSION["relPath"]."/Backend/Api/insert-friend-api.php"?>",
                        data: jsonObj,
                        success: function(data) {
                            console.log(data);
                        }
                    });
                }
            }
//#endregion farasatWorkEnds
    
    
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
    $(document).ready(function(){
        console.log("jquery is working");
        $(".js-score").on("mouseenter", function(e){
            let score = parseInt(this.id);
            //console.log(score);
            let score_stars = $(".js-score");
            //console.log(score_stars);
            score_stars.map(function(i, el){
                //console.log(el);
                if(parseInt(el.id) <= score){
                    el.classList.add("fas");
                    el.classList.remove("far");
                }
            });
        });
        $(".js-score").on("click", function(e){
            let hidden_score = $("#score");
            hidden_score.val(this.id);
        });
        $("#js-submit").on("click", function(e){
            e.preventDefault();
            let hidden_score = $("#score");
            let comment = $("#comment");
            $.post("/post_comment.php", {
                score : hidden_score.val(), 
                comment : comment.val(),
                user_id : <?= $post->getUser()->getId() ?>,
                author_id : <?= isset($user)?$user->getId(): 0 ?>
            }, function (params) {
                // location.reload();
                let comment_div = $("#comments");
                comment_div.empty();
                comment_div.html(params);
            })
        });
        $(".js-score").on("mouseleave", function(e){
            let hidden_score = $("#score");
            let score_stars = $(".js-score");
            console.log(hidden_score.val());
            score_stars.map(function(i, el){
                //console.log(el);
                if(parseInt(el.id) <= parseInt(hidden_score.val())){
                    el.classList.add("fas");
                    el.classList.remove("far");
                } else {
                    el.classList.add("far");
                    el.classList.remove("fas");
                }
            });
            //this.classList.add("far");
            //this.classList.remove("fas");
        })
        $("#js-favorite").click(function(e){
            e.preventDefault()
            $.get("<?php echo $_SESSION["relPath"] ?>/favorite.php", {
                "advert_id":<?= $post->getId(); ?>
            },function (){
                let star = $("#js-favorite").find("i");
                if (star.hasClass("fas")){
                    star.removeClass("fas");
                    star.addClass("far");
                }
                else {
                    star.removeClass("far");
                    star.addClass("fas");
                }
            })
        })
        $("#js-showcomments").click(function(e){
            e.preventDefault()
            $(".modal_form").show();
        })
        $("#js-mfClose").click(function(){
            $(".modal_form").hide();
        })
    })
</script>
