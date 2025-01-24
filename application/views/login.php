
<!DOCTYPE html>
<html>
<head>
    <title>Userform</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
</head>
<body>

<style>

    .layout
    {
        margin-left: 30%;
        margin-right: 30%;
        margin-top: 8%;
        padding: 10px,10px;
    }
    .error
    {
        color:red;
    }
    .success{
        color: green;
    }
</style>

<div class="container">

    <div align="center">
        <h2>Login</h2>
    </div>
   
    <div class="layout">
    <?php if ($this->session->flashdata('error')): ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		<?php endif; ?>
        <div style="padding: 20px;border: 1px solid lightgray;">
            <form method="post" action="<?php echo base_url('login/authenticate_user')?>" class="loginForm" id="loginForm">
               
                <div class="form-group">
                    <label for="email">Email</label>*
                    <input type="email" class="form-control" id="email" name="email" required autocomplete="off" >
                </div>
                <span id="errorspan"></span>
                 <div class="form-group">
                    <label for="password">Password</label>*
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
                </div>

                <div class="form-group">
                    <input type="submit" id="submit" class="btn btn-primary">
                    <input type="button" id="reset" class="btn btn-primary" value="Reset">
                </div>
            </form>
        </div>
    </div>
</div>
<table class="table">
      <tr>
      <th>Login Id</th>
      <th>Password</th>
      <th>Role</th>
      </tr>
      <tr>
         <td>devang.hire@yopmail.com</td>
         <td>123456789</td>
         <td>Admin</td>
      </tr>
      <tr>
         <td>ankur.patel@yopmail.com</td>
         <td>123456789</td>
         <td>Editor</td>
      </tr>
      <tr>
         <td>mahesh.patel@yopmail.com</td>
         <td>123456789</td>
         <td>Viewer</td>
      </tr>
      </tr>
      
    </table>

<script>

    $(document).ready(function(){

        $("#email").focus();
        $("#reset").click(function() {
            $("input[type=text] , input[type=email] , input[type=password]").val("");
            $(".errormsg").text("");
        });

        $('#loginForm').validate({

            rules: {
                email: {
                    required: true,
                    email:true,

                },
                password: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "Please Enter Email"

                },
                password: {
                    required: "Please Enter Password"

                },

            },
        });
       
    });
</script>

</body>
</html>

