<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hard Hat Data</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/login.css">

    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-analytics.js";
        import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-auth.js";

        // Your web app's Firebase configuration
         const firebaseConfig = {
            apiKey: "AIzaSyAy_bQFynVXe_RflYLYgsU0skc8ThOKDYE",
            authDomain: "smarthardhat-22267.firebaseapp.com",
            databaseURL: "https://smarthardhat-22267-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "smarthardhat-22267",
            storageBucket: "smarthardhat-22267.appspot.com",
            messagingSenderId: "1001952473982",
            appId: "1:1001952473982:web:a309b046972d3602d5b92f",
            measurementId: "G-X155LG29H6"
          };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
        const auth = getAuth();

        // Add event listener to handle form submission
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            signInWithEmailAndPassword(auth, loginForm.email.value, loginForm.password.value)
                .then((userCredential) => {
                    // Signed in 
                    const user = userCredential.user;
                    const uid = user.uid;
                    $.ajax({
                        url: 'setsession.php',
                        type: 'POST',
                        data: {id:uid,},
                        success:function(data){
                            location.href = "admin/dashboard.php"
                        }
                    })
                    // ...
                })
                .catch((error) => {
                    alert('error: ' + error.message);
                });
        });
    </script>
</head>
<body class="hold-transition login-page" style="background: #f5f4f0;">
    <div class="container right-panel-active">
        <!-- Sign In -->
        <div class="container__form container--signin">
            <form method="POST" class="form" id="loginForm">
                <div>
                    <h2 class="form__title">ACCOUNT LOGIN</h2>
                    <input type="email" name="email" placeholder="Email" class="input" required />
                    <input type="password" name="password" placeholder="Password" class="input" required />
                    <div style="text-align: left; margin-top: 10px;">
                        <button type="submit" name="signin" class="btn" style="width: 100%;">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- jQuery 3 -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
