<?php
    @session_start();
    ob_start();
?>
<!-- cropperCSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" integrity="sha512-w+u2vZqMNUVngx+0GVZYM21Qm093kAexjueWOv9e9nIeYJb1iEfiHC7Y+VvmP/tviQyA5IR32mwN/5hTEJx6Ng==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- cropperJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js" integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Settings</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-secondary" id="btnUpdateData"><i class="bi bi-check2"></i> Save changes</button>
        </div>
    </div>
</div>

<form id="configForm" class="needs-validation" novalidate>
    <div class="row">
        <div class="col-3">
            <center>
                <figure class="figure">
                    <img src="../assets/img/logo.png" class="figure-img img-fluid rounded imgPreview">
                    <figcaption class="figure-caption labelCaption">Change your logo</figcaption>
                </figure>
            </center>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputPhoto"><i class="bi bi-camera"></i></label>
                <input type="file" class="form-control" id="inputPhoto">
            </div>
        </div>
        <div class="col-9">
            <div class="row g-3">
                <div class="col-3">
                    <label for="inputshipingCost" class="form-label lblShipCost">Shipping Cost</label>
                    <input type="text" class="form-control" placeholder="Shipping Cost" aria-label="Shipping Cost" id="inputshipingCost" required>
                </div>
                <div class="col-3">
                    <label for="inputshipingFree" class="form-label lblShipFree">Free Shipping</label>
                    <input type="text" class="form-control" placeholder="Free Shipping" aria-label="Free Shipping" id="inputshipingFree" required>
                </div>
                <div class="col-3">
                    <label for="inputtax" class="form-label lblTax">Tax</label>
                    <input type="text" class="form-control" placeholder="Tax" aria-label="Tax" id="inputtax" required>
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-3">
                    <label for="inputUname" class="form-label lblUname">User name</label>
                    <input type="text" class="form-control" placeholder="User name" aria-label="User name" id="inputUname" readonly value="<?php echo $_SESSION['authData']->owner; ?>" required>
                </div>
                <div class="col-4">
                    <label for="inputMail" class="form-label lblEmail">Email</label>
                    <input type="mail" class="form-control" placeholder="Enter a email" aria-label="Enter a email" id="inputMail" value="<?php echo $_SESSION['authData']->email; ?>" required>
                </div>
                <div class="col-3">
                    <label for="inputPass" class="form-label lblPassword">Change Password</label>
                    <input type="password" class="form-control" placeholder="New Password" aria-label="New Password" id="inputPass">
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-6">
                    <label for="inputpaypalid" class="form-label lblApiKey">Paypal cliente ID</label>
                    <input type="text" class="form-control" placeholder="Client ID" id="inputpaypalid" value="" required>
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-6">
                    <div class="row">
                        <p class="lead">Display products on the carousel</p>
                        <div class=" col-9 mb-3">
                            <label for="productList" class="form-label labelDatalist">Product</label>
                            <input class="form-control" list="datalistOptions" id="productList" name="productList" placeholder="Type to search...">
                            <datalist id="datalistOptions"></datalist>
                        </div>
                        <div class="col-3">
                            <div class="d-grid gap-2 pt-4">
                                <button class="btn btn-outline-success" id="btnAdd" type="button">Add</button>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th class="labelControl2" scope="col">Product</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tblProductos"></tbody>
                            </table>
                        </div>
                   </div>
                </div>
                <div class="col-6">
                   <div class="row">
                        <p class="lead">System user management</p>
                        <div class="col-12 mb-3">
                            <div class="d-grid gap-2 pt-4">
                                <button class="btn btn-outline-success" id="btnAddUser" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUser">Add user</button>
                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th class="" scope="col">User</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tblUser"></tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
        </div>        
    </div>
</form>

<!-- Modal para editar las imagenes -->
<div class="modal fade" id="modalCrop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Edit / Crop the photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container mb-3" style="max-height: 500px">
                    <img id="previewCrop" src="#">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary labelButonC" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="cropImage">Apply</button>
            </div>
        </div>
    </div>
</div>

