
<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="staff-planning-creation">
    <div class="box">
        <div class="box-head">
            <h4>Create An Staff Planning</h4>
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
            <button class="createNew_Staff" data-story-type="Story">Submit</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        setSelectInput('#assignment-creation');
        $(".box-head-alt").click(function(){
            $('#staff-planning-creation').parent().remove();
        })
        $('.showNew').click(function(){
            $(this).prev().css('display','block')
        })
        $('.cancelNew').click(function(){
            $(this).parent().css('display','none')
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
    //getting product,capability and service
    // $.ajax({
    //         type:"POST",
    //         url:"http://192.168.50.90/staff/api/staffing/Product",
    //         success:function(data){
    //             console.log('product',data)
    //             $('.dropdown-options-item-product').remove()
    //             for(let item in data){
    //                 $(".dropdown_item_product").append(`<dropdown-options-item class="dropdown-options-item-product" data-id="${data[item].typeID}">${data[item].title}</dropdown-options-item>`);
    //             }
    //             $(".dropdown-options-item-product").click(function () {
    //                 $("input[name=product_id]").val($(this).data("id"));
    //                 $(".dropdown-current_product").text($(this).text());
    //                 $.ajax({
    //                     type:'POST',
    //                     url:'http://192.168.50.90/staff/api/staffing/Capability',
    //                     data:{
    //                         parentID:$("input[name=product_id]").val()
    //                     },
    //                     success:function(res){
    //                         $('.dropdown-options-item-capability').remove()
    //                         for(let ite in res){
    //                             $('.dropdown_item_capability').append(`<dropdown-options-item class='dropdown-options-item-capability' data-id='${res[ite].typeID}'>${res[ite].title}</dropdown-options-item>`);
    //                         }
    //                         $('.dropdown-options-item-capability').click(function(){
    //                             $("input[name=capability_id]").val($(this).data("id"));
    //                             $(".dropdown-current_capability").text($(this).text());
    //                             $.ajax({
    //                                 type:'POST',
    //                                 url:'http://192.168.50.90/staff/api/staffing/Service',
    //                                 data:{
    //                                     parentID:$("input[name=capability_id]").val(),
    //                                 },
    //                                 success:function(resp){
    //                                     console.log('service',resp)
    //                                     $('.dropdown-options-item-service').remove()
    //                                     for(let i in resp){
    //                                         $('.dropdown_item_service').append(`<dropdown-options-item class='dropdown-options-item-service' data-id='${resp[i].typeID}'>${resp[i].title}</dropdown-options-item>`);
    //                                     }
    //                                     $('.dropdown-options-item-service').click(function(){
    //                                         $("input[name=service_id]").val($(this).data("id"));
    //                                         $(".dropdown-current_service").text($(this).text());
    //                                     })
    //                                 }
    //                             })
    //                         })
                            
    //                     }
    //                 })
    //             })
    //         }
    // })
    
//display dropdown items
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

        $('.createNew_Staff').click(function () {
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
                url:'http://192.168.50.90/staff/api/staffing/create-Staff',
                data:{
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


            // let country=$('input[name=category_country_id]').val();
            // let roles=$('input[name=category_roles_id]').val();
            // let cost_year=$('input[name=cost_year]').val();
            // let volunteer_cost=$('input[name=volunteer_cost]').val();
            // let additional_cost=$('input[name=additional_cost]').val();
            // let low_cost=$('input[name=low_cost]').val();
            // let medium_cost=$('input[name=medium_cost]').val();
            // let high_cost=$('input[name=high_cost]').val();
            // console.log(country);
            // console.log(roles);
            // console.log(cost_year.length);
            // console.log(volunteer_cost.length);
            // console.log(additional_cost.length);
            // console.log(low_cost.length);
            // console.log(medium_cost.length );
            // console.log(high_cost.length);
            // if(country=="" || country==null){
            // addNotif("Create An Run Rate", "Please select country from the drop-down box!", 2);
            // }else if(roles=="" || roles==null){
            // addNotif("Create An Run Rate", "Please select roles from the drop-down box!", 2);
            // }else if(cost_year.length<=0){
            // addNotif("Create An Run Rate", "Please enter the cost year!", 2);
            // }else if(volunteer_cost.length<=0){
            // addNotif("Create An Run Rate", "Please enter the volunteer cost!", 2);
            // }else if(additional_cost.length<=0){
            // addNotif("Create An Run Rate", "Please enter the additional cost!", 2);
            // }else if(low_cost.length<=0){
            // addNotif("Create An Run Rate", "Please enter the low cost!", 2);
            // }else if(medium_cost.length<=0){
            // addNotif("Create An Run Rate", "Please enter the medium cost!", 2);
            // }else if(high_cost.length<=0){
            // addNotif("Create An Run Rate", "Please enter the high cost!", 2);
            // }else{
            // console.log("successful");
            // paneljs.fetch({type:'api', call:'run-rate/create', postData:{
            //         Country: country,
            //         Role: roles,
            //         CostYear: cost_year,
            //         VolunteerCost: volunteer_cost,
            //         AdditionalCost: additional_cost,
            //         LowCost: low_cost,
            //         MediumCost: medium_cost,
            //         HighCost: high_cost,
            //     }}, (data) => {
            //         console.log(data);

            //         addNotif("Create the run-rates", "Create successfully", 1);

            //         $('#Run-Rate-creation').addClass('float-fade-out');
            //         $('#Run-Rate-creation').find('.float-fade-out').addClass('float-fade-out');
            //         $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
            //         setTimeout(function () {
            //             $('#Run-Rate-creation').parent().remove();
            //             //加载页面，按照传送不同的参数加载页面
            //             loadContent('run-rate', {}, 0)

            //         },750);
            //     });
            // }
        });
        // $('#cancel').click(function () {
        // if (confirm('Are you sure you want to exit out of the Assignment Creation Panel?')) {
        //     $('#Run-Rate-creation').addClass('float-fade-out');
        //     $('#Run-Rate-creation').find('.float-fade-out').addClass('float-fade-out');
        //     $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
        //     setTimeout(function () {
        //         //移除#assignment-update父级下的所有元素.parent()
        //         $('#Run-Rate-creation').parent().remove();
        //     },750);
        // }
        // });//点击事件
    });
</script>
        </div>
    </div>
</div>