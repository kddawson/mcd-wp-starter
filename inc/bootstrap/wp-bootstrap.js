// add twitter bootstrap classes and color based on how many times tag is used
// @todo register and enqueue this file if required

function addTwitterBSClass(thisObj) {
    var title = jQuery(thisObj).attr('title');
    if (title) {
        var titles = title.split(' ');
        if (titles[0]) {
            var num = parseInt(titles[0],10);
            if (num > 0)
                jQuery(thisObj).addClass('label label-default');
            if (num == 2)
                jQuery(thisObj).addClass('label label-info');
            if (num > 2 && num < 4)
                jQuery(thisObj).addClass('label label-success');
            if (num >= 5 && num < 10)
                jQuery(thisObj).addClass('label label-warning');
            if (num >=10)
                jQuery(thisObj).addClass('label label-important');
        }
    }
    else
        jQuery(thisObj).addClass('label');
    return true;
}

// as the page loads, call these scripts
jQuery(document).ready(function($) {

    // modify tag cloud links to match up with twitter bootstrap
    $(".tagcloud a").each(function() {
        addTwitterBSClass(this);
        return true;
    });

    $("p.tags a").each(function() {
        addTwitterBSClass(this);
        return true;
    });

    $('.alert-message').alert();

    $('.dropdown-toggle').dropdown();

});
