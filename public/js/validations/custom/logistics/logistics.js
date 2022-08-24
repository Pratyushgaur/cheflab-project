$('#logisticsform').validate({
   ignore: ".note-editor *",
        //ignore: [],
        debug: false,
   rules: {
      description: {
         required: true
      }
   },
   messages: {
      description: {
         required: "Enter Description"
      }
   }

});
