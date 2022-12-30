<style>
    
     .loader{
            width: 100%;
            height: 100vh;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 100000444000;
            flex-direction: column;
            top: 0;
            }
        .water{
            width:150px;
            height: 150px;
            background-color: skyblue;
            border-radius: 50%;
            position: relative;
            box-shadow: inset 0 0 30px 0 rgba(0,0,0,.5), 0 4px 10px 0 rgba(0,0,0,.5);
            overflow: hidden;
        }
        .water:before, .water:after{
            content:'';
            position: absolute;
            width:150px;
            height: 150px;
            top:-80px;
            background-color: #fff;
        }
        .water:before{
            border-radius: 70%;
            background:rgba(255,255,255,.7);
            animation:wave 5s linear infinite;
        }
        .water:after{
            border-radius: 35%;
            background:rgba(255,255,255,.3);
            animation:wave 5s linear infinite;
        }
        @keyframes wave{
            0%{
                transform: rotate(0);
            }
            100%{
                transform: rotate(360deg);
            }
        }
</style>



<div class="overlay"></div>
<a href="#0" class="scrollToTop"><i class="las la-angle-up"></i></a>
<!-- ===========Loader=========== -->
<div class="preloader">
<div class="loader">
         <div class="water"></div>
         <p style="margin-top: 20px" class="my-3 text-center">Loading...</p> 
    </div>
</div>
<!-- ===========Loader=========== -->
