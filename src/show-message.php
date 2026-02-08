<?php

#Code to Show Error Message
if (isset($_GET['error'])) {
    echo "<div id='error-message' class='flex message'>
               <div class='center'><i id='error-icon' class='fa-regular fa-circle-xmark'></i></div>
               <div>
                    <b>Error:</b>
                    <p>{$_GET['error']}</p>
               </div>
          </div>";
}

#Code to Show Success Message
if (isset($_GET['success'])) {
    echo "<div id='success-message' class='flex message'>
                    <div class='center'><i id='success-icon' class='fa-regular fa-circle-check'></i></div>
                    <div>
                         <b>Success:</b>
                         <p>{$_GET['success']}</p>
                    </div>
          </div>";
}
