(function ($) {
   Drupal.behaviors.autoRefreshInit = {
      attach: function (context, settings) {
         settings.autoRefresh = 1;
      }
   };
}(jQuery));


(function ($) {
   Drupal.behaviors.autoRefresh = {
      attach: function (context, settings) {

        var ajaxSettings = {
          url: '/hello/ajax',
          // If the old version of Drupal.ajax() needs to be used those
          // properties can be added
          base: 'myBase',
          // element: $(context).find('body')
        };

        var myAjaxObject = Drupal.ajax(ajaxSettings);

        
        // Declare a new Ajax command specifically for this Ajax object.
        myAjaxObject.commands.insert = function (ajax, response, status) {
         console.log(response);
         var command = response.command;
         $(response.selector).html(response.data);
         // alert('New content was appended to ' + response.selector);
        };
        

        // This command will remove this Ajax object from the page.
        myAjaxObject.commands.destroyObject = function (ajax, response, status) {
          Drupal.ajax.instances[this.instanceIndex] = null;
        };

        // Programmatically trigger the Ajax request.
        // console.log(settings);

        setInterval(function(){
           if(settings.autoRefresh){
           myAjaxObject.execute();
           }
        }, 1000);
      }
   };
}(jQuery));


