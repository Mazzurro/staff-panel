<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="staff-planning-editor" data-id="<?php echo($_POST['staffID']);?>">
    <div class="box">
        <div class="box-head">
            <h4>Edit An Staff Planning</h4>
            <div class="box-head-alt">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="box-content" >
            <div class="box-list box-list-small">
                <h6>Product Name:</h6>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_product">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_product">Pick a Product</dropdown-current>
                            <input type="hidden" name="product_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_product">
                        </dropdown-options>
                    </dropdown>
                </div>
                <div class='newItem box-list-item input-item' style='display:none'>
                    <input type="text" name='newProduct' class='newProduct' placeholder='New Product Name'>
                    <button class='addNew cancelNew'>X</button>
                    <button class='addNew submitNew newP'>Submit</button>
                </div>
                <button class='addNew showNew'>New Product</button>
            </div>
            <div class="box-list box-list-small">
                <h6>Capability:</h6>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_capability">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_capability">Pick A Capability</dropdown-current>
                            <input type="hidden" name="capability_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_capability">
                        </dropdown-options>
                    </dropdown>
                </div>
                <div class='newItem box-list-item input-item' style='display:none'>
                    <input type="text" name='newCapability' class='newCapability' placeholder='New Capability Name'>
                    <button class='addNew cancelNew'>X</button>
                    <button class='addNew submitNew newC'>Submit</button>
                </div>
                <button class='addNew showNew'>New Capability</button>
            </div>
            <div class="box-list box-list-small">
                <h5>Service:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_service">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_service">Pick a Service</dropdown-current>
                            <input type="hidden" name="service_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_service">
                        </dropdown-options>
                    </dropdown>
                </div>
                <div class='newItem box-list-item input-item' style='display:none'>
                    <input type="text" name='newService' class='newService' placeholder='New Service Name'>
                    <button class='addNew cancelNew'>X</button>
                    <button class='addNew submitNew newS'>Submit</button>
                </div>
                <button class='addNew showNew'>New Service</button>
            </div>
            <div class="box-list box-list-small">
                <h5>Department:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_department">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_department">Pick a Department</dropdown-current>
                            <input type="hidden" name="department_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_department">
                        </dropdown-options>
                    </dropdown>
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Role:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_role">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_role">Pick a Role</dropdown-current>
                            <input type="hidden" name="role_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_role">
                        </dropdown-options>
                    </dropdown>
                </div>
                <div class='newItem box-list-item input-item' style='display:none'>
                    <input type="text" name='newRole' class='newRole' placeholder='New Role'>
                    <button class='addNew cancelNew'>X</button>
                    <button class='addNew submitNew newR'>Submit</button>
                </div>
                <button class='addNew showNew'>New Role</button>
            </div>
            <div class="box-list box-list-small">
                <h5>Located in:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_location">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_location">Pick a Location</dropdown-current>
                            <input type="hidden" name="location_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_location">
                        </dropdown-options>
                    </dropdown>
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>First Name of the Staff:</h5>
                <div class="box-list-item input-item">
                    <input type="text" name="first_name">
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Middle Name of the Staff:</h5>
                <div class="box-list-item input-item">
                    <input type="text" name="middle_name">
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Last Name of the Staff:</h5>
                <div class="box-list-item input-item">
                    <input type="text" name="last_name">
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Location Manager:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_lManager">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_lManager">Pick a Location Manager</dropdown-current>
                            <input type="hidden" name="lManager_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_lManager">
                        </dropdown-options>
                    </dropdown>
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Functional Manager:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_fManager">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_fManager">Pick a Functional Manager</dropdown-current>
                            <input type="hidden" name="fManager_id">
                        </dropdown-head>
                        <dropdown-options class="dropdown_item_fManager">
                        </dropdown-options>
                    </dropdown>
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Join Date:</h5>
                <div class="box-list-item input-item">
                    <input type="date" name="join_date">
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Ending Date:</h5>
                <div class="box-list-item input-item">
                    <input type="date" name="ending_date">
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Run Rate:</h5>
                <div class="box-list-item input-item" style="color: #ad9440;">
                    <dropdown id="dropdown_rR">
                        <dropdown-head>
                            <dropdown-current class="dropdown-current_rR">Select an Appropriate Run Rate</dropdown-current>
                            <input type="hidden" name="rR_id">
                        </dropdown-head>
                        <!-- <dropdown-options class="dropdown_item_country"> 
                        </dropdown-options> -->
                        <dropdown-options class="dropdown_item_rR">
                            <dropdown-options-item class="dropdown-options-item-rR" data-id="1">Volunteer</dropdown-options-item>
                            <dropdown-options-item class="dropdown-options-item-rR" data-id="2">Additional</dropdown-options-item>
                            <dropdown-options-item class="dropdown-options-item-rR" data-id="3">Low</dropdown-options-item>
                            <dropdown-options-item class="dropdown-options-item-rR" data-id="4">Medium</dropdown-options-item>
                            <dropdown-options-item class="dropdown-options-item-rR" data-id="5">High</dropdown-options-item>
                        </dropdown-options>
                    </dropdown>
                </div>
            </div>
            <div class="box-list box-list-small">
                <h5>Salary(/Month):</h5>
                <div class="box-list-item input-item">
                    <input type="number" name="salary_cost">
                </div>
            </div>
            <button class="update_Staff" data-story-type="Story">Submit</button>
        </div>
    </div>
