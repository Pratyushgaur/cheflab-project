$('#quality_compliance_form').validate({
   rules: {
      question: {
         required: true,
      },
      answer: {
         required: true
      }
   },
   messages: {

      question: {
         required: "Enter Heading"
      },
      description: {
         required: "Enter Description"
      }
   }
});