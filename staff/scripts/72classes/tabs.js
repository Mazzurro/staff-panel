class Tabs {
    constructor(tabID) {
        this.tabDiv = $('[data-tab-id='+tabID+']');
        this.body = this.tabDiv.find('.tab-body').eq(0);
        this.items = {};
        this.count = 0;
        this.activeTab = null;
        this.loadItems();
    }
    
    loadItems() {
        let currentItem;
        this.count = this.tabDiv.find('.tab-item').length;
        for (var i = 0; i < this.count; i++) {
            if (i === 0) this.activeTab = 0;
            currentItem = this.tabDiv.find('.tab-item').eq(i);
            this.items[i] = {
                id: currentItem.attr('data-tab'),
                text: currentItem.text(),
                div: currentItem
            };
        }
    }
    
    onSelect(callback) {
        for (var i = 0; i < this.count; i++) {
            this.setTabClick(i, (cb) => {
                callback(cb);
            });
        }
    }
    
    setTabClick(index, callback) {
        let tabObj = this;
        this.items[index].div.click(function () {
            tabObj.setActiveTab(index);
            tabObj.body.empty().addClass('loading');
            callback(tabObj.items[index]);
        });
    }
    
    setActiveTab(index) {
        this.items[this.activeTab].div.removeClass('active');
        this.activeTab = index;
        this.items[this.activeTab].div.addClass('active');
    }
    
    loadBody(contentData) {
        let tabObj = this;
        if (contentData.post === undefined || contentData.post.length === 0) contentData.post = {};
        switch(contentData.type) {
            case 'section':
                paneljs.fetch({type:'section',call:contentData.contentID, postData:contentData.post}, (section) => {
                    tabObj.body.removeClass('loading');
                    if (section.status) tabObj.setBody(section.data);
                });
                break;
        }
    }
    
    setBody(content) {
        this.body.html(content);
    }
}