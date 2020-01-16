$(document).ready(function () {
  $('#assignments, #assignment-cms').css('height', window.innerHeight + 'px');

  $('.input-select-current').click(function () {
    $(this).parent().toggleClass('input-select-open');
  });
});

function updateDropDown(dropDown) {
  dropDown.parent().siblings('input').val(dropDown.attr('data-value'));
  dropDown.parent().siblings('.input-select-current').text(dropDown.text());
  dropDown.closest('.input-select').removeClass('input-select-open');
}

function addNotif(title, body, type) {
  var notifID = Math.ceil(Math.random() * 100000000000);
  switch (type) {
    case 1:
      var addClass = 'notif-good';
      break;
    case 2:
      var addClass = 'notif-bad';
      break;
    default:
      var addClass = '';
  }
  $('#sidebar-notif sidebar-content').prepend('<div notif-id="' + notifID + '" class="notif ' + addClass + '"><h4>' + title + '</h4><p>' + body + '</p></div>');
  $('.notif-animate-container').prepend('<div notif-id="' + notifID + '" class="notif notif-animate ' + addClass + '"><h4>' + title + '</h4><p>' + body + '</p></div>');

  var theNotif = $('div[notif-id=' + notifID + ']');

  theNotif.click(function(){$(this).remove()});

  setTimeout(function () {$('div.notif-animate[notif-id=' + notifID + ']').remove()}, 5000);
}



//History Push Pop
(function(history){
    var pushState = history.pushState;
    history.pushState = function(state) {
        return pushState.apply(history, arguments);
    }
})(window.history);

window.onpopstate = history.onpushstate = function(e) {
    loadPageURL(window.location.pathname);
}

function setPageURL(title, url) {
    window.history.pushState(null, title + ' - 72 Dragons Staff', url);
}

function loadPageURL(url) {
    console.log(url);
}

function formatTextToURL(text) {
    return text.replace(/[\W_]+/g,"-").toLowerCase();
}