<!-- Panel lateral para agregar cuenta de usuario -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUser" aria-labelledby="offcanvasWithBackdropLabel"  >
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Add a new user</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="frmNewuser" class="needs-validation-userform" novalidate>
            <div class="row">
                <!-- <div class="col-12 mb-3">
                    <label for="inputName" class="form-label labelName">Owner</label>
                    <input type="text" id="inputName" name="inputName" class="form-control" autocomplete="off" maxlength="250" required>
                </div> -->
                <div class="col mb-3">
                    <label for="inputUserName" class="form-label inputUserName">Username</label>
                    <input type="text" id="inputUserName" name="inputUserName" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
                <div class="col mb-3">
                    <label for="inputUserPassword" class="form-label inputUserPassword">Password</label>
                    <input type="password" id="inputUserPassword" name="inputUserPassword" class="form-control" autocomplete="off" maxlength="50" required>
                </div>
            </div>

            <div class="row">
                <p class="lead">Permissions for this user account</p>
                <div class="col">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoCat">
                        <label class="form-check-label swPermisoCat" for="swPermisoCat"> Manage Categories</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoProd">
                        <label class="form-check-label swPermisoProd" for="swPermisoProd"> Manage Products</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoCoup">
                        <label class="form-check-label swPermisoCoup" for="swPermisoCoup"> Manage Coupons</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoOrder">
                        <label class="form-check-label swPermisoOrder" for="swPermisoOrder"> Manage Orders</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoClient">
                        <label class="form-check-label swPermisoClient" for="swPermisoClient"> Manage Clients</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoLeads">
                        <label class="form-check-label swPermisoLeads" for="swPermisoLeads"> Manage Leads</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoInvoice">
                        <label class="form-check-label swPermisoInvoice" for="swPermisoInvoice"> Manage Invoice</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoChat">
                        <label class="form-check-label swPermisoChat" for="swPermisoChat"> Manage Chat</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoSett">
                        <label class="form-check-label swPermisoSett" for="swPermisoSett"> Manage Settings</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="swPermisoReport">
                        <label class="form-check-label swPermisoReport" for="swPermisoReport"> Manage Reports</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 my-5">
                <button class="btn btn-success btn-lg" type="button" id="addNewUser">
                    <i class="bi bi-check2"></i> Register user
                </button>

                <button class="btn btn-success btn-lg d-none" type="button" id="btnUpdateUser">
                    <i class="bi bi-check2"></i> Update user information
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var confButonText = "",
        strMesage = "",
        maxCroppedWidth     = 400,
        maxCroppedHeight    = 400,
        settingPhoto        = null,
        currentProduct      = 0,
        arrayProductos      = [],
        tempProductos       = null,
        userSelected        = 0;

    $(document).ready(function(){
        currentPage = "Settings";

        $("#btnUpdateData").click( fnUpdateData);

        // Iniciar componentes del cropper js
        initComponent();

        loadProducts();

        // Mostrar todos los usuario
        fngetUser();

        $("#btnAdd").click( addProduct);

        $("#addNewUser").click( addNewUser);

        $("#btnAddUser").click( function(){
            $("#btnUpdateUser").addClass("d-none");
            $("#addNewUser").removeClass("d-none");
            $("#inputUserPassword").attr("required", "required");
            $("#frmNewuser")[0].reset();
        });

        $("#btnUpdateUser").click( fnUpdateUser);
    });

    // Metodo para cargar la lista de productos
    function loadProducts(){
        let objData = {
            "_method":"GET",
            "limite": 0,
            "categoria": ""
        };

        $.post("../core/controllers/product.php", objData, function(result) {
            $("#datalistOptions").html("");
            tempProductos = result.data;
            let options = "";
            $.each( result.data, function(index, item){
                options += `<option data-id="${item.id}" value="${item.name.toUpperCase()}">`;
            });

            $("#datalistOptions").html(options);

            $("input[name='productList']").on('input', function(e){
                let option      = $('datalist').find('option[value="'+this.value+'"]');
                currentProduct  = (option.data("id")) ? option.data("id") : 0;
            });
        }).done( fnGetconfig);
    }

    // Metodo para agregar nuevos productos al areglo
    function addProduct(){
        if(currentProduct != 0){
            arrayProductos.push(currentProduct);
            listarProductos();

            $("#productList").val("");
            $("#productList").focus();
        }else{
            showAlert("info", "You must choose a valid product");
        }
    }

    // Metodo para dibujar en la tabla los productos agregados
    function listarProductos(){
        let filas = "";
        currentProduct = 0;

        $("#tblProductos").html("");

        // Se recore el contenido del array de conceptos
        $.each(arrayProductos, function(index, item){
            let producto = "";
            $.each( tempProductos, function(i, p){
                if(item == p.id){
                    producto = p.name.toUpperCase();
                    return false;
                }
            });

            filas += `
                <tr>
                    <td>${index +1}</td>
                    <td>${producto}</td>
                    <td class="text-center">
                        <a href="javascript:void(0);" data-index="${index}" class="btn btn-outline-danger btn-sm btnDelete" title="Delete"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            `;
        });

        // Se agrega el contenido del HTML en el body de la tabla contenedora
        $("#tblProductos").append(filas);


        // Accion del boton para eliminar un elemento del array y redibujar la tabla
        $(".btnDelete").unbind().click( function(){
            let index = $(this).data("index");
            arrayProductos.splice(index, 1);
            listarProductos();
        });
    }

    function fnGetconfig(){
        let objData = {
            "_method":"Get"
        };
        $.post("../core/controllers/setting.php", objData, function(result) {
             $.each( result.data, function( index, item){
                if(item.parameter == 'prodcarousel'){
                    arrayProductos = JSON.parse(item.value);
                    listarProductos();
                }else{
                    $(`#input${item.parameter}`).val(item.value);
                }                
             });
        });
    }

    function fnUpdateData(){
        let forms = document.querySelectorAll('.needs-validation'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity()) {
                    continuar = false;
            }

            formv.classList.add('was-validated');
        });

        if(!continuar)
            return false;
        
        $("#btnUpdateData").attr("disabled","disabled");
        $("#btnUpdateData").html('<i class="bi bi-clock-history"></i> Updating');

        let form = $("#configForm")[0],
            formData = new FormData(form);

        formData.append("_method", "updateData");
        formData.append("shipingCost", $("#inputshipingCost").val());
        formData.append("shipingFree", $("#inputshipingFree").val());
        formData.append("owner", $("#inputUname").val());
        formData.append("email", $("#inputMail").val());
        formData.append("password", $("#inputPass").val());
        formData.append("tax", $("#inputtax").val());
        formData.append("paypalid", $("#inputpaypalid").val());
        formData.append("prodcarousel", JSON.stringify(arrayProductos));

        if(settingPhoto)
            formData.append("settingPhoto", settingPhoto, `logo.png`);

        $.ajax({
            url: '../core/controllers/setting.php',
            data: formData,
            type: 'POST',
            success: function(response){
                showAlert("success", strMesage);
                isNew = <?php echo $_SESSION['authData']->isDefault; ?>;

                $("#btnUpdateData").removeAttr("disabled");
                $("#btnUpdateData").html('<i class="bi bi-check2"></i> ' + confButonText);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function initComponent() {
        // Controlar tipo de objeto que intentan subir
        $('input[type="file"]').unbind().change( function(){
            let ext = $( this ).val().split('.').pop();

            if ($( this ).val() != ''){
                if($.inArray(ext, ["jpg", "jpeg", "png", "bmp", "raw", "tiff"]) != -1){
                    if($(this)[0].files[0].size > 5242880){
                        $( this ).val('');
                        showAlert("warning", 'Your selected file is larger than 5MB');
                    }
                }else{
                    $( this ).val('');
                    showAlert("warning", `${ext} files not allowed, only images`);
                }
            }
        });

        // Image Cropper
        let picture = $(".imgPreview"),
            image       = $("#previewCrop")[0],
            inputFile1   = $("#inputPhoto")[0],
            $modal      = $('#modalCrop'),
            cropper     = null;

        inputFile1.addEventListener("change", function(e){
            let files = e.target.files,
                done  = function (url){
                    inputFile1.value = "";
                    image.src = url;
                    $modal.modal('show');
                },
                reader,
                file,
                url;

            if (files && files.length > 0){
                file = files[0];

                if (URL){
                    done(URL.createObjectURL(file));
                }
                else if (FileReader){
                    reader = new FileReader();
                    reader.onload = function(e){
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.unbind().on('shown.bs.modal', function(){
            let URL         = window.URL || window.webkitURL,
                container   = document.querySelector('.img-container'),
                download    = document.getElementById('download'),
                actions     = document.getElementById('cropper-buttons'),
                options     = {
                    viewMode: 1,
                    aspectRatio: maxCroppedWidth / maxCroppedHeight,
                    background: false
                };

            cropper = new Cropper(image, options);
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $("#cropImage").unbind().click( function(){
            let canvas;

            $modal.modal("hide");

            if(cropper){
                canvas = cropper.getCroppedCanvas({
                    width: maxCroppedWidth,
                    height: maxCroppedHeight,
                });

                picture
                    .attr("src", canvas.toDataURL())
                    .parent().removeClass('d-none');

                canvas.toBlob(function (blob){
                    settingPhoto = blob;
                });
            }
        });
    }

    function changePageLang(myLang){
        $(".lblNamePage").html(myLang.namePage);
        $("#btnUpdateData").html(`<i class="bi bi-check2"></i> ${myLang.butonText}`);
        confButonText = myLang.butonText;
        $(".lblShipCost").html(myLang.labelShipCost);
        $(".lblShipFree").html(myLang.labelShipFree);
        $(".lblTax").html(myLang.labelTax);
        $(".lblUname").html(myLang.labelUname);
        $(".lblEmail").html(myLang.labelEmail);
        $(".lblPassword").html(myLang.labelPassword);
        $(".lblApiKey").html(myLang.lblApiKey);
        $("#inputpaypalid").attr("placeholder", myLang.inputApiKey);

        $("#inputshipingCost").attr("placeholder", myLang.labelShipCost);
        $("#inputshipingFree").attr("placeholder", myLang.labelShipFree);
        $("#inputtax").attr("placeholder", myLang.labelTax);
        $("#inputMail").attr("placeholder", myLang.labelEmail);
        $("#inputPass").attr("placeholder", myLang.labelPassword);

        strMesage = myLang.ctrMessage;
    }

    // Metodo para crear una cuenta de usuario
    function addNewUser(){
        let forms = document.querySelectorAll('.needs-validation-userform'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity())
                continuar = false;

            formv.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        let permisos = {};

        permisos.categoria      = ($("#swPermisoCat").is(':checked')) ? 1 : 0;
        permisos.productos      = ($("#swPermisoProd").is(':checked')) ? 1 : 0;
        permisos.cupones        = ($("#swPermisoCoup").is(':checked')) ? 1 : 0;
        permisos.ordenes        = ($("#swPermisoOrder").is(':checked')) ? 1 : 0;
        permisos.clientes       = ($("#swPermisoClient").is(':checked')) ? 1 : 0;
        permisos.prospectos     = ($("#swPermisoLeads").is(':checked')) ? 1 : 0;
        permisos.facturas       = ($("#swPermisoInvoice").is(':checked')) ? 1 : 0;
        permisos.chat           = ($("#swPermisoChat").is(':checked')) ? 1 : 0;
        permisos.configuracion  = ($("#swPermisoSett").is(':checked')) ? 1 : 0;
        permisos.reportes       = ($("#swPermisoReport").is(':checked')) ? 1 : 0;

        let _Data = {
            "_method": "createUser",
            "owner": $("#inputUserName").val(),
            "password": $("#inputUserPassword").val(),
            "roles": JSON.stringify(permisos)
        };

        $.post("../core/controllers/user.php", _Data, function(){
            showAlert("success", "Registered user account");
            $("#frmNewuser").removeClass("was-validated");
            $("#frmNewuser")[0].reset();
            $("#btnAddUser").click();

            fngetUser();
        });
    }

    // Metodo para listar todos los usuarios
    function fngetUser(){
        let _Data = {
            "_method": "getUser"
        },
        filas = "";

        $("#tblUser").html("");
        $.post("../core/controllers/user.php", _Data, function(result){
            // Se recore el contenido del array para listar todos los usuarios
            $.each(result.data, function(index, item){
                let roles = item.roles.replace(/\"/g, "'");

                filas += `
                    <tr>
                        <td>${index +1}</td>
                        <td>${item.owner}</td>
                        <td class="text-center">
                            <a href="javascript:void(0);" data-id="${item.id}" class="btn btn-outline-danger btn-sm btnDeleteUser" title="Delete"><i class="bi bi-trash"></i></a>
                            <a href="javascript:void(0);" data-id="${item.id}" data-roles="${roles}" data-owner="${item.owner}" class="btn btn-outline-warning btn-sm btnModifyUser" title="Modify"><i class="bi bi-eye-fill"></i></a>
                        </td>
                    </tr>
                `;
            });

            // Se agrega el contenido del HTML en el body de la tabla contenedora
            $("#tblUser").append(filas);

            // Accion del boton para eliminar un usuario del sistema
            $(".btnDeleteUser").unbind().click( function(){
                let _Data = {
                    "_method": "deleteUser",
                    "userId": $(this).data("id")
                };

                $.post("../core/controllers/user.php", _Data, function(){
                    showAlert("success", "User account has been deleted");
                    fngetUser();
                });

            });

            // Accion del boton para editar un usuario del sistema
            $(".btnModifyUser").unbind().click( function(){
                $("#frmNewuser").removeClass("was-validated");
                $("#frmNewuser")[0].reset();
                $("#btnAddUser").click();
                $("#inputUserPassword").removeAttr("required");

                $("#btnUpdateUser").removeClass("d-none");
                $("#addNewUser").addClass("d-none");

                let permisos    = JSON.parse($(this).data("roles").replace(/\'/g, '"')),
                    owner       = $(this).data("owner");

                userSelected    = $(this).data("id");

                $("#inputUserName").val(owner);

                if(permisos.categoria == 1)
                    $("#swPermisoCat").prop("checked", true);

                if(permisos.productos == 1)
                    $("#swPermisoProd").prop("checked", true);

                if(permisos.cupones == 1)
                    $("#swPermisoCoup").prop("checked", true);

                if(permisos.ordenes == 1)
                    $("#swPermisoOrder").prop("checked", true);

                if(permisos.clientes == 1)
                    $("#swPermisoClient").prop("checked", true);

                if(permisos.prospectos == 1)
                    $("#swPermisoLeads").prop("checked", true);

                if(permisos.facturas == 1)
                    $("#swPermisoInvoice").prop("checked", true);

                if(permisos.chat == 1)
                    $("#swPermisoChat").prop("checked", true);

                if(permisos.configuracion == 1)
                    $("#swPermisoSett").prop("checked", true);

                if(permisos.reportes == 1)
                    $("#swPermisoReport").prop("checked", true);
            });
        });
    }

    // Metodo para actualizar un usuario
    function fnUpdateUser(){
        let forms = document.querySelectorAll('.needs-validation-userform'),
            continuar = true;

        Array.prototype.slice.call(forms).forEach(function (formv){ 
            if (!formv.checkValidity())
                continuar = false;

            formv.classList.add('was-validated');
        });

        if(!continuar)
            return false;

        let permisos = {};

        permisos.categoria      = ($("#swPermisoCat").is(':checked')) ? 1 : 0;
        permisos.productos      = ($("#swPermisoProd").is(':checked')) ? 1 : 0;
        permisos.cupones        = ($("#swPermisoCoup").is(':checked')) ? 1 : 0;
        permisos.ordenes        = ($("#swPermisoOrder").is(':checked')) ? 1 : 0;
        permisos.clientes       = ($("#swPermisoClient").is(':checked')) ? 1 : 0;
        permisos.prospectos     = ($("#swPermisoLeads").is(':checked')) ? 1 : 0;
        permisos.facturas       = ($("#swPermisoInvoice").is(':checked')) ? 1 : 0;
        permisos.chat           = ($("#swPermisoChat").is(':checked')) ? 1 : 0;
        permisos.configuracion  = ($("#swPermisoSett").is(':checked')) ? 1 : 0;
        permisos.reportes       = ($("#swPermisoReport").is(':checked')) ? 1 : 0;

        let _Data = {
            "_method": "updateUser",
            "userId": userSelected,
            "owner": $("#inputUserName").val(),
            "password": $("#inputUserPassword").val(),
            "roles": JSON.stringify(permisos)
        };

        $.post("../core/controllers/user.php", _Data, function(){
            showAlert("success", "Update user account");
            $("#frmNewuser").removeClass("was-validated");
            $("#frmNewuser")[0].reset();
            $("#btnAddUser").click();

            fngetUser();
        });
    }
</script>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>