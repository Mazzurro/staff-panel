<div class="panel panel-popup" id="role_Creation">
    <div class="box">
            <div class="box-head">
                <h4>Editor Revenue</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content" >
                <div class="box-list box-list-small">
                    <h6>1.Please select the type of product to sell.</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_product">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-product">Pick A Product</dropdown-current>
                                <input type="hidden" name="category_product_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_product">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h6>2.Please select the type of service you want.</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_services">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-services">Pick A Services</dropdown-current>
                                <input type="hidden" name="category_services_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_services">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>3.Please enter the name of the client this service is being sold to.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="clients" value="<?php echo($_POST['clientsData']);?>">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>4.Please enter revenue origin.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="revenueOrigin" value="<?php echo($_POST['revenue_Origin']);?>">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>5.Revenue Destination.</h5>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_services">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-services">Pick A Services</dropdown-current>
                                <input type="hidden" name="category_services_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_services">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>6.Please enter unit value(USD).</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="unitValue_Usd" value="<?php echo($_POST['Unit_Value_USD']);?>">
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>7.Please enter Unit Value (Local Currency).</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="unitValue_Local_Currency" value="<?php echo($_POST['Unit_Value_Local_Currency']);?>" >
                    </div>
                </div>
                <button class="updateRevenue" >Update Revenue</button>
            </div>
    </div>
</div>
<style>
    .box{
        height:80%;
    }
    .box-head{
        height:43px;
    }
    .box-content{
        height: calc(100% - 43px);
        overflow: auto;
    }
    .input-item{
        color: #ad9440;
    }
</style>
<script type="text/javascript">
      $(document).ready(function () {
         setSelectInput('#assignment-creation');

         $(".box-head-alt").click(function(){
             $('#role_Creation').parent().remove();
         })

        //加载下拉框Product
        $.ajax({
            type:"POST",
            url:"http://192.168.50.90/staff/api/run-rate/departments",
            success:function(data){
                for(let item in data){
                    $(".dropdown_item_product").append(`<dropdown-options-item class="dropdown-options-item-product" data-id="${data[item].departmentID}">[Department] - ${data[item].department}</dropdown-options-item>`);
                }
                $(".dropdown-options-item-product").click(function () {
                    //得到当前点击dropdown-options-item的id值
                    //将选中的id赋值给input标签
                    $("input[name=category_product_id]").val($(this).data("id"));
                    //把选中下框显示的值赋给dropdown-current标签
                    $(".dropdown-current-product").text($(this).text());
                })
            }
        })
        //加载下拉框Services
        $.ajax({
            type:"POST",
            url:"http://192.168.50.90/staff/api/run-rate/roles",
            success:function(data){
                console.log("角色");
                console.log(data);
                for(let item in data){
                    $(".dropdown_item_services").append(`<dropdown-options-item class="document-options-item-services" data-id="${data[item].roleID}">[${data[item].type}] - ${data[item].name}</dropdown-options-item>`);
                }

                $(".document-options-item-services").click(function(){
                    //将选中的文本赋予下拉框显示
                    $(".dropdown-current-services").text($(this).text());
                    //将当前选中的文本的id赋予下拉框中的隐藏id
                    $("input[name=category_services_id]").val($(this).attr("data-id"));
                });
            }
        })
          //点击下拉框（显示/隐藏）
          $('#dropdown_category_product').click(function() {
             if (!$(this).hasClass('active')) {
                 $("#dropdown_category_product").addClass("active");
             }else{
                 $("#dropdown_category_product").removeClass("active");
             }
          });
          //点击下拉框（显示/隐藏）
            $('#dropdown_category_services').click(function() {
               if (!$(this).hasClass('active')) {
                   $("#dropdown_category_services").addClass("active");
               }else{
                   $("#dropdown_category_services").removeClass("active");
               }
            });

             $('.updateRevenue').click(function () {
                let product_id=$('input[name=category_product_id]').val();
                let services_id=$('input[name=category_services_id]').val();
                let clients=$('input[name=clients]').val();
                let revenueOrigin=$('input[name=revenueOrigin]').val();
                let revenueDestination=$('input[name=revenueDestination]').val();
                let unitValue_Usd=$('input[name=unitValue_Usd]').val();
                let unitValue_Local_Currency=$('input[name=unitValue_Local_Currency]').val();
                let highCost=$('input[name=highCost]').val();

                console.log("roleName:",product_id);
                console.log("services_id："+services_id);
                console.log("clients：",clients);
                console.log("revenueOrigin：",revenueOrigin);
                console.log("revenueDestination：",revenueDestination);
                console.log("unitValue_Usd：",unitValue_Usd);
                console.log("unitValue_Local_Currency：",unitValue_Local_Currency);
                console.log("highCost：",highCost);
               if(product_id=="" || product_id==null){
                   addNotif("Unable to add a new Revenue", "Please select product from the drop-down box!", 2);
               }else if(services_id==""){
                   addNotif("Unable to add a new Revenue", "Please select services from the drop-down box!", 2);
               }else if(clients==""){
                   addNotif("Unable to add a new Revenue", "Please enter the clients!", 2);
               }else if(revenueOrigin==""){
                   addNotif("Unable to add a new Revenue", "Please enter the revenue origin!", 2);
               }else if(revenueDestination==""){
                   addNotif("Unable to add a new Revenue", "Please enter the revenue destination!", 2);
               }else if(unitValue_Usd==""){
                   addNotif("Unable to add a new Revenue", "Please enter the unit value (USD)!", 2);
               }else if(unitValue_Local_Currency==""){
                   addNotif("Unable to add a new Revenue", "Please enter the unit Value(Local Currency)!", 2);
               }else if(highCost==""){
                   addNotif("Unable to add a new Revenue", "Please enter the high cost!", 2);
               }else{
                    console.log("更新Revenue");
                    paneljs.fetch({type:'api', call:'', postData:{}}, (data) => {
                           console.log(data);
                           addNotif("Add A New Role", "Add successfully", 1);
                           fullPageLoad('off');
                           setTimeout(function () {
                                console.log("延迟加载")
                               $('#run_Rate_Creation').parent().remove();
                               //加载页面，按照传送不同的参数加载页面
                               loadContent('revenue', {}, 0)
                           },750);
                       });
               }
         });

      });
</script>
        </div>
    </div>
</div>