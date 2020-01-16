class TimeTableMilestones extends TimeTable {
    
    constructor(params) {
        super(params);
        this.loadItems({fromDate:params.dates.fromDate, toDate:params.dates.toDate, keywords:''}, 1);
    }
    
    loadItems(queryData, page) {
        let slotItem = this.slotItems, milestone;
        
        if (typeof queryData.toDate !== 'object') {
            queryData.toDate = super.formatDate(queryData.toDate, 'DB_DATE')
        }
        
        if (typeof queryData.fromDate !== 'object') {
            queryData.fromDate = super.formatDate(queryData.fromDate, 'DB_DATE')
        }
        
        paneljs.fetch({type:'api', call:'milestones/list', postData:{toDate:queryData.toDate, fromDate:queryData.fromDate, page:page, keywords:queryData.keywords}}, (data) => {
            console.log(data);
            data = data.data;
            for (var item in data) {
                milestone = data[item];
                
                if (!(milestone.productID in this.rows)) this.rows[milestone.productID] = {
                    rowID: milestone.productID,
                    title: milestone.product,
                    slotItems: {}
                }
                
                this.slotItems[milestone.milestoneID] = {
                    slotID: milestone.milestoneID,
                    startDate: milestone.startDate.replace(/\-/g, ''),
                    endDate: milestone.targetDate.replace(/\-/g, ''),
                    title: milestone.title,
                    level: milestone.level,
                    parent: milestone.parentMilestone,
                    slotItems: {}
                }
                
                if (milestone.level == 1) this.rows[milestone.productID].slotItems[milestone.milestoneID] = milestone.milestoneID;
                else this.slotItems[milestone.parentMilestone].slotItems[milestone.milestoneID] = milestone.milestoneID;
                
                //insert into slotItems
                //super.linkSlotItem(slotItem, this.slotItems[milestone.milestoneID]);
                //insert item
                //super.insertSlotItem(this.slotItems[milestone.milestoneID]);
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
    
    
    loadSlotItemEvents(item) {
        let thisClass = this;
        item.find('.slot-icon-info').click(function () {
            $(this).parent().siblings('.slot-dropdown-content').toggleClass('active');
        });
        
        item.find('.slot-icon-next-level').click(function () {
            thisClass.fetchNextLevel($(this).closest('[data-slotid]').attr('data-slotid'));
        });
        
        item.find('.slot-dropdown-item').click(function () {
            switch ($(this).attr('data-action')) {
                case 'info':
                    thisClass.displayMilestoneInfo($(this).closest('[data-slotID]').attr('data-slotID'));
                    break;
                case 'edit': break;
                case 'add':
                    thisClass.createNewItemPopout({
                        level: parseInt($(this).closest('[data-slotID]').attr('data-level'))+1,
                        id: $(this).closest('[data-slotID]').attr('data-slotID'),
                        message: 'Creating a New Milestone For '+$(this).closest('[data-slotID]').find('.slot-item-title-text').text()
                    });
                    break;
                case 'remove': break;
            }
        });
    }
    
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
            body: `<form>
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
                        <checkbox-toggle></checkbox-toggle>
                        <checkbox-text>Day</checkbox-text>
                    </checkbox>
                    <checkbox>
                        <checkbox-toggle></checkbox-toggle>
                        <checkbox-text>Week</checkbox-text>
                    </checkbox>
                    <checkbox>
                        <checkbox-toggle></checkbox-toggle>
                        <checkbox-text>Month</checkbox-text>
                    </checkbox>
                </checkbox-area>
                <h3>Keywords</h3>
                <h5>Each keyword is seperated with a space</h5>
                <label>Keywords</label>
                <input type="text" name="keywords">
                <h3>Included Products</h3>
                <div class="timetable-popout-data">
                    <div class="loading"></div>
                </div>
                <h3>Included Departments</h3>
                <div class="timetable-popout-data">
                    <div class="loading"></div>
                </div>
                <h3>Included Owners</h3>
                <div class="timetable-popout-data">
                    <div class="loading"></div>
                </div>
            </form>`
        };
        
        let classObj = this;
        super.createPopout(popoutInfo, (data) => {
            data.find('[data-name=milestone-close]').click(function () {
                data.addClass('close');
                setTimeout(function () {
                    data.remove();
                }, 300);
            });
            
            data.find('[data-name=milestone-search]').click(function () {
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
                classObj.dates = classObj.incrementDate(classObj.formatDate(fromDate, 'REV_DB_DATE'), classObj.formatDate(toDate, 'REV_DB_DATE'), classObj.jump);
                classObj.loadItems({
                    toDate: toDate,
                    fromDate: fromDate,
                    keywords: formData.find('input[name=keywords]').val()
                }, 1);
            });
        });
    }
    

}