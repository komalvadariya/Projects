<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<!-- <script>
    function check_pass() {
    if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
        document.getElementById('submit').disabled = false;
    } else {
        document.getElementById('submit').disabled = true;
    }
}
</script> -->
<div class="container">
    <form method="post">
        <div class="row mt-5 pt-5">
            <div class="col-lg-4 offset-lg-4">
                <div class="card text-center" style="width: 300px;">
                    <div class="card-header h5 text-white bg-primary">Reset Password </div>
                    <div class="card-body px-5">

                        <div class="form-outline">
                            <input type="text" id="typeEmail" name="OTP" placeholder="Enter OTP" class="form-control my-3" />
                            <input type="text" id="typeEmail" name="Password" placeholder="Enter New Password" class="form-control my-3" />
                            <input type="text" id="typeEmail" name="NW password" placeholder="Re Enter Password" class="form-control my-3" />

                            <a href="#" class="btn btn-primary mt-3 w-100">Set Password</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>