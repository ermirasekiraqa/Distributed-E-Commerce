function sendEmail() {
    var params = {
        from_name: document.getElementById("full_name").value,
        email_id: document.getElementById("email_id").value,
        subject: document.getElementById("subject"),
        message: document.getElementById("message").value

    }

    emailjs.send("service_1dsk4ho", "template_sxz52qp", params).then(function (res) {
        alert("Success" + res.status);
    }
    )

}