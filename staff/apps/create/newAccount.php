
<?php echo $_POST["assignmentID"]; ?>
<div class="panel panel-popup" id="Run-Rate-creation">
    <div class="box">
    		<div class="box-head">
                <h4>Add new Social Account</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content" >
                <div class="box-list box-list-small">
                    <h6>1.Please Enter Social Account Name</h6>
                    <div class="box-list-item input-item">
                        <input type="text" name="category_name_id" >
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>3.Please select Social Account Type</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_types">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-types">Pick A Type</dropdown-current>
                                <input type="hidden" name="category_types_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_types">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>
                <div class="box-list box-list-small">
                    <h6>2.Please select Social Account user</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_users">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-users">Pick A user</dropdown-current>
                                <input type="hidden" name="category_users_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_users">
                            </dropdown-options>
                        </dropdown>
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
    .box {
	    height: 56%;
	}
</style>
            <script type="text/javascript">
                  $(document).ready(function () {
                     setSelectInput('#assignment-creation');
                     $(".box-head-alt").click(function(){
                         $('#Run-Rate-creation').parent().remove();
                     })
                     
                     $.ajax({
                            type:"POST",
                            url:"http://192.168.50.90/staff/api/Socialmedia/AccountsList",
                            success:function(data){
                            	console.log(data)
                            }
                        })    
                    //加载type下拉框
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/Socialmedia/Types",
                        success:function(data){
								for(let item in data){
                                    $(".dropdown_item_types").append(`<dropdown-options-item class="dropdown-options-item-types" data-id="${data[item].social_media_type_id}" >${data[item].social_media_type}</dropdown-options-item>`);
                                }
                                $(".dropdown-options-item-types").click(function () {
	                                //得到当前点击dropdown-options-item的id值
	                                //将选中的id赋值给input标签
	                                $("input[name=category_types_id]").val($(this).data("id"));
	                                //把选中下框显示的值赋给dropdown-current标签
	                                $(".dropdown-current-types").text($(this).text());
	                            })
                        }
                    })
                    //加载user下拉框
                    $.ajax({
                            type:"POST",
                            url:"http://192.168.50.90/staff/api/staffing/Info",
                            success:function(data){
                                for(let item in data){
                                    $(".dropdown_item_users").append(`<dropdown-options-item class="dropdown-options-item-users" data-id="${data[item].staffID}"  >${data[item].firstName} ${data[item].lastName}</dropdown-options-item>`);
                                }
                                $(".dropdown-options-item-users").click(function () {
                                    //得到当前点击dropdown-options-item的id值
                                    //将选中的id赋值给input标签
                                    $("input[name=category_users_id]").val($(this).data("id"));
                                    //把选中下框显示的值赋给dropdown-current标签
                                    $(".dropdown-current-users").text($(this).text());
                                })
                            }
                    })
//                      
                     //点击下拉框（显示/隐藏）
                      $('#dropdown_category_types').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_types").addClass("active");
                         }else{
                             $("#dropdown_category_types").removeClass("active");
                         }
                      })
                      //点击下拉框（显示/隐藏）
                      $('#dropdown_category_users').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_users").addClass("active");
                         }else{
                             $("#dropdown_category_users").removeClass("active");
                         }
                      })

                         $('.createRun_Rate').click(function () {
                          let Account_name=$('input[name=category_name_id]').val();
                          if($('input[name=category_types_id]').val() == 1){
                          		let Account_type ="Facebook"
                          }else if($('input[name=category_types_id]').val() == 2){
                          		let Account_type ="Youtube"
                          }else{
                          		let Account_type ="Instagram"
                          }
                          let Account_type=$('input[name=category_types_id]').val();
                          let Account_uesr=$('input[name=category_users_id]').val();
                          console.log(Account_name);
                          console.log(Account_type);
                          console.log(Account_uesr);
                          /*console.log(country);
                          console.log(additional_cost.length);
                          console.log(low_cost.length);
                          console.log(medium_cost.length );
                          console.log(high_cost.length);*/
                          if(Account_name.length<=0){
                            addNotif("Unable to create an account", "Please enter the Account_name!", 2);
                          }else if(Account_type=="" || Account_type==null){
                            addNotif("Unable to create an account", "Please select Account_type from the drop-down box!", 2);
                          }else if(Account_uesr=="" || Account_uesr==null){
                            addNotif("Unable to create an account", "Please select Account_uesr from the drop-down box!", 2);
                          }else{
                            paneljs.fetch({type:'api', call:'http://192.168.50.90/staff/api/Socialmedia/AccountsList', postData:{
                                   social_media_account_name: Account_name,
                                   social_media_account_type: Account_type,
                                   social_media_account_owner: Account_uesr,
                               }}, (data) => {
                                   console.log(data);
                                   addNotif("Create the run-rates", "Create successfully", 1);
                                   $('#Run-Rate-creation').addClass('float-fade-out');
                                   $('#Run-Rate-creation').find('.float-fade-out').addClass('float-fade-out');
                                   $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                                   setTimeout(function () {
                                       $('#Run-Rate-creation').parent().remove();
                                       //加载页面，按照传送不同的参数加载页面
                                       loadContent('social-media', {}, 0)
                                   },750);
                               });
                          }
                     });
                  });
              </script>
        </div>
    </div>
</div>