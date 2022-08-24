$('#workwithusform').validate({
    ignore: ".note-editor *",
    //ignore: [],
    debug: false,
    rules: {
        title: {
            required: true
        },
        description: {
            required: true
        }
    },
    messages: {

        title: {
            required: "Enter Title"
        },
        description: {
            required: "Enter Description"
        }
    }

});