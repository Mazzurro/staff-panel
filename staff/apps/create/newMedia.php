
<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="NewMedia-creation">
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
                        <dropdown id="dropdown_category_account">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current_account">Pick A Account</dropdown-current>
                                <input type="hidden" name="category_account_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_account">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>2.Please enter a city.</h6>
                    <div class="box-list-item input-item">
                        <input type="text" name="city_cost" >
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>3.Please enter a country.</h6>
                    <div class="box-list-item input-item">
                        <input type="text" name="country_cost" >
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h5>4.Please enter the current number of followers.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="followers_cost" >
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>5.Please enter Starting Month &amp; Year.</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="year_cost" placeholder="year-month-day">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>6. #Of Followers Needed to Start a Community</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="needed_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>7.Goal Date for Community Requirement</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="date_cost" placeholder="year-month-day">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>8.Priority (1 – 10) (High to Low)</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="priority_cost">
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>9.Type of Growth</h5>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_Growth">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current_Growth">Pick A Type of Growth</dropdown-current>
                                <input type="hidden" name="category_Growth_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_Growth">
                            	<dropdown-options-item class="dropdown-options-item-Growth" data-id="1">Exponential</dropdown-options-item>
                            	<dropdown-options-item class="dropdown-options-item-Growth" data-id="0">Linear</dropdown-options-item>
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                    <h5>10.Population</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="population_cost">
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                	<h5>11.Please enter a year</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="popyear_cost">
                    </div>
                </div>
                
                <div class="box-list box-list-small">
                    <h5>12.EST of Population that Loves Film</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="loves_cost">
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
    	height: 250px;
    	overflow: auto;
    }
</style>
            <script type="text/javascript">
                  $(document).ready(function () {
                     setSelectInput('#NewMedia-creation');
                     $(".box-head-alt").click(function(){
                         $('#NewMedia-creation').parent().remove();
                     })
                      $.ajax({
                            type:"post",
                            url:"http://192.168.50.90/staff/api/Socialmedia/List",
                            success:function(data){
                            	console.log(data)
                            }
                        })    
                    //加载下拉框Country
                    $.ajax({
                            type:"post",
                            url:"http://192.168.50.90/staff/api/Socialmedia/AccountsList",
                            success:function(data){
                                for(let item in data){
                                	$(".dropdown_item_account").append(`<dropdown-options-item class="dropdown-options-item-account" data-id="${data[item].social_media_account_id}">[${data[item].social_media_type}]  ${data[item].social_media_account_name}</dropdown-options-item>`);
                                }
                                $(".dropdown-options-item-account").click(function () {
                                    //得到当前点击dropdown-options-item的id值
                                    //将选中的id赋值给input标签
                                    $("input[name=category_account_id]").val($(this).data("id"));
                                    //把选中下框显示的值赋给dropdown-current标签
                                    $(".dropdown-current_account").text($(this).text());
                                })
                            }
                    })
//                  //加载下拉框Roles
                     //点击下拉框（显示/隐藏）
                      $('#dropdown_category_account').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_account").addClass("active");
                         }else{
                             $("#dropdown_category_account").removeClass("active");
                         }
                      })
                       $(".dropdown-options-item-Growth").click(function () {
	                        //得到当前点击dropdown-options-item的id值
	                        //将选中的id赋值给input标签
	                        $("input[name=category_Growth_id]").val($(this).data("id"));
	                        //把选中下框显示的值赋给dropdown-current标签
	                        $(".dropdown-current_Growth").text($(this).text());
	                    })
                      $('#dropdown_category_Growth').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_Growth").addClass("active");
                         }else{
                             $("#dropdown_category_Growth").removeClass("active");
                         }
                      })

                         $('.createRun_Rate').click(function () {
                         	let growth_type = ""
                          let social_media_accountId = $("input[name=category_account_id]").val();
                          let city_cost=$('input[name=city_cost]').val();
                          let country_cost=$('input[name=country_cost]').val();
                          let Startfollowers_cost=$('input[name=followers_cost]').val();
                          let Starttime_cost=$('input[name=year_cost]').val();
                          let Neededfollowers_cost=$('input[name=needed_cost]').val();
                          let Neededtime_cost=$('input[name=date_cost]').val();
                          let priority_cost=$('input[name=priority_cost]').val();
                          let growth_cost=$('input[name=category_Growth_id]').val();
                          if(growth_cost =="" || growth_cost == null ){
                          	growth_type = 1
                          }else{
                          	growth_type = growth_cost
                          }
                          let Zongpopulation_cost=$('input[name=population_cost]').val();
                          let Yearpopulation_cost=$('input[name=popyear_cost]').val();
                          let loves_cost=$('input[name=loves_cost]').val();
                          if(social_media_accountId=="" || social_media_accountId==null){
                          	addNotif("Unable to create an Media", "Please select Account from the drop-down box!", 2);
                          }else if(city_cost.length<=0){
                          	addNotif("Unable to create an Media", "Please enter city!", 2);
                          }else if(country_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter country!", 2);
                          }else if(Startfollowers_cost<=0){
                            addNotif("Unable to create an Media", "Please enter the current number of followers!", 2);
                          }else if(Starttime_cost.length<8){
                            addNotif("Unable to create an Media", "Please enter Starting Month&Year!", 2);
                          }else if(Neededfollowers_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter #Of Followers Needed to Start a Community!", 2);
                          }else if(Neededtime_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter Goal Date for Community Requirement!", 2);
                          }else if(priority_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter Priority (1 – 10) (High to Low)!", 2);
                          }else if(Zongpopulation_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter Population!", 2);
                          }else if(loves_cost.length<=0){
                            addNotif("Unable to create an Media", "Please enter EST of Population that Loves Film!", 2);
                          }else if(Yearpopulation_cost.length<4){
                            addNotif("Unable to create an Media", "Please enter the year in the correct format!", 2);
                          }else{
                            paneljs.fetch({type:'api', call:'/Socialmedia/create', postData:{
                                  location_social_account : social_media_accountId,
								  location_city : city_cost,
								  location_country : country_cost,
								  location_required_followers : Neededfollowers_cost,
								  location_required_date : Neededtime_cost,
								  location_priority : priority_cost,
								  location_growth : growth_type,
								  location_film_lovers : loves_cost,
								  followers_total : Startfollowers_cost,
								  followers_date : Starttime_cost,
								  population_total : Zongpopulation_cost,
								  population_year : Yearpopulation_cost,
                               }}, (data) => {
                                   console.log(data);
                                   addNotif("Create the run-rates", "Create successfully", 1);
                                   $("#NewMedia-creation").css("display","none")
//                                 $('#Run-Rate-creation').addClass('float-fade-out');
//                                 $('#Run-Rate-creation').find('.float-fade-out').addClass('float-fade-out');
//                                 $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
//                                 setTimeout(function () {
//                                     $('#Run-Rate-creation').parent().remove();
//                                     //加载页面，按照传送不同的参数加载页面
//                                     loadContent('run-rate', {}, 0)
//                                 },750);
                               });
                          }
                     });
                  });
              </script>
        </div>
    </div>
</div>