class TimeTableAssignments extends TimeTable {

    constructor(params) {
        super(params);
        this.loadItems({fromDate:params.dates.fromDate, toDate:params.dates.toDate, keywords:''}, 1);
    }

    loadItems(queryData, page) {
        let slotItems = this.slotItems, rowData = this.rows;



        // if (typeof queryData.toDate !== 'object') {
        //     queryData.toDate = super.formatDate(queryData.toDate, 'DB_DATE')
        // }

        // if (typeof queryData.fromDate !== 'object') {
        //     queryData.fromDate = super.formatDate(queryData.fromDate, 'DB_DATE')
        // }


        paneljs.fetch({type:'api', call:'assignments/list', postData:{endDate:queryData.toDate, startDate:queryData.fromDate, page:page, keywords:queryData.keywords}}, (data) => {
            console.log(data);
            data = data.data;


            // for (var item in data) {
            //     milestone = data[item];

            //     if (!(milestone.productID in this.rows)) this.rows[milestone.productID] = {
            //         rowID: milestone.productID,
            //         title: milestone.product,
            //         slotItems: {}
            //     }

            //     this.slotItems[milestone.milestoneID] = {
            //         slotID: milestone.milestoneID,
            //         startDate: milestone.startDate.replace(/\-/g, ''),
            //         endDate: milestone.targetDate.replace(/\-/g, ''),
            //         title: milestone.title,
            //         level: milestone.level,
            //         parent: milestone.parentMilestone,
            //         slotItems: {}
            //     }

            //     if (milestone.level == 1) this.rows[milestone.productID].slotItems[milestone.milestoneID] = milestone.milestoneID;
            //     else this.slotItems[milestone.parentMilestone].slotItems[milestone.milestoneID] = milestone.milestoneID;

            //     //insert into slotItems
            //     //super.linkSlotItem(slotItem, this.slotItems[milestone.milestoneID]);
            //     //insert item
            //     //super.insertSlotItem(this.slotItems[milestone.milestoneID]);
            // }
            let epicItems = {}, storyItems = {}, assignment;
            for (var item in data) {
                assignment = data[item];
                if (assignment.sagaID != null && assignment.epicID != null && assignment.storyID != null) {

                    //Saga
                    if (!(assignment.sagaID in rowData)) rowData[assignment.sagaID] = {
                        rowID: assignment.sagaID,
                        title: assignment.saga,
                        //slotItems: {},
                        children: {},
                        type: 'Saga'
                    }


                    //Epic
                    if (!(assignment.epicID in rowData[assignment.sagaID].children)) {
                        rowData[assignment.epicID] = {
                            rowID: assignment.epicID,
                            title: assignment.epic,
                            children: {},
                            type: 'Epic'
                            //slotItems: {},
                            //level: 1
                        }
                        rowData[assignment.sagaID].children[assignment.epicID] = assignment.epicID;
                    }


                    //Story
                    if (!(assignment.storyID in rowData[assignment.epicID].children)) {
                        rowData[assignment.storyID] = {
                            rowID: assignment.storyID,
                            title: assignment.story,
                            slotItems: {},
                            type: 'Story'
                            //level: 1
                        }
                        rowData[assignment.epicID].children[assignment.storyID] = assignment.storyID;
                    }


                    //Assignment
                    slotItems[assignment.assignmentID] = {
                        slotID: assignment.assignmentID,
                        startDate: assignment.startingDate.replace(/\-/g, ''),
                        endDate: assignment.endDate.replace(/\-/g, ''),
                        title: assignment.title,
                        level: 1,
                        slotItems: {}
                    }


                    //Link Assignment to the Saga
                    //rowData[assignment.sagaID].slotItems[assignment.assignmentID] = assignment.assignmentID;
                    rowData[assignment.storyID].slotItems[assignment.assignmentID] = assignment.assignmentID;
                }
            }

            super.updateTable();
        });

    }

    fetchNextLevel(slotID) {
        let slotItem = this.slotItems[slotID], milestone;
        //fetch
        paneljs.fetch({type:'api', call:'milestones/next-level', postData:{parentID:slotID}}, (data) => {
            data = data.data;
            for (var item in data) {
                milestone = data[item];

                this.slotItems[milestone.milestoneID] = {
                    slotID: milestone.milestoneID,
                    startDate: milestone.startDate.replace(/\-/g, ''),
                    endDate: milestone.originalTargetDate.replace(/\-/g, ''),
                    title: milestone.title,
                    level: milestone.level,
                    parent: milestone.parentMilestone,
                    slotItems: {}
                }

                //insert into slotItems
                super.linkSlotItem(slotItem, this.slotItems[milestone.milestoneID]);
                //insert item
                super.insertSlotItem(this.slotItems[milestone.milestoneID]);
            }

            //update styling
            super.updateStyling();
        });
    }

