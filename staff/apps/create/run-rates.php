
<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="Run-Rate-creation">
    <div class="box">
            <div class="box-head">
                <h4>Create An Run Rate</h4>
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
                        <input type="number" name="cost_year" placeholder="YYYY">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>4.Please enter a Volunteer Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="volunteer_cost" placeholder="0 or 50">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>5.Please enter the Additional Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="additional_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>6.Please enter a Low Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="low_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>7.Please fill in Medium Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="number" name="medium_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>8.Please fill in High Cost</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="high_cost">
                    </div>
                </div>
                <button class="createRun_Rate" data-story-type="Story">Create Run Rate</button>
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
                         $('#Run-Rate-creation').parent().remove();
                     })
                    //加载下拉框Country
                    $.ajax({
                            type:"POST",
                            url:"http://192.168.50.90/staff/api/run-rate/country",
                            success:function(data){
                                for(let item in data){
                                    $(".dropdown_item_country").append(`<dropdown-options-item class="dropdown-options-item-country" data-id="${data[item].Country_id}">[Region] - ${data[item].Country_Name}</dropdown-options-item>`);
                                }
                                $(".dropdown-options-item-country").click(function () {
                                    //得到当前点击dropdown-options-item的id值
                                    //将选中的id赋值给input标签
                                    $("input[name=category_country_id]").val($(this).data("id"));
                                    //把选中下框显示的值赋给dropdown-current标签
                                    $(".dropdown-current_country").text($(this).text());
                                })
                            }
                    })
                    //加载下拉框Roles
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/run-rate/roles",
                        success:function(data){
                            for(let item in data){
                                $(".dropdown_item_roles").append(`<dropdown-options-item class="dropdown-options-item-roles" data-id="${data[item].roleID}">[${data[item].type}] - ${data[item].name}</dropdown-options-item>`);

                            }
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
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_country").addClass("active");
                         }else{
                             $("#dropdown_category_country").removeClass("active");
                         }
                      })
                      //点击下拉框（显示/隐藏）
                      $('#dropdown_category_roles').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_roles").addClass("active");
                         }else{
                             $("#dropdown_category_roles").removeClass("active");
                         }
                      })

                         $('.createRun_Rate').click(function () {
                          let country=$('input[name=category_country_id]').val();
                          let roles=$('input[name=category_roles_id]').val();
                          let cost_year=$('input[name=cost_year]').val();
                          let volunteer_cost=$('input[name=volunteer_cost]').val();
                          let additional_cost=$('input[name=additional_cost]').val();
                          let low_cost=$('input[name=low_cost]').val();
                          let medium_cost=$('input[name=medium_cost]').val();
                          let high_cost=$('input[name=high_cost]').val();
                          /*console.log(country);
                          console.log(roles);
                          console.log(cost_year.length);
                          console.log(volunteer_cost.length);
                          console.log(additional_cost.length);
                          console.log(low_cost.length);
                          console.log(medium_cost.length );
                          console.log(high_cost.length);*/
                          if(country=="" || country==null){
                            addNotif("Unable to create an run rate", "Please select country from the drop-down box!", 2);
                          }else if(roles=="" || roles==null){
                            addNotif("Unable to create an run rate", "Please select roles from the drop-down box!", 2);
                          }else if(cost_year.length<4){
                            addNotif("Unable to create an run rate", "Please enter the cost year!", 2);
                          }else if(volunteer_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter the volunteer cost!", 2);
                          }else if(additional_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter the additional cost!", 2);
                          }else if(low_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter the low cost!", 2);
                          }else if(medium_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter the medium cost!", 2);
                          }else if(high_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter the high cost!", 2);
                          }else{
                            paneljs.fetch({type:'api', call:'run-rate/create', postData:{
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
                                   addNotif("Create the run-rates", "Create successfully", 1);
                                   $('#Run-Rate-creation').addClass('float-fade-out');
                                   $('#Run-Rate-creation').find('.float-fade-out').addClass('float-fade-out');
                                   $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                   setTimeout(function () {
                                       $('#Run-Rate-creation').parent().remove();
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