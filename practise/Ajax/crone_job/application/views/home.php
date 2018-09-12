




<!--  Two problem here 
    
    1.second is not printing in getCookies.

    2.how to stop expire time repeatedly refresh store in cookies.

-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>    
    function startTimer(duration,display)
    {
       
        var timer =  duration,minutes,seconds;//storing time in timer
        setInterval(function(){
        minutes = parseInt(timer/60,10);
        seconds = parseInt(timer%60,10);
        
        minutes = minutes<10?"0"+minutes:minutes;
        seconds = seconds<10?"0"+seconds:seconds;
        display.textContent  = minutes+":"+seconds;
        setCookie("minutes",minutes.toString(),1);
        setCookie("seconds",seconds.toString(),1);
            if(--timer<0)
            {
                timer=0;
            }

        },1000);
    }

    function setCookie(name,value,exdays)
    {
        var minutes_data = getCookie("minutes");

        if(!(minutes_data))
        {
            var d = new Date();
            d.setTime(d.getTime()+(exdays*24*60*60*1000));
            var expires ="expires = "+d.toUTCString();
            document.cookie = name+" ="+value+" ;"+expires;
           // console.log("11",expires);
        }
            //####################Ajax call for Expire time #############################
        
        else{         //#################### End Of Ajax Call #########################
             //console.log("22",expires);
            document.cookie = name+" ="+value+" ;";
        }       //console.log(document.cookie );
         
            
    }
    
    function getCookie(cname)
    {
        // console.log(cname,'data i');
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i<ca.length;i++)
    {
        var c =ca[i];
        while(c.charAt(0)=='')c=c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return '';
    }
    window.onload = function()
    {
         
        var minutes_data = getCookie("minutes");
       var seconds_data = getCookie("seconds");
       console.log(minutes_data,'data is ',seconds_data);
       
        var timer_amount = 60*10; //default

        if (!minutes_data || !seconds_data)
        {
            
        } 
        else
        {
            timer_amount = parseInt(minutes_data*60)+parseInt(seconds_data)
        }
        
        var fiveMinutes = timer_amount;
        display = document.querySelector('#time');
        startTimer(fiveMinutes, display); //`enter code here`
        
    }
    </script>
</head>

<body>
    <div id="time"></div>   
</body>
</html>