</div>
<style>
.box{
    height:90%;
    border-radius:0
}
.input-item,button{
    border-radius:0
}
.box-head{
    height:43px;
}
.box-content{
    height:calc(100% - 43px);
    overflow:auto;
}
.box-list .addNew{
    margin:0
}
.newItem{
    position:relative
}
.box-list .newItem input{
    position:absolute;
    width:calc(100% - 95px)
}
.newItem .cancelNew,.newItem .submitNew{
    float:right;
    height:57px;
    border-left:1px solid #ad9440
}
dropdown.active dropdown-options{
    max-height:200px;
    height:unset
}
</style>
<script>
$(document).ready(function () {
    $(".box-head-alt").click(function(){
        console.log('cross')
        $('#staff-planning-editor').parent().remove();
    })
    $('.showNew').click(function(){
        console.log('new')
        $(this).prev().css('display','block')
    })
    $('.cancelNew').click(function(){
        $(this).parent().css('display','none')
    })
    $.ajax({
        type:'POST',
        url:'http://192.168.50.90/staff/api/staffing/getstaff',
        data:{
            staffID:$('#staff-planning-editor').data('id')
        },
        success:function(res){
            console.log('lapit',res)
            var role,product,capability,service
            for(let i in res[0].roles){
                if(res[0].roles[i].type=='Main'){
                    role=res[0].roles[i].name
                }
            }
            $('input[name=product_id]').val(res[0].Product)
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/staffing/Product',
                success:function(resP){
                    for(let i in resP){
                        if(resP[i].typeID==res[0].Product){
                            product=resP[i].title
                            $('.dropdown-current_product').text(product)
                        }
                    }
                }
            })
            $('input[name=capability_id]').val(res[0].Capability)
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/Capability',
                data:{
                    parentID:res[0].Product
                },
                success:function(resC){
                    for(let i in resC){
                        if(resC[i].typeID==res[0].Capability){
                            capability=resC[i].title
                            $('.dropdown-current_capability').text(capability)
                        }
                    }
                }
            })
            $('input[name=service_id]').val(res[0].Service)
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/Service',
                data:{
                    parentID:res[0].Capability
                },
                success:function(resS){
                    for(let i in resS){
                        if(resS[i].typeID==res[0].Service){
                            service=resS[i].title
                            $('.dropdown-current_service').text(service)
                        }
                    }
                }
            })
            $('input[name=role_id]').val(res[0].roleID)
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/run-rate/roles',
                success:function(resR){
                    for(let i in resR){
                        if(resR[i].roleID==res[0].roleID){
                            $('.dropdown-current_role').text(`[${resR[i].type}] - ${resR[i].name}`)
                        }
                    }
                }
            })
            $('input[name=department_id]').val(res[0].departmentID)
            $('.dropdown-current_department').text(res[0].department)
            // $("input[name=role_id]").val(res[0].roleID);
            // $(".dropdown-current_role").text(role);
            $('input[name=location_id]').val(res[0].Country_id)
            $('.dropdown-current_location').text(res[0].Country_Name)
            $('input[name=first_name]').val(res[0].firstName)
            $('input[name=middle_name]').val(res[0].middleName)
            $('input[name=last_name]').val(res[0].lastName)
            if(res[0].LocationManager.staffID){
                $('input[name=lManager_id]').val(res[0].LocationManager.staffID);
                $('.dropdown-current_lManager').text(res[0].LocationManager.name);
            }
            if(res[0].FunctionalManager.staffID){
                $('input[name=fManager_id]').val(res[0].FunctionalManager.staffID)
                $('.dropdown-current_fManager').text(res[0].FunctionalManager.name)
            }
            if(res[0].joinDate){
                $('input[name=join_date]').val(res[0].joinDate)
            }
            if(res[0].leaveDate){
                $('input[name=ending_date]').val(res[0].leaveDate)
            }
            for(let key in res[0].RunRate){
                if(key=='VolunteerCost'){
                    $('input[name=rR_id]').val('1')
                    $(".dropdown-current_rR").text('Volunteer');
                }
                if(key=='AdditionalCost'){
                    $('input[name=rR_id]').val('2')
                    $(".dropdown-current_rR").text('Additional');
                }
                if(key=='LowCost'){
                    $('input[name=rR_id]').val('3')
                    $(".dropdown-current_rR").text('Low');
                }
                if(key=='MediumCost'){
                    $('input[name=rR_id]').val('4')
                    $(".dropdown-current_rR").text('Medium');
                }
                if(key=='HighCost'){
                    $('input[name=rR_id]').val('5')
                    $(".dropdown-current_rR").text('High');
                }
            }
            $('input[name=salary_cost]').val(res[0].salary)
        }
    })
    $('input[name=join_date]').change(function(){
        console.log($(this).val())
    })
