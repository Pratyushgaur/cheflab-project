$('#legal_document_form').validate({
   rules: {
      heading: {
         required: true,
      },
      description: {
         required: true
      }
   },
   messages: {

      heading: {
         required: "Enter legal document heading"
      },
      description: {
         required: "Enter Description"
      }
   }
});