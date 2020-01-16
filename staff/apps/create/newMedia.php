
<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="Run-Rate-creation">
    <div class="box">
            <div class="box-head">
                <h4>Add a Social Media Location</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content" >
            	<div class="box-list box-list-small">
                    <h6>1.Please select a social account</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_country">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current_country">Pick A Account</dropdown-current>
                                <input type="hidden" name="category_country_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_country">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>2.Please enter a country or city.</h6>
                    <div class="box-list-item input-item">
                        <input type="text" name="country_cost" >
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>3.Please enter the current number of followers.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="followers_cost" >
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>4.Please enter Starting Month &amp; Year.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="year_cost" >
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>5. #Of Followers Needed to Start a Community</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="needed_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>6.Goal Date for Community Requirement</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="date_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>7.Priority (1 – 10) (High to Low)</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="priority_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>8.Type of Growth</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="type_cost">
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                    <h5>9.Population (EST in 2019)</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="population_cost">
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                    <h5>10.EST of Population that Loves Film</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="loves_cost">
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                    <h5>11.EST Max Film Loving Followers</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="max_cost">
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
    dropdown.active{
    	height: 155px;
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
                            type:"post",
                            url:"http://192.168.50.90/staff/api/Socialmedia/AccountsList",
                            success:function(data){
                            	console.log(data)
                                for(let item in data){
                                	$(".dropdown_item_country").append(`<dropdown-options-item class="dropdown-options-item-country" data-id="${data[item].social_media_account_id}">[${data[item].social_media_type}]  ${data[item].social_media_account_name}</dropdown-options-item>`);
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
//                  //加载下拉框Roles
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/staffing/Info",
                        success:function(data){
                            console.log(data)
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
                          let country_cost=$('input[name=country_cost]').val();
                          let followers_cost=$('input[name=followers_cost]').val();
                          let year_cost=$('input[name=year_cost]').val();
                          let needed_cost=$('input[name=needed_cost]').val();
                          let date_cost=$('input[name=date_cost]').val();
                          let priority_cost=$('input[name=priority_cost]').val();
                          let type_cost=$('input[name=type_cost]').val();
                          let population_cost=$('input[name=population_cost]').val();
                          let loves_cost=$('input[name=loves_cost]').val();
                          let max_cost=$('input[name=max_cost]').val();
                          /*console.log(country);
                          console.log(roles);
                          console.log(cost_year.length);
                          console.log(volunteer_cost.length);
                          console.log(additional_cost.length);
                          console.log(low_cost.length);
                          console.log(medium_cost.length );
                          console.log(high_cost.length);*/
                          if(country_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter country or city!", 2);
                          }else if(followers_cost<=0){
                            addNotif("Unable to create an run rate", "Please enter the current number of followers!", 2);
                          }else if(year_cost.length<4){
                            addNotif("Unable to create an run rate", "Please enter Starting Month&Year!", 2);
                          }else if(needed_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter #Of Followers Needed to Start a Community!", 2);
                          }else if(date_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter Goal Date for Community Requirement!", 2);
                          }else if(priority_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter Priority (1 – 10) (High to Low)!", 2);
                          }else if(type_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter Type of Growth!", 2);
                          }else if(population_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter Population!", 2);
                          }else if(loves_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter EST of Population that Loves Film!", 2);
                          }else if(max_cost.length<=0){
                            addNotif("Unable to create an run rate", "Please enter EST Max Film Loving Followers!", 2);
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