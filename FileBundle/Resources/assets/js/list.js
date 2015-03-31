
define(['jquery', 'bootstrap', 'cms/core/api', 'cms/file/browser/browser'], function ($, bs, api, browser) {
    $(document).ready(function(){

        browser.addListener(browser.events.SELECT, function(items){
            console.log(items);
        });
        browser.attach(document);
    });
});
