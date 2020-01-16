<div class="panel panel-popup" id="role_Creation">
    <div class="box">
            <div class="box-head">
                <h4>Add Role</h4>
                <div class="box-head-alt">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="box-content" >
                <div class="box-list box-list-small">
                    <h6>1.Please select the department that will be used to create the new role</h6>
                    <div class="box-list-item input-item">
                        <dropdown id="dropdown_category_roles">
                            <dropdown-head>
                                <dropdown-current class="dropdown-current-roles">Pick A Department</dropdown-current>
                                <input type="hidden" name="category_roles_id">
                            </dropdown-head>
                            <dropdown-options class="dropdown_item_roles">
                            </dropdown-options>
                        </dropdown>
                    </div>
                </div>

                <div class="box-list box-list-small">
                    <h5>3.Please enter the add role name</h5>
                    <div class="box-list-item input-item">
                        <input type="text" name="roleName" >
                    </div>
                </div>
                <button class="addNewRole" data-story-type="Story">Add New Role</button>
            </div>
    </div>
</div>
<style>
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

                    //加载下拉框Roles
                    $.ajax({
                        type:"POST",
                        url:"http://192.168.50.90/staff/api/run-rate/departments",
                        success:function(data){
                            for(let item in data){
                                $(".dropdown_item_roles").append(`<dropdown-options-item class="dropdown-options-item-roles" data-id="${data[item].departmentID}">[Department] - ${data[item].department}</dropdown-options-item>`);
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
                      $('#dropdown_category_roles').click(function() {
                         if (!$(this).hasClass('active')) {
                             $("#dropdown_category_roles").addClass("active");
                         }else{
                             $("#dropdown_category_roles").removeClass("active");
                         }
                      })

                         $('.addNewRole').click(function () {
                          let department_id=$('input[name=category_roles_id]').val();
                          let roleType=$('input[name=roleType]').val();
                          let roleName=$('input[name=roleName]').val();

                          console.log(department_id);
                          console.log(roleType);
                          console.log(roleName);

                          if(department_id=="" || department_id==null){
                            addNotif("Unable to add a new role", "Please select role from the drop-down box!", 2);
                          }else if(roleName==""){
                            addNotif("Unable to add a new role", "Please enter the role name!", 2);
                          }else{
                            paneljs.fetch({type:'api', call:'run-rate/create-roles', postData:{
                                   departmentID:department_id,
                                   type: "Main",
                                   name: roleName,
                               }}, (data) => {
                                   addNotif("Add A New Role", "Add successfully", 1);
                                   fullPageLoad('off');
                                   setTimeout(function () {
                                        console.log("延迟加载")
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