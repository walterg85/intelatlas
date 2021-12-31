<?php
    @session_start();
    ob_start();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Welcome to chat support!</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="form-check form-switch h5">
            <input class="form-check-input" type="checkbox" id="swActivo">
            <label class="form-check-label swActivo" for="swActivo"> We are active in chat</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="list-group" id="chatList"></div>
        <!-- Item chat to clone  -->
        <a href="javascript:void(0);" class="list-group-item list-group-item-action d-none itemClone itemChatList">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1 cliName">Name</h5>
                <small>
                    <texto class="cliDate text-muted txtm"></texto>
                    <span class="badge rounded-pill bg-warning chatCount d-none">
                        1
                    </span>
                </small>
            </div>
            <p class="mb-1 cliMessage">Message.</p>
            <small class="txtm cliMail text-muted">Mail.</small>
        </a>
    </div>
    <div class="col-8 d-none" id="chatDetails">

        <div class="btn-group ms-2 mb-2" role="group">
            <button type="button" class="btn btn-outline-secondary" id="btnFinalizar"><i class="fa fa-power-off"></i> <text class="btnFinish">Finish chatting</text></button>
            <button type="button" class="btn btn-outline-secondary" id="btnMovechat" disabled="disabled"><i class="fa fa-bookmark-o"></i> <text class="btnMovetoFile">Move to file</text></button>
            <button type="button" class="btn btn-outline-secondary" id="btnFinalizechat"><i class="fa fa-envelope-open-o"></i> <text class="btnSenToMail">Finish and Send by email</text></button>            
        </div>                

        <div id="chatLog" class=""></div>

        <form class="row g-3">
            <div class="col-10">
                <label for="txtMessage" class="form-label labelMesage">New message</label>
                <textarea class="form-control" id="txtMessage" rows="3"></textarea>
            </div>
            <div class="col-2 pt-5">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button" id="btnSend">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var chatActive  = "",
        refreshLog  = null,
        audio       = new Audio(`../assets/sound/bell.wav`);

    $(document).ready(function(){
        currentPage = "chat";
        loadChats();
        setInterval(loadChats, 2500);

        $(document).on("click", ".itemChatList", function(){
            if(refreshLog)
                clearInterval(refreshLog);

            chatActive = {
                _method: "GET",
                _chatid: $(this).data("chatid"),
                _action: "getChat",
                _current: $(this).data("current")
            };

            loadLog();
            refreshLog = setInterval(loadLog, 2500);

            $(".active").find(".txtm").addClass("text-muted");
            $(".active").removeClass("active");

            $(this).addClass("active");
            $(this).find(".txtm").removeClass("text-muted");
        });

        $("#btnSend").on("click", function(){
            sendMessage($("#txtMessage").val());
        });

        $("#btnFinalizar").on("click", function(){
            (async () => {
                const tmpResult = await showConfirmation(`Do you really want to end the chat with ${chatActive._current}?`, "", "Yes");
                if(tmpResult.isConfirmed){
                    $(".active").find(".txtm").addClass("text-muted");
                    $(".active").removeClass("active");

                    clearInterval(refreshLog);

                    $("#chatLog").html("");
                    $("#chatDetails").addClass("d-none");

                    let dt      = new Date(),
                        time    = dt.getHours() + ":" + dt.getMinutes(),
                        objData = {
                            _method: "POST",
                            _action: "closeChat",
                            _time: time,
                            _chatid: chatActive._chatid
                        };

                    $.post("../core/controllers/chatAdmin.php", objData);

                    chatActive._chatid = ""; 
                }
            })()
        });

        $("#btnMovechat").on("click", function(){
            (async () => {
                const tmpResult = await showConfirmation(`Are you sure to move the chat to finished?`, "", "Yes");
                if(tmpResult.isConfirmed){
                    $(".active").find(".txtm").addClass("text-muted");
                    $(".active").removeClass("active");

                    clearInterval(refreshLog);

                    $("#chatLog").html("");
                    $("#chatDetails").addClass("d-none");

                    let dt      = new Date(),
                        time    = dt.getHours() + ":" + dt.getMinutes(),
                        objData = {
                            _method: "POST",
                            _action: "moveChat",
                            _chatid: chatActive._chatid
                        };

                    $.post("../core/controllers/chatAdmin.php", objData);

                    chatActive._chatid = "";
                    $("#btnMovechat").attr("disabled", "disabled");
                }
            })()
        });

        $("#btnFinalizechat").on("click", function(){
            (async () => {
                const tmpResult = await showConfirmation("", `Do you really want to finish the chat with ${chatActive._current} and send the file by email?`, "Yes");
                if(tmpResult.isConfirmed){
                    $(".active").find(".txtm").addClass("text-muted");
                    $(".active").removeClass("active");

                    clearInterval(refreshLog);

                    $("#chatLog").html("");
                    $("#chatDetails").addClass("d-none");

                    let dt      = new Date(),
                        time    = dt.getHours() + ":" + dt.getMinutes(),
                        objData = {
                            _method: "POST",
                            _action: "sendChat",
                            _time: time,
                            _chatid: chatActive._chatid
                        };

                    $.post("../core/controllers/chatAdmin.php", objData);

                    chatActive._chatid = ""; 
                }
            })()
        });

        $("#swActivo").change( function(){
            let valor   = (this.checked) ? 1 : 0,
                objData = {
                    _method: "updateUniqueSetting",
                    parametro: "chat",
                    value: valor
                };

            $.post("../core/controllers/setting.php", objData);
        });

        getConfig();
    });

    function loadChats(){
        let objData = {
            _method: "GET",
            _action: "getList"
        };

        $.post("../core/controllers/chatAdmin.php", objData, function(result) {
            if(result.length > 0){
                $("#chatList").html("");
                $.each( result, function( index, item){
                    let chat    = $(".itemClone").clone(),
                        origin  = JSON.parse(item.origin),
                        geo     = JSON.parse(origin.ip);

                    chat.find(".cliName").html( (origin.name == "no name") ? pad(item.id, 5) : origin.name );
                    chat.find(".cliDate").html(item.registered);
                    chat.find(".cliMessage").html(`Country: ${geo.country}, City: ${geo.city}`);
                    chat.find(".cliMail").html(origin.mail);

                    if(item.estatus == 0)
                        chat.find(".cliName").addClass("text-danger");

                    if(item.unread > 0){
                        chat.find(".chatCount")
                            .removeClass("d-none")
                            .html(item.unread);

                        audio.play();                        
                    }

                    chat.data("chatid", item.id);
                    chat.data("current", (origin.name == "no name") ? pad(item.id, 5) : origin.name + ` - ${geo.ip}`);
                    chat.removeClass("itemClone d-none");

                    if(chatActive._chatid == item.id){
                        $(chat).addClass("active");
                        $(chat).find(".txtm").removeClass("text-muted");
                    }

                    $(chat).appendTo("#chatList");
                });
            }else{
                $("#chatList").html(`<p class="lead">No chats available at the moment</p>`);
            }
        });
    }

    function loadLog() {
        let oldscrollHeight = $("#chatLog")[0].scrollHeight - 20;

        $.post("../core/controllers/chatAdmin.php", chatActive, function(result) {
            console.log(result);
            $("#chatLog").html(result.message);
            $("#chatDetails").removeClass("d-none");

            let newscrollHeight = $("#chatLog")[0].scrollHeight - 20;
            if(newscrollHeight > oldscrollHeight){
                $("#chatLog").animate({ scrollTop: newscrollHeight }, 'normal');
                audio.play();
            }

            if(result.estatus == 0){
                $("#txtMessage").attr("disabled", "disabled");
                $("#btnSend").attr("disabled", "disabled");
                $("#btnMovechat").removeAttr("disabled");
                $("#btnFinalizar").attr("disabled", "disabled");
            }else{
                $("#txtMessage").removeAttr("disabled");
                $("#btnSend").removeAttr("disabled");
                $("#btnMovechat").attr("disabled", "disabled");
                $("#btnFinalizar").removeAttr("disabled");
            }
        });
    }

    function sendMessage(strMessage){
        let dt      = new Date(),
            time    = dt.getHours() + ":" + dt.getMinutes(),
            objData = {
                message: strMessage,
                _method: "POST",
                _time: time,
                _chatid: chatActive._chatid,
                _action: "responseChat",
            };

        $.post("../core/controllers/chatAdmin.php", objData, function(){
            loadChats();
            $("#txtMessage").val("");
        });
        
        return false;
    }

    function changePageLang(myLang){
        $(".lblNamePage").html(myLang.pageTitle);
        $(".btnFinish").html(myLang.btnFinish);
        $(".btnMovetoFile").html(myLang.btnMovetoFile);
        $(".btnSenToMail").html(myLang.btnSenToMail);
        $(".labelMesage").html(myLang.labelMesage);
        $("#btnSend").html(myLang.btnSend);  
    }

    function getConfig(){
        let objData = {
            _method: "getUnique",
            parametro: "chat"
        };

        $.post("../core/controllers/setting.php", objData, function(result){
            if(result.data){
                let estado = (result.data.value == 1) ? true : false;
                $("#swActivo").prop("checked", estado);
            }else{
                $("#swActivo").prop("checked", false);
            }
        });
    }
</script>
<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>