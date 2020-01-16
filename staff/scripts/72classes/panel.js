class Panel {
    
    fetch(fetchData, callback) {
        let url, uniqueID = null;
        switch (fetchData.type) {
            case 'app':
            case 'content':
            case 'section':
                uniqueID = this.newFetch();
            case 'api':
                url = '/staff/'+fetchData.type+'/'+fetchData.call;
                break;
            default:
                return false;
        }

        if (!('postData' in fetchData) || fetchData.postData.length === 0) fetchData.postData = {};
        $.post(url, fetchData.postData).fail(function (data) {
            if (uniqueID != null && paneljs.fetchID != uniqueID) return false; //throwaway result
            if (data.status == 440) {
                alert('Your session has expired. You will be taken to the login page.');
                window.location.href = "login.php";
            }

            let responseData = data.responseJSON;
            if (responseData === undefined) addNotif('Unexpected Error', 'An unexpected error occured.', 2);
            else addNotif(responseData.title, responseData.message, 2);
            callback({status:false, data:responseData});
        }).done(function (data) {
            if (uniqueID != null && paneljs.fetchID != uniqueID) return false; //throwaway result
            callback({status:true, data:data});
        });
    }
    
    newFetch() {
        return this.fetchID = this.genID(10);
    }
    
    genID(rounds) {
        if (rounds-- > 0) return Math.random().toString(36).substr(2, 9)+''+this.genID(rounds);
        return Math.random().toString(36).substr(2, 9);
    }
    
    setProject(projectID) {
        this.proj = new Project(projectID);
    }
    
    setPopup(theContent, type) {
        let popupID = this.genID(2), popup = `<div data-popupID="`+popupID+`" class="panel panel-popup">`+theContent+`</div>`;
        
        if (!$('panel-content').hasClass('panel-popup-active'))
            $('panel-content').addClass('panel-popup-active');
            
        if (type == 0) {
            return {result:popupID, div:popup}; //called from inside panel-content, allows user to handle div
        } else if (type == 1) {
            $('body').append(popup);
            return {result:popupID};
        }
        return {result:false};
    }
    
    closePopup(popupID) {
        if ($('.panel-popup').length == 1)
            $('panel-content').removeClass('panel-popup-active');
            
        if ($('[data-popupID='+popupID+']').length == 1) {
            $('[data-popupID='+popupID+']').remove();
        }
    }
    
}

const paneljs = new Panel();