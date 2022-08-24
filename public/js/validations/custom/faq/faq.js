$('#faq_form').validate({
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
         required: "Enter Question"
      },
      description: {
         required: "Enter Answer"
      }
   }
});