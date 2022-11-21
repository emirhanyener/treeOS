
<script>
    var canvas = document.getElementById("application");
    var ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    ctx.fillStyle = "#000000";
    ctx.fillRect(0,0,window.innerWidth,window.innerHeight);
    <?php
        foreach($files as $item){
    ?>
        ctx.fillStyle = "#FFFFFF";
        ctx.fillRect(<?php echo $item["position_x"]; ?>,<?php echo $item["position_y"]; ?>,75,100);
        ctx.font = "20px Arial";
        ctx.fillText("<?php echo $item['file_name']; ?>", <?php echo $item["position_x"]; ?>, <?php echo $item["position_y"] + 130; ?>);
    <?php
        }
    ?>
    
    function drop(e){
        e.preventDefault();
        file_obj = e.dataTransfer.files[0];
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "file_upload.php", true);
 
        xhttp.send(form_data);
    }
    function allow_drop(e){
        e.preventDefault();
    }
</script>
