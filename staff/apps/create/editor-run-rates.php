<div class="panel panel-popup" id="run_Rate_Creation">
    <div class="box">
            <div class="box-head">
                <h4>Editor An Run Rate</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content" >
                <div class="box-list box-list-small">
                    <h6>1.Select the country where the new Run Rate was created</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_country">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current_country">Pick A Country</dropdown-current>
                                <input type="hidden" name="category_country_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_country">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>2.Select Roles to create the new Run Rate</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_roles">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-roles">Pick A Roles</dropdown-current>
                                <input type="hidden" name="category_roles_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_roles">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>3.Please enter the Cost Year of your newly created Run Rate</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="cost_year" value="<?php echo($_POST['cost_Year']);?>" placeholder="YYYY">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>4.Please enter a Volunteer Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="volunteer_cost" value="<?php echo($_POST['volunteerCost']);?>" placeholder="0 or 50">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>5.Please enter the Additional Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="additional_cost" value="<?php echo($_POST['additionalCost']);?>">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>6.Please enter a Low Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="low_cost" value="<?php echo($_POST['lowCost']);?>">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>7.Please fill in Medium Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="medium_cost" value="<?php echo($_POST['mediumCost']);?>">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>8.Please fill in High Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="high_cost" value="<?php echo($_POST['highCost']);?>">
                    </div>
                </div>


                <button class="editoRun_Rate">Update Run Rate</button>
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
                         $('#run_Rate_Creation').parent().remove();
                     })
                    //加载下拉框Country
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/run-rate/country",
                        success:function(data){
                                 /*console.log(data)*/
                            for(let item in data){
                                $(".dropdown_item_country").append(`<dropdown-options-item class="dropdown-options-item-country" data-id="${data[item].Country_id}">[Region] - ${data[item].Country_Name}</dropdown-options-item>`);
                            }
                            //设置category_country_id的初始值，用于匹配下拉框中的iD
                            $('input[name=category_country_id]').val(<?php echo($_POST['country']);?>);
                            let country_id=<?php echo($_POST['country']);?>;
                            //遍历所有dropdown-options-item
                            $(".dropdown_item_country dropdown-options-item").each(function(){
                            console.log("id的值:",country_id)
                                //将dropdown-options-item中的id与请求的categoryID匹配
                                if($(this).attr("data-id")==country_id){
                                    $(".dropdown-current_country").text($(this).text());
                                }
                            });

                            //击下拉框事件
                            $(".dropdown-options-item-country").click(function () {
                                //得到当前点击dropdown-options-item的id值
                                //将选中的id赋值给input标签
                                $("input[name=category_country_id]").val($(this).data("id"));
                                //把选中下框显示的值赋给dropdown-current标签
                                $(".dropdown-current_country").text($(this).text());
                            });
                        }
                    });
                    //加载下拉框Roles
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/run-rate/roles",
                        success:function(data){
                            console.log(data)
                            for(let item in data){
                                $(".dropdown_item_roles").append(`<dropdown-options-item class="dropdown-options-item-roles" data-id="${data[item].roleID}">[${data[item].type}] - ${data[item].name}</dropdown-options-item>`);

                            }

                            //设置category_roles_id的初始值，用于匹配下拉框中的iD
                            $('input[name=category_roles_id]').val(<?php echo($_POST['role']);?>);
                            let country_id=<?php echo($_POST['role']);?>;
                            //遍历所有dropdown-options-item
                            $(".dropdown_item_roles dropdown-options-item").each(function(){
                            console.log("id的值:",country_id)
                                //将dropdown-options-item中的id与请求的categoryID匹配
                                if($(this).attr("data-id")==country_id){
                                    $(".dropdown-current-roles").text($(this).text());
                                }
                            });

                            $(".dropdown-options-item-roles").click(function () {
                                //得到当前点击dropdown-options-item的id值
                                //将选中的id赋值给input标签
                                $("input[name=category_roles_id]").val($(this).data("id"));
                                //把选中下框显示的值赋给dropdown-current标签
                                $(".dropdown-current-roles").text($(this).text());
                            })
                        }
                    })
                     //点击下拉框（显示/隐藏）
                      $('#dropdown_category_country').click(function() {
                         console.log("点击")
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_country").addClass("active");
                         }else{
                             $("#dropdown_category_country").removeClass("active");
                         }
                      })
                      //点击下拉框（显示/隐藏）
                      $('#dropdown_category_roles').click(function() {
                         console.log("点击2")
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_roles").addClass("active");
                         }else{
                             $("#dropdown_category_roles").removeClass("active");
                         }
                      })

                         $('.editoRun_Rate').click(function () {
                          let country=$('input[name=category_country_id]').val();
                          let roles=$('input[name=category_roles_id]').val();
                          let cost_year=$('input[name=cost_year]').val();
                          let volunteer_cost=$('input[name=volunteer_cost]').val();
                          let additional_cost=$('input[name=additional_cost]').val();
                          let low_cost=$('input[name=low_cost]').val();
                          let medium_cost=$('input[name=medium_cost]').val();
                          let high_cost=$('input[name=high_cost]').val();
                          if(country=="" || country==null){
                            addNotif("Unable to editor an run rate", "Please select country from the drop-down box!", 2);
                          }else if(roles=="" || roles==null){
                            addNotif("Unable to editor an run rate", "Please select roles from the drop-down box!", 2);
                          }else if(cost_year.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the cost year!", 2);
                          }else if(volunteer_cost.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the volunteer cost!", 2);
                          }else if(additional_cost.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the additional cost!", 2);
                          }else if(low_cost.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the low cost!", 2);
                          }else if(medium_cost.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the medium cost!", 2);
                          }else if(high_cost.length<=0){
                            addNotif("Unable to editor an run rate", "Please enter the high cost!", 2);
                          }else{
                            paneljs.fetch({type:'api', call:'run-rate/edit', postData:{
                                   RunRate_id:<?php echo($_POST['run_rate_id']);?>,
                                   Country: country,
                                   Role: roles,
                                   CostYear: cost_year,
                                   VolunteerCost: volunteer_cost,
                                   AdditionalCost: additional_cost,
                                   LowCost: low_cost,
                                   MediumCost: medium_cost,
                                   HighCost: high_cost,
                               }}, (data) => {
                                   console.log(data);
                                   addNotif("Editor the run-rates", "Editor successfully", 1);
                                   fullPageLoad('off');
                                   $('#run_Rate_Creation').addClass('float-fade-out');
                                   $('#run_Rate_Creation').find('.float-fade-out').addClass('float-fade-out');
                                   $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                   setTimeout(function () {
                                        console.log("延迟加载")
                                       $('#run_Rate_Creation').parent().remove();
                                       //加载页面，按照传送不同的参数加载页面
                                       loadContent('run-rate', {}, 0)

                                   },750);
                               });
                          }
                     });

                  });
              </script>
        </div>
    </div>
</div>