//dropdown clicking
    $('#dropdown_product').click(function() {
        if (!$(this).hasClass('active')) {
            $("#dropdown_product").addClass("active");
            $.ajax({
                type:"GET",
                url:"http://192.168.50.90/staff/api/staffing/Product",
                success:function(data){
                    $('.dropdown-options-item-product').remove()
                    for(let item in data){
                        $(".dropdown_item_product").append(`<dropdown-options-item class="dropdown-options-item-product" data-id="${data[item].typeID}">${data[item].title}</dropdown-options-item>`);
                    }
                    $(".dropdown-options-item-product").click(function () {
                        $("input[name=product_id]").val($(this).data("id"));
                        $(".dropdown-current_product").text($(this).text());
                        $("input[name=capability_id]").val('');
                        $(".dropdown-current_capability").text('Pick A Capability');
                        $("input[name=service_id]").val('');
                        $(".dropdown-current_service").text('Pick A Service');
                    })
                }
            })
        }else{
            $("#dropdown_product").removeClass("active");
            $(".dropdown-options-item-product").remove()
        }
    })
    $('#dropdown_capability').click(function() {
        if (!$(this).hasClass('active')) {
            $("#dropdown_capability").addClass("active");
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/Capability',
                data:{
                    parentID:$("input[name=product_id]").val()
                },
                success:function(data){
                    $('.dropdown-options-item-capability').remove()
                    for(let item in data){
                        $(".dropdown_item_capability").append(`<dropdown-options-item class="dropdown-options-item-capability" data-id="${data[item].typeID}">${data[item].title}</dropdown-options-item>`);
                    }
                    $('.dropdown-options-item-capability').click(function(){
                        $("input[name=capability_id]").val($(this).data("id"));
                        $(".dropdown-current_capability").text($(this).text());
                        $("input[name=service_id]").val('');
                        $(".dropdown-current_service").text('Pick A Service');
                    })
                }
            })
        }else{
            $("#dropdown_capability").removeClass("active");
        }
    })
    $('#dropdown_service').click(function() {
        if (!$(this).hasClass('active')) {
            $("#dropdown_service").addClass("active");
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/Service',
                data:{
                    parentID:$("input[name=capability_id]").val()
                },
                success:function(data){
                    $('.dropdown-options-item-service').remove()
                    for(let item in data){
                        $(".dropdown_item_service").append(`<dropdown-options-item class="dropdown-options-item-service" data-id="${data[item].typeID}">${data[item].title}</dropdown-options-item>`);
                    }
                    $('.dropdown-options-item-service').click(function(){
                        $("input[name=service_id]").val($(this).data("id"));
                        $(".dropdown-current_service").text($(this).text());
                    })
                }
            })
        }else{
            $("#dropdown_service").removeClass("active");
        }
    })
    $('#dropdown_department').click(function() {
        if (!$(this).hasClass('active')) {
            $("#dropdown_department").addClass("active");
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/run-rate/departments',
                success:function(res){
                    $('.dropdown-options-item-department').remove()
                    console.log('department:',res)
                    for(let i in res){
                        $('.dropdown_item_department').append(`<dropdown-options-item class='dropdown-options-item-department' data-id='${res[i].departmentID}'>${res[i].department}</dropdown-options-item>`)
                    }
                    $('.dropdown-options-item-department').click(function(){
                        $("input[name=department_id]").val($(this).data("id"));
                        $(".dropdown-current_department").text($(this).text());
                    })
                }
            })
        }else{
            $("#dropdown_department").removeClass("active");
        }
    })
    $('#dropdown_role').click(function() {
        if (!$(this).hasClass('active')) {
            $("#dropdown_role").addClass("active");
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/run-rate/roles',
                success:function(res){
                    console.log('roles:',res)
                    $('.dropdown-options-item-role').remove()
                    for(let i in res){
                        $('.dropdown_item_role').append(`<dropdown-options-item class='dropdown-options-item-role' data-id='${res[i].roleID}'>[${res[i].type}] - ${res[i].name}</dropdown-options-item>`)
                    }
                    $('.dropdown-options-item-role').click(function(){
                        $("input[name=role_id]").val($(this).data("id"));
                        $(".dropdown-current_role").text($(this).text());
                    })
                }
            })
        }else{
            $("#dropdown_role").removeClass("active");
        }
    })
    $('#dropdown_location').click(function(){
        if(!$(this).hasClass('active')){
            $('#dropdown_location').addClass('active')
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/staffing/Country',
                success:function(res){
                    $('.dropdown-options-item-location').remove()
                    for(let i in res){
                        $('.dropdown_item_location').append(`<dropdown-options-item class='dropdown-options-item-location' data-id='${res[i].Country_id}'>${res[i].Country_Name}</dropdown-options-item>`)
                    }
                    $('.dropdown-options-item-location').click(function(){
                        $('input[name=location_id]').val($(this).data('id'))
                        $('.dropdown-current_location').text($(this).text())
                    })
                }
            })
        }else{
            $('#dropdown_location').removeClass('active')
        }
    })
    $('#dropdown_lManager').click(function(){
        if(!$(this).hasClass('active')){
            $('#dropdown_lManager').addClass('active')
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/staffing/Info',
                success:function(res){
                    $('.dropdown-options-item-lManager').remove()
                    for(let i in res){
                        if(res[i].middleName){
                            $('.dropdown_item_lManager').append(`<dropdown-options-item class='dropdown-options-item-lManager' data-id='${res[i].staffID}'>${res[i].firstName} ${res[i].middleName} ${res[i].lastName}</dropdown-options-item>`)
                        }else{
                            $('.dropdown_item_lManager').append(`<dropdown-options-item class='dropdown-options-item-lManager' data-id='${res[i].staffID}'>${res[i].firstName} ${res[i].lastName}</dropdown-options-item>`)
                        }
                    }
                    $('.dropdown-options-item-lManager').click(function(){
                        $('input[name=lManager_id]').val($(this).data('id'));
                        $('.dropdown-current_lManager').text($(this).text());
                    })
                }
            })
        }else{
            $('#dropdown_lManager').removeClass('active')
        }
    })
    $('#dropdown_fManager').click(function(){
        if(!$(this).hasClass('active')){
            $('#dropdown_fManager').addClass('active')
            $.ajax({
                type:'GET',
                url:'http://192.168.50.90/staff/api/staffing/Info',
                success:function(res){
                    $('.dropdown-options-item-fManager').remove()
                    for(let i in res){
                        if(res[i].middleName){
                            $('.dropdown_item_fManager').append(`<dropdown-options-item class='dropdown-options-item-fManager' data-id='${res[i].staffID}'>${res[i].firstName} ${res[i].middleName} ${res[i].lastName}</dropdown-options-item>`)
                        }else{
                            $('.dropdown_item_fManager').append(`<dropdown-options-item class='dropdown-options-item-fManager' data-id='${res[i].staffID}'>${res[i].firstName} ${res[i].lastName}</dropdown-options-item>`)
                        }
                    }
                    $('.dropdown-options-item-fManager').click(function(){
                        $('input[name=fManager_id]').val($(this).data('id'))
                        $('.dropdown-current_fManager').text($(this).text())
                    })
                }
            })
        }else{
            $('#dropdown_fManager').removeClass('active')
        }
    })
    $('#dropdown_rR').click(function(){
        if(!$(this).hasClass('active')){
            $('#dropdown_rR').addClass('active')
            $('.dropdown-options-item-rR').click(function(){
                $('input[name=rR_id]').val($(this).data('id'))
                $(".dropdown-current_rR").text($(this).text());
            })
        }else{
            $('#dropdown_rR').removeClass('active')
        }
    })
    // display new item adding
    $('.newP').click(function(){
        $.ajax({
            type:'POST',
            url:'http://192.168.50.90/staff/api/staffing/create-Product',
            data:{
                type:'Product',
                title:$('.newProduct').val()
            },
            success:function(res){
                // $('.dropdown_item_product').append(`<dropdown-options-item class="dropdown-options-item-product" data-id="${res}">${$('.newProduct').val()}</dropdown-options-item>`);
                // $('.newProduct').val('')
                $('.newProduct').parent().css('display','none')
                $('.newProduct').val('')
                addNotif("Adding a New Product", "The new product has been added successfully!", 1);
            }
        })
    })
    $('.newC').click(function(){
        if($("input[name=product_id]").val()){
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/create-Product',
                data:{
                    type:'Capability',
                    title:$('.newCapability').val(),
                    parentID:$("input[name=product_id]").val()
                },
                success:function(res){
                    console.log(res)
                    // $('.dropdown_item_capability').append(`<dropdown-options-item class="dropdown-options-item-capability" data-id="${res}">${$('.newCapability').val()}</dropdown-options-item>`);
                    // $('.newCapability').val('')
                    $('.newCapability').parent().css('display','none')
                    $('.newCapability').val('')
                    addNotif("Adding New Capability", "The new capability has been added successfully!", 1);
                }
            })
        }else{
            addNotif("Adding a New Capability", "Please select a product first.", 2)
        }
    })
    $('.newS').click(function(){
        if($('input[name=capability_id]').val()){
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/staffing/create-Product',
                data:{
                    type:'Service',
                    title:$('.newService').val(),
                    parentID:$("input[name=capability_id]").val()
                }, 
                success:function(res){
                    // $('.dropdown_item_service').append(`<dropdown-options-item class="dropdown-options-item-service" data-id="${res}">${$('.newService').val()}</dropdown-options-item>`);
                    // $('.newService').val('')
                    $('.newService').parent().css('display','none')
                    $('.newService').val('')
                    addNotif("Adding New Service", "The new service has been added successfully!", 1);
                }
            })
        }else{
            addNotif("Adding a New Service", "Please select a capability first.", 2)
        }  
    })
    $('.newR').click(function(){
        if($('input[name=department_id]').val()){
            $.ajax({
                type:'POST',
                url:'http://192.168.50.90/staff/api/run-rate/create-roles',
                data:{
                    type:'Main',
                    name:$('.newRole').val(),
                    departmentID:$('input[name=department_id]').val()
                },
                success:function(res){
                    $('.newRole').parent().css('display','none')
                    $('.newRole').val('')
                    addNotif("Adding a New Rold", "The new rold has been added successfully!", 1);
                }
            })
        }else{
            addNotif("Adding a New Role", "Please select a department first.", 2)
        }
    })
    //uploading data
    $('.update_Staff').click(function () {
        let productID=$('input[name=service_id]').val()
        let departmentID=$('input[name=department_id]').val()
        let roleID=$('input[name=role_id]').val()
        let location=$('input[name=location_id]').val()
        let firstName=$('input[name=first_name]').val()
        let middleName=$('input[name=middle_name]').val()
        let lastName=$('input[name=last_name]').val()
        let locationManager=$('input[name=lManager_id]').val()
        let functionalManager=$('input[name=fManager_id]').val()
        let joinDate=$('input[name=join_date]').val()
        let leaveDate=$('input[name=ending_date]').val()
        let runrateID=$('input[name=rR_id]').val()
        let salary=$('input[name=salary_cost]').val()
        var thisb=this
        $.ajax({
            type:'POST',
            url:'http://192.168.50.90/staff/api/staffing/edit-Staff',
            data:{
                staffID:$('#staff-planning-editor').data('id'),
                productID,
                departmentID,
                roleID,
                location,
                firstName,
                middleName,
                lastName,
                locationManager,
                functionalManager,
                joinDate,
                leaveDate,
                runrateID,
                salary
            },
            success:function(res){
                console.log(res)
                $(thisb).parent().css('display','none')
                // window.location.reload()
                loadContent('staff-planning',{},0)
            },
            // error:function(){
            //     console.log(data)
            // }
        })
    })
})
</script>