    //加载项目事件
    loadSlotItemEvents(item) {

        let thisClass = this;
        // console.log(item);
        // if(!item.length) {
        //     setTimeout(function () {
        //         thisClass.loadSlotItemEvents(item);
        //     },500);
        //     return;
        // }
        // console.log("ok");
        item.find('.slot-icon-info').click(function () {
            console.log('toggle click');
            $(this).parent().siblings('.slot-dropdown-content').toggleClass('active');
        });
        // console.log("-------------------------");
        // item.find('.timetable-icon-menu').click(function () {
        //     console.log("jjjj")
        //     thisClass.createMenuFilter();
        // })

        item.find('.slot-icon-next-level').click(function () {
            thisClass.fetchNextLevel($(this).closest('[data-slotid]').attr('data-slotid'));
        });

        item.find('.slot-dropdown-item').click(function () {
            switch ($(this).attr('data-action')) {
                case 'info':
                    thisClass.displayMilestoneInfo($(this).closest('[data-slotID]').attr('data-slotID'));
                    break;
                case 'edit': break;
                case 'view':
                    thisClass.createNewViewupdate({
                        level: parseInt($(this).closest('[data-slotID]').attr('data-level'))+1,
                        id: $(this).closest('[data-slotID]').attr('data-slotID'),
                        message: 'Creating a New Milestone For '+$(this).closest('[data-slotID]').find('.slot-item-title-text').text()
                    });
                    break;
                case 'add':
                    thisClass.createNewAddPercentComplete({
                        level: parseInt($(this).closest('[data-slotID]').attr('data-level'))+1,
                        id: $(this).closest('[data-slotID]').attr('data-slotID'),
                        message: 'Creating a New Milestone For '+$(this).closest('[data-slotID]').find('.slot-item-title-text').text()
                    });
                    break;
                case 'remove': break;
            }
        });
    }
    //创建新弹窗项目
    createNewItemPopout(parentData) {
        let popoutInfo = {
            icons: [
                {
                    icon: '<i class="fas fa-times"></i>',
                    dataName: 'milestone-close'
                },
                {
                    icon: '<i class="fas fa-check"></i>',
                    dataName: 'milestone-add'
                }
            ],
            photo: null,
            body: `<form>
                <h5>`+parentData.message+`</h5>
                <h2>New Level `+parentData.level+` Milestone</h2>
                <h3>Information</h3>
                <label>Title</label>
                <input name="title">
                <label>Description</label>
                <textarea name="description"></textarea>
                <h3>Dates</h3>
                <h5>{date-range-message}</h5>
                <label>Starting Date</label>
                <div class="input-multiline">
                    <input type="number" name="fromDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="fromDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="fromDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <label>Target Date</label>
                <div class="input-multiline">
                    <input type="number" name="toDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="toDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="toDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <h3>Owners</h3>
                <label>Owner</label>
                <div class="input-autocomplete" data-category="milestones" data-item="owner">
                    <input type="text" autocomplete="off">
                    <input type="hidden" name="owner">
                    <div class="autocomplete-list"></div>
                </div>
                <label>Senior Owner</label>
                <div class="input-autocomplete" data-category="milestones" data-item="senior-owner">
                    <input type="text" autocomplete="off">
                    <input type="hidden" name="senior-owner">
                    <div class="autocomplete-list"></div>
                </div>
                <h3>Other</h3>
                <h5>Fields include dropdown autocomplete</h5>
                <label>Location</label>
                <div class="input-autocomplete" data-category="milestones" data-item="location">
                    <input type="text" autocomplete="off">
                    <input type="hidden" name="location">
                    <div class="autocomplete-list"></div>
                </div>
                `+(parseInt(parentData.level) === 1 ? `<label>Type</label>
                <div class="input-autocomplete" data-category="milestones" data-item="type">
                    <input type="text" autocomplete="off">
                    <input type="hidden" name="type">
                    <div class="autocomplete-list"></div>
                </div>
                <label>Product</label>
                <div class="input-autocomplete" data-category="milestones" data-item="product">
                    <input type="text" autocomplete="off">
                    <input type="hidden" name="product">
                    <div class="autocomplete-list"></div>
                </div>` : ``)+`
                <label>RAG</label>
                <h5>Options are G for green (everything is on time or early), A for amber (the milestone is close to being late), R for red (the milestone is late)</h5>
                <input type="text" name="rag">
                <input type="hidden" name="level" value="`+parentData.level+`">
                <input type="hidden" name="parentID" value="`+parentData.id+`">
                </form>`
        };

        super.createPopout(popoutInfo, (data) => {
            data.find('.input-autocomplete').each(function () {
                autocomplete($(this));
            });

            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });

            data.find('[data-name=milestone-add]').click(function () {
                let formData = $(this).closest('timetable-popout').find('form').serializeArray();
                paneljs.fetch({type:'api', call:'milestones/create', postData:formData}, (data) => {
                    console.log(data);
                });
            });
        });
    }

    //创建createNewAddPercentComplete
    createNewAddPercentComplete(parentData) {
        let popoutInfo = {
            icons: [
                {
                    icon: '<i class="fas fa-times"></i>',
                    dataName: 'milestone-close'
                },
                {
                    icon: '<i class="fas fa-check"></i>',
                    dataName: 'add-addUpdate'
                }
            ],
            photo: null,
            body: `<form id="add_addUpdate">
                <h2>Add Update</h2>
                <h3>Information</h3>
                <label>percentComplete</label>
                <input  type="number" name="percentage" placeholder="Please enter the percent">
                <h3>Information</h3>
                <label>Message</label>
                <textarea name="message" style="resize: none" rows="5" placeholder="Please enter a message" ></textarea>
        
                </form>`
        };

        super.createPopout(popoutInfo, (data) => {
            data.find('.input-autocomplete').each(function () {
                autocomplete($(this));
            });

            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });

            data.find('[data-name=add-addUpdate]').click(function () {
                console.log(parentData.id);
                alert
                var percentComplete=$("#add_addUpdate input[name='percentage']").val();
                var message=$("#add_addUpdate textarea[name='message']").val();
                //判断字符0~100以内（包括0）
                let grep=/^(\d{1,2}(\.\d+)?|100|NA)$/;
                if(percentComplete=="" || percentComplete==null || percentComplete==undefined){
                    alert("PercentComplete cannot be empty！")
                }else if (!grep.test(percentComplete)){
                    alert("Please enter percentComplete within 0 to 100");
                }else if (message.length<5){
                    alert("You must enter more than five message characters!")
                }else{
                    console.log({updateDetails:{percentComplete, message}});
                    $.ajax({
                        type:"post",
                        url:"/staff/api/assignments/update",
                        data:{assignmentID:parentData.id, updateDetails:{percentComplete, message}},
                        success:function (data) {
                            alert("success")
                            console.log(data);
                        }
                    })
                }


            });
        });
    }

    //创建createNewViewupdate
    createNewViewupdate(parentData) {
        let popoutInfo = {
            icons: [
                {
                    icon: '<i class="fas fa-times"></i>',
                    dataName: 'milestone-close'
                }
                // ,
                // {
                //     icon: '<i class="fas fa-check"></i>',
                //     dataName: 'add-Viewupdate'
                // }
            ],
            photo: null,
            body: `<form id="add_Viewupdate">
                        <h2>View Updates</h2>
                        <label>percentComplete</label>
                        <input name="percentComplete" type="number" placeholder="Please enter the percent" disabled>
                        
                        <label>Description</label>
                        <textarea name="message" style="resize: none" rows="3" placeholder="Please enter a message" disabled></textarea>
                        
                        <label>created update</label>
                        <input name="createdUpdate" type="text" placeholder="Please enter the person who created the update" disabled >
            
                        <label>UpdateTime</label>
                        <input type="text" name="UpdateTime" disabled>
                    </form>
                    <form id="add_ViewupdateHistory">
                        <h2 class="historyView" style="cursor: pointer;">History View Updates</h2>
                    </form>`
        };
        $('timetable-popout').remove();
        super.createPopout(popoutInfo, (data) => {
            $("#add_Viewupdate input[name='percentComplete']").val();
            $("#add_Viewupdate input[name='message']").val();
            $("#add_Viewupdate input[name='createdUpdate']").val();
            $("#add_Viewupdate input[name='UpdateTime']").val();
            $.ajax({
                      type:"POST",
                url:"/staff/api/assignments/viewupdates",
                data:{assignmentID:parentData.id},
                success:function (data) {
                    if (data!==null && data!=="" && data!==undefined){
                        //最近一次修改赋值
                        let percentComplete=data[0].percentComplete;
                        let updateMessage=data[0].updateMessage;
                        let UpdateTime = data[0].updatedOn.slice(0,-9);
                        let createdUpdateName='';
                        if (data[0].firstName!=null && data[0].middleName!=null && data[0].lastName!=null){
                            createdUpdateName=data[0].firstName+" "+data[0].middleName+" "+data[0].lastName;
                        }else if (data[0].firstName!=null && data[0].middleName!=null){
                            createdUpdateName=data[0].firstName+" "+data[0].middleName;
                        }else if (data[0].firstName!=null && data[0].lastName!=null){
                            createdUpdateName=data[0].firstName+" "+data[0].lastName;
                        }
                        $("#add_Viewupdate input[name='percentComplete']").val(percentComplete);
                        $("#add_Viewupdate textarea[name='message']").val(updateMessage);
                        $("#add_Viewupdate input[name='createdUpdate']").val(createdUpdateName);
                        $("#add_Viewupdate input[name='UpdateTime']").val(UpdateTime);

                        //历史修改记录
                        let createdUpdateNameHistory;
                        let str='';
                        for (var i=0;i<data.length;i++){
                            if (Object.keys(data[i]).length>0){
                                if (data[i].firstName!=null && data[i].middleName!=null && data[i].lastName!=null){
                                    createdUpdateNameHistory=data[i].firstName+" "+data[i].middleName+" "+data[i].lastName;
                                }else if (data[i].firstName!=null && data[0].middleName!=null){
                                    createdUpdateNameHistory=data[i].firstName+" "+data[i].middleName;
                                }else if (data[i].firstName!=null && data[i].lastName!=null){
                                    createdUpdateNameHistory=data[i].firstName+" "+data[i].lastName;
                                }
                                str+=`<div class="toggleView" style="border-top: 1px solid #212121;border-bottom: 1px solid #212121;margin: 50px 0px;" >
                                        <label>percentComplete</label>
                                        <input value="${data[i].percentComplete}" type="number"  disabled>
                                        <label>Description</label>
                                            <textarea  style="resize: none" rows="3"  disabled>${data[i].updateMessage}</textarea>
                                        <label>created update</label>
                                            <input value="${createdUpdateNameHistory}" type="text"  disabled >
                                        <label>UpdateTime</label>
                                            <input value="${data[i].updatedOn.slice(0,-9)}"  type="text"  disabled>
                                    </div>`
                            }
                        }
                        $("#add_ViewupdateHistory").append(str);

                    }else{
                        alert("No update data for now！")
                    }


                }
            })
            
            data.find('#add_ViewupdateHistory .historyView').click(function () {
                    $(".toggleView").toggle(500);

            })
            
            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });

            data.find('[data-name=add-Viewupdate]').click(function () {

            });

        });
    }

    //显示里程碑信息
    displayMilestoneInfo(milestoneID) {
        paneljs.fetch({type:'api', call:'milestones/info', postData:{milestoneID:milestoneID}}, (data) => {
            if (!data) return false;
            else data = data.data;
            console.log(data);
            let popoutInfo = {
                icons: [
                    {
                        icon: '<i class="fas fa-times"></i>',
                        dataName: 'milestone-close'
                    },
                    {
                        icon: '<i class="fas fa-pen"></i>',
                        dataName: 'milestone-edit'
                    },
                    {
                        icon: '<i class="fas fa-plus"></i>',
                        dataName: 'milestone-update'
                    }
                ],
                photo: '/staff/media/images/avatars/'+data.ownerAvatar,
                body: `<h2>`+data.title+`</h2>
                <h5>Owner: `+data.theOwnerName+` - Senior Owner: `+data.theSeniorOwnerName+`</h5>
                <h5>Level `+data.level+` - `+data.typeTitle+`</h5>
                <h5>Product of `+data.productTitle+`</h5>
                <h5>Location: `+data.locationTitle+`</h5>
                <h5>RAG Rating: `+data.RAG+`</h5>
                <h3>About This Milestone</h3>
                <p>`+data.description+`</p>
                <h3>Milestone Analytics</h3>
                <div class="timetable-popout-data">
                    <div class="loading"></div>
                </div>
                <h3>Milestone Updates</h3>
                <div class="timetable-popout-data">
                    <div class="loading"></div>
                </div>`
            };

            super.createPopout(popoutInfo, (data) => {
                data.find('[data-name=milestone-close]').click(function () {
                    data.addClass('close');
                    setTimeout(function () {
                        data.remove();
                    }, 300);
                });
            });
        });
    }

    //创建搜索提交需要搜索的信息
    createSearchFilter() {
        let popoutInfo = {
            icons: [
                {
                    icon: '<i class="fas fa-times"></i>',
                    dataName: 'milestone-close'
                },
                {
                    icon: '<i class="fas fa-search"></i>',
                    dataName: 'milestone-search'
                }
            ],
            photo: null,
            body: `<form id="common-form">
                <h2>Search Milestones</h2>
                <h3>Date Range</h3>
                <label>From</label>
                <div class="input-multiline">
                    <input type="number" name="fromDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="fromDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="fromDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <label>To</label>
                <div class="input-multiline">
                    <input type="number" name="toDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="toDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="toDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <h3>View</h3>
                <checkbox-area>
                    <checkbox>
                        <input  class="checkbox-toggle" name="Day" type="checkbox" value="1" />
                        <checkbox-text>Day</checkbox-text>
                    </checkbox>
                    <checkbox>
                        <input class="checkbox-toggle" name="Week" type="checkbox" value="7" />
                        <checkbox-text>Week</checkbox-text>
                    </checkbox>
                    <checkbox>
                        <input class="checkbox-toggle" name="Month" type="checkbox" value="30" />
                        <checkbox-text>Month</checkbox-text>
                    </checkbox>
                </checkbox-area>
                <h3>Keywords</h3>
                <h5>Each keyword is seperated with a space</h5>
                <label>Keywords</label>
                <input type="text" name="keywords">
<!--                <h3>Included Products</h3>-->
<!--                <div class="timetable-popout-data">-->
<!--                    <div class="loading"></div>-->
<!--                </div>-->
<!--                <h3>Included Departments</h3>-->
<!--                <div class="timetable-popout-data">-->
<!--                    <div class="loading"></div>-->
<!--                </div>-->
<!--                <h3>Included Owners</h3>-->
<!--                <div class="timetable-popout-data">-->
<!--                    <div class="loading"></div>-->
<!--                </div>-->
                
            </form>`
        };


        let classObj = this;
        $('timetable-popout').remove();
        super.createPopout(popoutInfo, (data) => {
            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });
            //点击搜索图标触发
            data.find('[data-name=milestone-search]').click(function () {
                let checkboxValue;
                //获取复选框选中的值
                $.each($('#common-form input:checkbox'),function(){
                    if(this.checked){
                        checkboxValue=$(this).val();
                        console.log($(this).val())
                    }
                });

                var dayData=$('#common-form input[name="Day"]').prop('checked');
                var weekData=$('#common-form input[name="Week"]').prop('checked');
                var monthData=$('#common-form input[name="Month"]').prop('checked');

                //判断选择日期是否为空
                var toDataOne=$('input[name^=toDate]').eq(0).val();
                var toDataTwo=$('input[name^=toDate]').eq(2).val();
                var toDataThree=$('input[name^=toDate]').eq(3).val();
                var fromDateOne=$('input[name^=fromDate]').eq(0).val();
                var fromDateTwo=$('input[name^=fromDate]').eq(1).val();
                var fromDateThree=$('input[name^=fromDate]').eq(2).val();
                $('input[name^=toDate]').eq(1).val();
                $('input[name^=toDate]').eq(2).val();

                if (toDataOne=='' || toDataTwo=='' || toDataThree==''){
                    alert("Please fill out the toDate");
                }else if (fromDateOne==='' || fromDateTwo==='' || fromDateThree===''){
                    alert("Please fill out the fromDate");
                } else if (!dayData && !weekData && !monthData){
                    alert("Please select one item View");
                } else{

                    //将选中的值赋予classObj.jump
                    classObj.jump=checkboxValue;

                    let formData = $(this).closest('timetable-popout').find('form'), toDate = {
                        year: formData.find('input[name^=toDate]').eq(0).val(),
                        month: formData.find('input[name^=toDate]').eq(1).val(),
                        day: formData.find('input[name^=toDate]').eq(2).val()
                    }, fromDate = {
                        year: formData.find('input[name^=fromDate]').eq(0).val(),
                        month: formData.find('input[name^=fromDate]').eq(1).val(),
                        day: formData.find('input[name^=fromDate]').eq(2).val()
                    };


                    classObj.resetTable();
                    classObj.dates = classObj.incrementDate(classObj.formatDate(fromDate, 'REV_DASH_DB_DATE'), classObj.formatDate(toDate, 'REV_DASH_DB_DATE'), classObj.jump);
                    classObj.loadItems({
                        toDate: formData.find('input[name^=toDate]').eq(0).val()+"/"+formData.find('input[name^=toDate]').eq(1).val()+"/"+formData.find('input[name^=toDate]').eq(2).val(),
                        fromDate: formData.find('input[name^=fromDate]').eq(0).val()+"/"+formData.find('input[name^=fromDate]').eq(1).val()+"/"+formData.find('input[name^=fromDate]').eq(2).val(),
                        keywords: formData.find('input[name=keywords]').val()
                    }, 1);
                }
            });
        });
    }

    //Tracking Reports sub-level sidebar（左边的侧栏）
    createNewPopup() {
        $("sidebar-reports").remove();
        let objcta = this;
        let popoutInfo = {
            body: `<ul>
                <li class="list-child">
                    <span class="list-child-span addAsignment">Add New Assignment</span>
                </li>
                <li class="list-child " >
                    <span class="list-child-span">View Analytics</span>
                         <li class="list-child">
                    <span class="list-child-span exportAsCsv" id="js">
                        <a id="list-export" style="text-decoration:none;color: #151515;">Export As Csv</a>
                    </span>
                </li>
                <li class="list-child">
                    <span class="list-child-span">Export As PDF</span>
                </li>
            </ul>`
        }

        this.table.find('timetable-options').append(`<sidebar-reports class="sidebarReports">` + popoutInfo.body + `</sidebar-reports>`);
        this.table.find('.addAsignment').click(function () {
            objcta.createNewAssignment({});
        })




        this.table.find('.exportAsCsv').click(function () {
            console.log("导出CSV");
            console.log(TTM);
            // console.log(Object.keys(TTM.dates).length);
            // ttmtoDate=TTM.formatDate(item,'REV_DATE_ID');
            //要导出的数据
            let rowsData=TTM.rows;
            let slotItemsData=TTM.slotItems;
            console.log(TTM);
            console.log(rowsData);
            //列标题，逗号隔开
            let str=`Saga,Epic,Story,Task,startDate,endDate\n`;
            let sagaid={};
            let times;
            //20180808
            //插入字符方法
            function insertStr(soure, start, newStr){
                return soure.slice(0, start) + newStr + soure.slice(start);
            }
            var newStartDate;
            var newEndDate;

            // console.log(_NewOccurTime)


                for (let  itme in rowsData) {

                    if (rowsData[itme].type == "Saga") {
                        str+=`${rowsData[itme].title}`;
                        for (let j in rowsData[itme].children) {
                            if (rowsData[j].rowID==j){
                                str+=`\n,${rowsData[j].title+'\n'}`;
                                for (let k in rowsData[j].children){
                                    // console.log('children',k)
                                    if (rowsData[k].rowID==k){
                                        str+=`,,${rowsData[k].title+'\n'}`;
                                        for (let y in rowsData[k].slotItems){
                                            for (let s in slotItemsData){
                                                if (slotItemsData[s].slotID==y){
                                                    newStartDate=insertStr(insertStr(insertStr(`${slotItemsData[s].startDate}`,4,"-"),7,"-"),10,"  ");
                                                    newEndDate=insertStr(insertStr(insertStr(`${slotItemsData[s].endDate}`,4,"-"),7,"-"),10,"  ");
                                                    // console.log(newStartDate)
                                                    str+=`,,,${slotItemsData[s].title},${newStartDate},${newEndDate+'\n'}`;
                                                    // console.log('SlotItems',slotItemsData[s].title)
                                                }
                                            }
                                        }
                                        // console.log('Story',rowsData[k])
                                    }
                                }
                                // console.log('epic',rowsData[j])
                            }
                            {sagaid[itme]=rowsData[itme].children}
                            /*for (let Story in epic.children){
                                console.log(Story)
                            }*/
                        }
                    }
                }

            //encodeURIComponent解决中文乱码， \ufeff是 ""
            let uri ='data:text/csv;charset=utf-8,\ufeff' + encodeURIComponent(str);
            //获取a标签
            let link=document.getElementById("list-export");
            // console.log(link);
            link.href = uri;
            //对下载的文件命名
            link.download="json数据表.csv"

        })
    }

    /*create New Add Assignment Popup(创建点击 new add Assignment 弹出的窗口)*/
    createNewAssignment(parentData){
        let classObj = this;

        let popoutInfo = {
            icons: [
                {
                    icon: '<i class="fas fa-times"></i>',
                    dataName: 'milestone-close'
                },
                {
                    icon: '<i class="fas fa-check"></i>',
                    dataName: 'milestone-addAssignments'
                }
            ],
            photo: null,
            body: `<form id="add_assignment_form">
                <h2>Add New Assignment</h2>
                <label>Assignment Title</label>
                <input name="title" type="text" class="assignment_Title" placeholder="Please enter the task title">
                <label>Assignment Description</label>
                <textarea name="description" class="assignment_Description" placeholder="Please describe the task here as clearly as possible"></textarea>
                <div class="selectAddAssignment">
                    <label>Legend</label>
                    <select class="addAssignment legend" name="legend">
                        <option value="0">Legend</option>
                    </select>
                    <label>Saga</label>
                    <select class="addAssignment saga" name="saga">
                        <option value="0">Saga</option>
                    </select>
                    <label>Epic</label>
                    <select class="addAssignment epic" name="epic">
                        <option value="0">Epic</option>
                    </select>
                    <label>Story</label>
                    <select class="addAssignment story" name="story">
                        <option value="0">Story</option>
                    </select>
                </div>
                <h3>Date Range</h3>
                <label>Starting Date</label>
                <div class="input-multiline" id="assignment_input">
                    <input type="number" name="fromDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="fromDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="fromDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <label>Target Date</label>
                <div class="input-multiline" id="assignment_inputTo">
                    <input type="number" name="toDate[year]" placeholder="YYYY" pattern="[0-9]{4}">
                    <input type="number" name="toDate[month]" placeholder="MM" pattern="[0-9]{2}">
                    <input type="number" name="toDate[day]" placeholder="DD" pattern="[0-9]{2}">
                </div>
                <h3>Estimated Story Points</h3>
                <label>Task points</label>
                <input class="task_points" type="text" name="points" placeholder="Please enter the number of story points out of 10">
                <h3>View</h3>
                </form>
                <div class="div_view"></div>`
        };
        $   ('timetable-popout').remove();
        super.createPopout(popoutInfo, (data) => {

            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });

            // 初始化Legend(Initialize the legend)
            $.ajax({
                type:"POST",
                url:"http://192.168.50.90/staff/api/stories/getchildren",
                data:{"storyID":"0", "type":"self"},
                success:function (data) {
                    var str='';
                    for (var  i in data){
                        str+=`<option value="${data[i].storyID}">${data[i].title}</option>`;
                    }
                    $('.selectAddAssignment .Legend').append(str);
                }
            })


            //初始化Saga数据(Initialize the saga)
            data.find('.selectAddAssignment .legend').change(function () {
                var str="<option value=\"0\">Saga</option>";
                //获取select Legend索引
                var selectid=$(".selectAddAssignment .legend").get(0).selectedIndex;
                if (selectid>0){
                    console.log("索引:"+selectid);
                    $(".selectAddAssignment .saga option").empty();
                    var storyid=$('.selectAddAssignment .legend option:selected').val();
                    $.ajax({
                        type:"post",
                        url:"http://192.168.50.90/staff/api/stories/getchildren",
                        data:{"storyID":storyid, "type":"legend"},
                        success:function (data) {
                            console.log(data);
                            for (var i in  data){
                                str+=`<option value="${data[i].storyID}">${data[i].title}</option>`;
                            }
                            $('.selectAddAssignment .saga').html(str);
                        }
                    })
                }else if (selectid==0){
                    console.log("legend的else")
                    $(".selectAddAssignment .saga option").remove();
                    // $('.selectAddAssignment .saga').html(str);
                    $(".selectAddAssignment .epic option").remove();
                    $(".selectAddAssignment .story option").remove();
                }
            })


            //初始化epic(Initialize the epic)
            data.find('.selectAddAssignment .saga').change(function () {
                var str="<option value=\"0\">Epic</option>";
                //获取select Legend索引
                var selectLegendid=$(".selectAddAssignment .legend").get(0).selectedIndex;
                var selectSagaid=$(".selectAddAssignment .Saga").get(0).selectedIndex;
                if(selectLegendid>0 && selectSagaid>0){
                    console.log("Saga索引:"+selectSagaid);
                    $(".selectAddAssignment .epic option").empty();
                    var sageid=$('.selectAddAssignment .saga option:selected').val();
                    console.log("saga的id："+sageid)
                    $.ajax({
                        type:"POST",
                        url:'http://192.168.50.90/staff/api/stories/getchildren',
                        data:{"storyID":sageid, "type":"saga"},
                        success:function (data) {
                            $.ajax({
                                type : "POST",
                                url:'/staff/app/1',
                                data: {'sagaID':sageid},
                                success:function (data) {
                                    $('.div_view').find('app[app-name="staff-list"]').remove();

                                    $('.div_view').append(data);
                                }
                            });
                            console.log(data);
                            for (var i in data){
                                str+=`<option value="${data[i].storyID}">${data[i].title}</option>`;
                            }
                            $(".selectAddAssignment .epic").html(str);
                        }
                    })
                }else if (selectSagaid==0){
                    $(".selectAddAssignment .epic option").remove();
                    $(".selectAddAssignment .story option").remove();
                }
            })

            //初始化Story(Initialize the story)
            data.find(".selectAddAssignment .epic").change(function () {
                var str="<option value=\"0\">Story</option>";
                //获取epic索引
                var selectedEpicId=$(".selectAddAssignment .epic").get(0).selectedIndex;
                var selectedSagacId=$(".selectAddAssignment .saga").get(0).selectedIndex;
                var selectedLegendId=$(".selectAddAssignment .legend").get(0).selectedIndex;
                if (selectedEpicId>0&&selectedSagacId>0&&selectedLegendId>0){
                    $(".selectAddAssignment .story option").empty();
                    var sageid=$('.selectAddAssignment .saga option:selected').val();
                    //获取epic选择option的val()值
                    var epicId=$(".selectAddAssignment .epic option:selected").val();
                    $.ajax({
                        type:"POST",
                        url:'http://192.168.50.90/staff/api/stories/getchildren',
                        data:{"storyID":epicId, "type":"epic"},
                        success:function (data) {
                            for (var i in  data){
                                str+=`<option value="${data[i].storyID}">${data[i].title}</option>`;
                            }
                            $(".selectAddAssignment .story").html(str);
                        }
                    })
                }else if (selectedEpicId==0){
                    $(".selectAddAssignment .story option").remove();
                }
            })


            //点击"√"图标触发
            data.find('[data-name=milestone-addAssignments]').click(function () {
                //获取标题、描述
                var assignment_title=$(".assignment_Title").val();
                var assignment_description=$(".assignment_Description").val();
                //获取saga
                var sagaValue=$(".selectAddAssignment .saga").val();
                //判断 Story是否选择,如果没有选择则无法创建任务。
                var storyValue=$(".selectAddAssignment .story").val();
                //Starting Date
                var startingDateYear=$('#assignment_input input[name^=fromDate]').eq(0).val();
                var startingDateMonth=$('#assignment_input input[name^=fromDate]').eq(1).val();
                var startingDateDay=$('#assignment_input input[name^=fromDate]').eq(2).val();
                //Target Date
                var targetDateYear=$("#assignment_inputTo input[name^=toDate]").eq(0).val();
                var targetDateMonth=$('#assignment_inputTo input[name^=toDate]').eq(1).val();
                var targetDateDay=$('#assignment_inputTo input[name^=toDate]').eq(2).val();
                //任务点数
                var task_points=$("#add_assignment_form .task_points").val();
                var regp = /^([0-9]|10)$/;

                let startDate=startingDateYear+"-"+startingDateMonth+"-"+startingDateDay;
                let endDate=targetDateYear+"-"+targetDateMonth+"-"+targetDateDay;
                //验证日期格式(yyyy-MM-dd)
                var reg = "^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)| (?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$";
                var regExp = new RegExp(reg);
                if (assignment_title==="" || assignment_title===undefined || assignment_title===null){
                    alert("Please enter the assignment  title！")
                } else if (assignment_description==="" || assignment_description===undefined || assignment_description===null){
                    alert("Please enter a description of the assignment!")
                }else if(storyValue < 1){
                    alert("Please select Story. You must create a task through the Story!")
                } else if(!regExp.test(startDate)){
                    alert("Please enter the start date, for example: 2019-01-01")
                }else if (!regExp.test(endDate)){
                    alert("Please enter the target date, for example: 2019-01-01")
                }else if (task_points === "" || !regp.test(task_points) || task_points==0){
                    alert("Please enter story points between 1 and 10 (Whole Numbers Only)!")
                }else{

                    //截取yyyy为yy
                    let filterStartingDateYear=startingDateYear.substring(2,4);
                    let filterTargetDateYear=targetDateYear.substring(2,4);
                    console.log(startingDateYear.substring(2,4));
                    console.log(targetDateYear.substring(2,4));
                    //修改时间格式dd/mm/yy
                    startDate=startingDateDay+"/"+startingDateMonth+"/"+filterStartingDateYear;
                    endDate=targetDateDay+"/"+targetDateMonth+"/"+filterTargetDateYear;
                    let staffList = [];
                    for (var i = 0; i < chosenStaff.length; i++) {
                        staffList.push({staffID:chosenStaff[i].staffID,name:chosenStaff[i].name});
                    }

                    var ttmfromDate, ttmtoDate, i = -1;
                    for (var item in TTM.dates) {
                        i++;
                        console.log(Object.keys(TTM.dates).length);
                        if (i== 0){
                            ttmfromDate = TTM.formatDate(item, 'REV_DATE_ID');
                            i++;
                        } else if (i==Object.keys(TTM.dates).length){
                            ttmtoDate=TTM.formatDate(item,'REV_DATE_ID');
                        }
                   }

                    fullPageLoad('on');
                    paneljs.fetch({type:'api', call:'assignments/create', postData:{
                            title: assignment_title,
                            desc: assignment_description,
                            staff: staffList,//viwe下选择某些用户的数据
                            category: null,//为null
                            startDate: startDate,
                            endDate: endDate,
                            storyPoints: task_points,//
                            repeat: 0,
                            projectID: sagaValue,//用select下拉框的Saga值
                            storyID:storyValue  //Story
                        }},(data) => {
                        data = data.data;
                        let addAssignmentDiv=({
                            assignmentID: data.assignmentID,
                            title: $('input[name=assignment-title]').val(),
                            desc: $('textarea[name=assignment-desc]').val(),
                            participants: chosenStaff.length,
                            endDate: $('input[name=assignment-end]').val()
                        });

                        fullPageLoad('off');
                        $('#assignment-creation').addClass('float-fade-out');
                        $('#assignment-creation').find('.float-fade-out').addClass('float-fade-out');
                        $('panel-content').children('.panel-popup-active').removeClass('panel-popup-active');
                        setTimeout(function () {
                            $('#assignment-creation').remove();
                        },750);


                        let formData = $(this).closest('timetable-popout').find('form'),
                            toDate = {
                                year: targetDateYear,
                                month: targetDateMonth,
                                day: targetDateDay
                            }, fromDate = {
                                year: startingDateYear,
                                month: startingDateMonth,
                                day: startingDateDay
                            };

                        //load data
                        //classObj.resetTable();
                        //classObj.dates = classObj.incrementDate(classObj.formatDate(fromDate, 'REV_DB_DATE'), classObj.formatDate(toDate, 'REV_DASH_DB_DATE'), classObj.jump);
                        classObj.loadItems({
                            toDate:ttmtoDate,
                            fromDate:ttmfromDate,
                            keywords:null
                        },1);
                        //remove right Popout data
                        setTimeout(function () {
                            console.log("remove");
                            $("timetable-popout").remove();
                        }, 300);
                    });
                }
            });

        });
    }
}