<style>
    .main-chat-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        border: 1px solid black;
        width: 100%;
        height: 80vh;
        font-family: cursive;
        background-color: rgb(247, 252, 252);
    }

    .header-container {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        width: 100%;
        height: 25%;
        margin: 1px;
    }

    .header-one {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        width: 35%;
        height: 90%;
        margin: 0px 0px 0px 2px;
    }

    .header-one p {
        font-size: 100%;
        color: rgb(70, 189, 245);
        font-weight: bold;
    }

    .header-two {
        display: flex;
        position: relative;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        border: 1px solid black;
        width: 65%;
        height: 90%;
        margin: 0px 2px 0px 0px;
    }

    .middle-container {
        display: flex;
        align-items: center;
        border: 1px solid black;
        width: 100%;
        height: 73%;
        margin: 0px 2px 0px 2px;
    }

    .person-list {
        width: 35%;
        height: 96%;
        margin: 0px 0px 0px 2px;
        overflow-y: scroll;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        border: 1px solid black;
    }

    .person {
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        width: 100%;
        border: 1px solid black;
        height: 25%;
        margin: 0px 0px 0px 0px;
        margin-bottom: 3px;
    }

    .message-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: 4px solid black;
        width: 65%;
        height: 96%;
        margin: 0px 2px 0px 0px;
    }

    .message-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        height: 85%;
        overflow-y: scroll;
    }

    .header-two img {
        width: 50%;
        height: 50%;
        margin: 0px 0px 0px 0px;
    }

    .header-two p {
        margin: 0px 0px 0px 10px;
    }

    .person img {
        width: 20%;
        height: 50%;
        border-radius: 50%;
    }

    .person p {
        text-align: center;
    }

    .person:hover {
        cursor: pointer;
        color: lightblue;
    }

    .person-message {
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
        height: 75%;
        margin-top: 10px;
    }

    .input-box {
        border: 1px solid black;
        height: 15%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-around;
        margin: 0px 0px 0px 0px;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card p {
        margin: 2px;
        font-family: cursive;
        font-size: 12px;
    }

    .footer p {
        margin: 2px;
        font-family: cursive;
        font-size: 10px;
        font-weight: bold;
        border: 1px solid rgb(106, 131, 141);
    }

    .card {
        width: 50%;
        display: flex;
        margin-bottom: 10px;
        margin-left: 5%
    }

    .card-body {
        border: 1px solid rgb(245, 209, 166);
        margin: 5px;
    }

    .card .card-body .messCardFooter {
        display: flex;
        justify-content: space-between;
    }

    .card img {
        width: 10%;
        height: 2rem;
        border-radius: 50%;
    }

    .input-area {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid black;
        width: 99%;
        height: 20%;
    }

    .input-area input {
        width: 75%;
        height: 90%;
    }

    .input-area button {
        width: 25%;
        height: 96%;
    }
</style>

<body>
    <div class="main-chat-container">
        <div class="header-container">
            <div class="header-one">
                <p>Nachrichten</p>
            </div>
            <div class="header-two" id="h-2">
                <p id="h-name"></p>
                <img id="h-pic" style="border-radius: 50%; width: 15%;">
            </div>
        </div>

        <div class="middle-container">

            <div class="person-list " id="fList">
            </div>

            <div class="message-area" id="m-area">

                <div class="person-message" id="pMessage">

                </div>

                <div class="input-area">
                    <input type="text" name="message" id="userMessage" placeholder="message">
                    <input class="hiddenBox" id="hIBox1" type="hidden" name="post_id">
                    <input class="hiddenBox" id="hIBox2" type="hidden" name="f_id">
                    <button class="btn btn-primary submit-btn">Send</button>
                </div>

            </div>

        </div>
    </div>

</body>
<script>
    document.body.className = 'js';
</script>

<script>
    fetchAllChatData();
    let isNewMessageInserted = true;
    let friendId = 0;

    // new
    function fetchAllChatData() {
        $.ajax({
            type: "GET",
            url: "<?=$_SESSION["relPath"]."/Backend/Api/pChatApi/test-api.php"?>",
            // url: "http://localhost/EOF_Latest_Version/Backend/Api/pChatApi/test-api.php",
            success: function(response) {
                console.log(response);
                CreateNewList(response);
            },
            error: function(e) {
                alert("error1");
            }
        });
    }

    // new
    function showHeader(name, pic) {
        const pTag = document.getElementById('h-name');
        pTag.innerText = name;
        const pImg = document.getElementById('h-pic');
        pImg.setAttribute('src', pic);
    }

    $(".submit-btn").on("click", function() {

        let values = $(".input-area input:lt(3)").serializeArray();
        console.log(values);
        const message = document.querySelectorAll('#userMessage')[0];
        message.value = '';
        if (values.length == 3) {
           if(values[0].value !== ''){
            let jsonObj = ConvertMessageInToJSONObject(values);
            console.log(jsonObj);
            InsertMessage(jsonObj)
           }
           else{
            //    alert("Cant be empty");
           }
        }
    });

    //new
    function ConvertMessageInToJSONObject(data) {
        let obj = {};
        for (let index = 0; index < data.length; index++) {
            obj[data[index].name] = data[index].value;
        }

        let jsonObj = JSON.stringify(obj);

        return jsonObj;
    }

    // new 
    function InsertMessage(jsonObj) {
        $.ajax({
            type: "POST",
            data: jsonObj,
            url: "<?=$_SESSION["relPath"]."/Backend/Api/pChatApi/insertMessage-api.php"?>",
            success: function(response) {
                let obj = {
                fId: friendId
                };

                let jsonObj = JSON.stringify(obj);

               fetchChatMessage(jsonObj);
            },
            error: function(e) {
                alert("error2");
            }
        });
    }

    let length = 0;
    // new 
    function showChat(f_id, post_id) {
        isOpen = true;

        if(friendId !== f_id){
        friendId = f_id;
      }

        var element = document.getElementById("pMessage");
        element.innerHTML = '';

        const hIPostId = document.getElementById('hIBox1');
        hIPostId.value = post_id;
        const hfId = document.getElementById('hIBox2');
        hfId.value = f_id;

        let obj = {
            fId: f_id
        };
        let jsonObj = JSON.stringify(obj);
        console.log(jsonObj);
        console.log(isOpen);
        fetchChatMessage(jsonObj);
              console.log("here");
    }

    function fetchChatMessage(jsonObj) {
        isOpen = true;
        $.ajax({
            type: "POST",
            data: jsonObj,
            url: "<?=$_SESSION["relPath"]."/Backend/Api/pChatApi/fetchMessage-api.php"?>",
            //url: "http://localhost/EOF_Latest_Version/Backend/Api/pChatApi/fetchMessage-api.php",
            success: function(response) {
                length = response.length;
                    show(response);
            },
            error: function(e) {
                alert("error3");
            }
        });
    }

    function updateScroll() {
        var element = document.getElementById("pMessage");
        element.scrollTop = element.scrollHeight;
    }

    // new
    function show(messages) {
        console.log(messages);
        const messageContainer = document.getElementById('pMessage');
        messageContainer.innerHTML = "";

        $.ajax({
            type: "GET",
            url: "<?=$_SESSION["relPath"]."/Backend/Api/pChatApi/api-test.php"?>",
            // url: "http://localhost/EOF_Latest_Version/Backend/Api/pChatApi/api-test.php",
            success: function(response) {
                console.log("checking");
                console.log(response);
                for (let index = 0; index < messages.length; index++) {

                    const messageCard = document.createElement('div');
                    messageCard.setAttribute('class', 'card');

                    const imgTag = document.createElement('img');
                    imgTag.setAttribute('class', 'card-img-top');
                    imgTag.setAttribute('src',messages[index]['senderPic']);

                    const messageCardBody = document.createElement('div');
                    messageCardBody.setAttribute('class', 'card-body');

                    const pTag = document.createElement('p');
                    pTag.setAttribute('class', 'card-text');
                    pTag.innerText = messages[index]['message'];


                    const messageCardFooter = document.createElement('div');
                    messageCardFooter.setAttribute('class', 'messCardFooter');
                    const dataPTag = document.createElement('p');
                    dataPTag.setAttribute('class', 'message-date');
                    dataPTag.innerText = messages[index]['timesstamp'];
                    const senderPTag = document.createElement('p');
                    senderPTag.setAttribute('class', 'message-sender');
                    senderPTag.innerText = "sent by " + messages[index]['senderName'];

                    messageCardFooter.appendChild(dataPTag);
                    messageCardFooter.appendChild(senderPTag)

                    messageCardBody.appendChild(pTag)
                    messageCardBody.appendChild(messageCardFooter)

                    messageCard.appendChild(imgTag);
                    messageCard.appendChild(messageCardBody);

                    if (response[0]['fname'] === messages[index]['senderName']) {
                        messageCard.style.marginLeft = "45%";
                    }

                    messageContainer.appendChild(messageCard);
                }
            },
            error: function(e) {
                alert("error");
            }
        });
    }

    // new
    function CreateNewList(data) {
        let chatData = new Array();
        const personListContainer = document.getElementById('fList');
        for (let index = 0; index < data.length; index++) {
            const friend = document.createElement('div');
            friend.setAttribute('class', 'person');
            let name = data[index]['headerName'];
            friend.setAttribute('id', data[index]['postId']);
            const fId = data[index]['fId'];
            const postId = data[index]['postId'];
            const headerUserPic = data[index]['headerUserPic'];
            friend.setAttribute('onclick', 'showHeader(\'' + name + '\', \'' + headerUserPic + '\');');
            friend.addEventListener("click", function() {
                showChat(fId, postId);
            });
            const pTag = document.createElement('p');
            pTag.innerText = data[index]['title'];
            const imgTag = document.createElement('img');
            imgTag.setAttribute('src', "pictures/Adds/" + data[index]['postId'] + "/full/0.png");
            friend.appendChild(pTag);
            friend.appendChild(imgTag);
            const hiddenBox = document.createElement('input');
            personListContainer.appendChild(friend);
        }
    }
</script>
