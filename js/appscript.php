<script>
    //window width control
    if (window.innerWidth < 500) {
        window.location = "desktop_responsive.php";
    }

    //canvas
    let canvas = document.getElementById("application");
    let ctx = canvas.getContext("2d");

    //images
    let file_icon = new Image();
    file_icon.src = 'images/file_icon.png';
    let folder_icon = new Image();
    folder_icon.src = 'images/folder_icon.png';
    let logo_icon = new Image();
    logo_icon.src = 'images/logo.png';

    //idle screen
    let pointer_idle = false;
    let pointer_idle_time = 0;
    let last_pointer_position_x = 0;
    let last_pointer_position_y = 0;

    //system variables
    let loader_active = true;
    let file_dropping = false;
    let desktop_context_menu_active = false;
    let settings_menu_active = false;
    let selected_context_menu_file = -1;
    let selected_file = -1;
    let opened_folder = "";

    let background_color = '<?php echo $user["background_color"]; ?>';

    //mouse events
    document.addEventListener('mousemove', pointer_stats);
    document.addEventListener('mousedown', switch_drag);
    document.addEventListener('mouseup', switch_drag);

    //pointer data
    let pointer = {
        is_dragging: false,
        click_position_x: 0,
        click_position_y: 0,
        pointer_position_x: 0,
        pointer_position_y: 0
    };

    let config = {
        file_context_menu_width: 200,
        file_context_menu_height: 30
    };

    //all files
    const files = [
        <?php
        foreach ($files as $item) {
        ?>
            {
                filename: "<?php echo $item['file_name']; ?>",
                position_x: <?php echo $item["position_x"]?>,
                position_y: <?php echo $item["position_y"]?>,
                foldername: "<?php echo $item['foldername'] ?>",
                isfolder: <?php echo $item["is_folder"]?>
        },
        <?php
        }
        ?>
    ];

    setInterval(() => {
        pointerIdleControl();
    }, 1000);
    function pointerIdleControl() {
        if (last_pointer_position_x == pointer.pointer_position_x && last_pointer_position_y == pointer.pointer_position_y) {
            pointer_idle_time++;
        } else {
            pointer_idle_time = 0;
            pointer_idle = false;
        }

        if (pointer_idle_time > 9) {
            pointer_idle = true;
        }

        last_pointer_position_x = pointer.pointer_position_x;
        last_pointer_position_y = pointer.pointer_position_y;
    }

    setInterval(() => {
        loader_active = false;
    }, 2000);

    //canvas draw all
    function refresh() {
        //set canvas size
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        //folder
        if (opened_folder == "") {
            ctx.fillStyle = background_color;
            ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
            ctx.fillStyle = "#FFF8";
            ctx.font = "28px Arial";
            ctx.fillText("<?php echo ($user["desktop_name"] == "" ? $user["username"] . "'s desktop" : $user["desktop_name"]); ?>", 20, 40);
        } else {
            ctx.fillStyle = "#333";
            ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
            ctx.fillStyle = "#222";
            ctx.fillRect(0, 0, window.innerWidth, 40);
            if (pointer.pointer_position_x >= window.innerWidth - 100 && pointer.pointer_position_x <= window.innerWidth && pointer.pointer_position_y >= 0 && pointer.pointer_position_y <= 40) {
                ctx.fillStyle = "#F44";
            } else {
                ctx.fillStyle = "#F00";
            }
            ctx.fillRect(window.innerWidth - 100, 0, 100, 40);
            ctx.fillStyle = "#FFF";
            ctx.font = "20px Arial";
            ctx.fillText("Close", window.innerWidth - 75, 27);
            ctx.fillStyle = "#ADF";
            ctx.font = "20px Arial";
            ctx.fillText(opened_folder, 35, 27);
            ctx.drawImage(folder_icon, 10, 10, 13, 20)
        }
        //folder end

        //files
        files.forEach(item => {
            if (item.foldername == opened_folder) {
                if (pointer.pointer_position_x >= item.position_x - 20 && pointer.pointer_position_x <= item.position_x + 90 && pointer.pointer_position_y >= item.position_y - 5 && pointer.pointer_position_y <= item.position_y + 140) {
                    ctx.fillStyle = "#3368";
                    ctx.fillRect(item.position_x - 20, item.position_y - 5, 110, 145)
                }
                if (item.isfolder == 0) {
                    if (item.filename.split(".")[1] == "png" || item.filename.split(".")[1] == "jpg") {
                        let fileimage = new Image();
                        fileimage.src = "uploads/" + item.filename;
                        ctx.drawImage(fileimage, item.position_x, item.position_y, 70, 100);
                    }
                    else {
                        ctx.drawImage(file_icon, item.position_x, item.position_y, 70, 100);
                    }

                    ctx.fillStyle = "#ADF8";
                    ctx.fillRect(item.position_x, item.position_y, 70, 20)
                    ctx.fillStyle = "#111111";
                    ctx.font = "16px Arial";
                    ctx.fillText(item.filename.split(".")[1], item.position_x + 5, item.position_y + 15);
                } else {
                    ctx.drawImage(folder_icon, item.position_x, item.position_y, 70, 100);
                }

                ctx.fillStyle = "#FFFFFF";
                ctx.font = "18px Arial";
                if (item.isfolder == 0) {
                    ctx.fillText((item.filename.split("_")[2].split(".")[0].length > 6 ? item.filename.split("_")[2].split(".")[0].substring(0, 6) + "." : item.filename.split("_")[2].split(".")[0]) + "." + item.filename.split("_")[2].split(".")[1], item.position_x + (item.filename.split("_")[2].split(".")[0].length >= 6 ? - 15 : + 0), item.position_y + 130);
                } else {
                    ctx.fillText((item.filename.length > 10 ? item.filename.substring(0, 10) + "..." : item.filename), item.position_x + (item.filename.length >= 10 ? - 15 : + 0), item.position_y + 130);
                }
            }
        });
        //files end

        //desktop context menu(create folder)
        if (desktop_context_menu_active) {
            ctx.font = "16px Arial";
            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 110 && pointer.pointer_position_y >= pointer.click_position_y && pointer.pointer_position_y <= pointer.click_position_y + 30)
                ctx.fillStyle = "#DFFFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y, 110, 30);
            ctx.fillStyle = "#333333";
            ctx.fillText("Create Folder", pointer.click_position_x + 5, pointer.click_position_y + 20);
            ctx.rect(pointer.click_position_x, pointer.click_position_y, 110, 30);
        }
        //desktop context menu end

        //file context menu
        if (selected_context_menu_file != -1) {
            ctx.font = "16px Arial";

            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 1))
                ctx.fillStyle = "#DFFFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y, config.file_context_menu_width, config.file_context_menu_height);
            ctx.fillStyle = "#333333";
            ctx.fillText("Download", pointer.click_position_x + 5, pointer.click_position_y + 20);
            ctx.rect(pointer.click_position_x, pointer.click_position_y, config.file_context_menu_width, config.file_context_menu_height);

            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y + (config.file_context_menu_height * 1) && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 2))
                ctx.fillStyle = "#DFFFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 1), config.file_context_menu_width, config.file_context_menu_height);
            ctx.fillStyle = "#333333";
            ctx.fillText("Rename", pointer.click_position_x + 5, pointer.click_position_y + 20 + (config.file_context_menu_height * 1));
            ctx.rect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 1), config.file_context_menu_width, config.file_context_menu_height);

            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y + (config.file_context_menu_height * 2) && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 3))
                ctx.fillStyle = "#FFDFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 2), config.file_context_menu_width, config.file_context_menu_height);
            ctx.fillStyle = "#333333";
            ctx.fillText("Delete", pointer.click_position_x + 5, pointer.click_position_y + 20 + (config.file_context_menu_height * 2));
            ctx.rect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 2), config.file_context_menu_width, config.file_context_menu_height);

            if (files[selected_context_menu_file].foldername != "") {
                if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y + (config.file_context_menu_height * 3) && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 4))
                    ctx.fillStyle = "#FFDFDF";
                else
                    ctx.fillStyle = "#FFFFFF";
                ctx.fillRect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 3), config.file_context_menu_width, config.file_context_menu_height);
                ctx.fillStyle = "#333333";
                ctx.fillText("Move To Desktop", pointer.click_position_x + 5, pointer.click_position_y + 20 + (config.file_context_menu_height * 3));
                ctx.rect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 3), config.file_context_menu_width, config.file_context_menu_height);


                if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y + (config.file_context_menu_height * 4) && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 5))
                    ctx.fillStyle = "#DFDFFF";
                else
                    ctx.fillStyle = "#FFFFFF";
                ctx.fillRect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 4), config.file_context_menu_width, config.file_context_menu_height);
                ctx.fillStyle = "#333333";
                ctx.fillText("Set As Desktop Background", pointer.click_position_x + 5, pointer.click_position_y + 20 + (config.file_context_menu_height * 4));
                ctx.rect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 4), config.file_context_menu_width, config.file_context_menu_height);
            } else {
                if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + config.file_context_menu_width && pointer.pointer_position_y >= pointer.click_position_y + (config.file_context_menu_height * 3) && pointer.pointer_position_y <= pointer.click_position_y + (config.file_context_menu_height * 4))
                    ctx.fillStyle = "#DFDFFF";
                else
                    ctx.fillStyle = "#FFFFFF";
                ctx.fillRect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 3), config.file_context_menu_width, config.file_context_menu_height);
                ctx.fillStyle = "#333333";
                ctx.fillText("Set As Desktop Background", pointer.click_position_x + 5, pointer.click_position_y + 20 + (config.file_context_menu_height * 3));
                ctx.rect(pointer.click_position_x, pointer.click_position_y + (config.file_context_menu_height * 3), config.file_context_menu_width, config.file_context_menu_height);
            }

            ctx.stroke();
        }
        //file context menu end

        //start menu
        if (settings_menu_active) {
            ctx.font = "16px Arial";
            if (pointer.pointer_position_x >= 70 && pointer.pointer_position_x <= 270 && pointer.pointer_position_y >= canvas.height - 30 && pointer.pointer_position_y <= canvas.height)
                ctx.fillStyle = "#DFFFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(70, canvas.height - 30, 200, 30);
            ctx.fillStyle = "#333333";
            ctx.fillText("Change Desktop Name", 75, canvas.height - 10);
            ctx.rect(70, canvas.height - 30, 200, 30);


            if (pointer.pointer_position_x >= 70 && pointer.pointer_position_x <= 270 && pointer.pointer_position_y >= canvas.height - 60 && pointer.pointer_position_y <= canvas.height - 30)
                ctx.fillStyle = "#DFFFDF";
            else
                ctx.fillStyle = "#FFFFFF";
            ctx.fillRect(70, canvas.height - 60, 200, 30);
            ctx.fillStyle = "#333333";
            ctx.fillText("Change Background Color", 75, canvas.height - 40);
            ctx.rect(70, canvas.height - 60, 200, 30);
        }
        //start menu end

        //start icon
        if (pointer.pointer_position_x >= 0 && pointer.pointer_position_x <= 70 && pointer.pointer_position_y >= canvas.height - 80 && pointer.pointer_position_y <= canvas.height) {
            ctx.fillStyle = "#8888";
            ctx.fillRect(0, canvas.height - 80, 70, 80);
        } else {
            ctx.fillStyle = "#5558";
            ctx.fillRect(0, canvas.height - 80, 70, 80);
        }
        ctx.drawImage(logo_icon, 13, canvas.height - 70, 40, 60)
        //start icon end

        //file drop
        if (file_dropping) {
            ctx.fillStyle = "#4449";
            ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
            ctx.fillStyle = "#FFF8";
            ctx.font = "28px Arial";
            ctx.fillText("Drop File", window.innerWidth / 2 - 30, window.innerHeight / 2 - 14);
            file_dropping = false;
        }
        //file drop end

        //loader
        if (loader_active) {
            ctx.fillStyle = background_color;
            ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
            ctx.fillStyle = "#FFF8";
            ctx.font = "28px Arial";
            ctx.fillText("Loading", window.innerWidth / 2 - 90, window.innerHeight / 2 + 50);
            ctx.drawImage(logo_icon, window.innerWidth / 2 - logo_icon.naturalWidth / 2, window.innerHeight / 2 - logo_icon.naturalHeight / 2, logo_icon.naturalWidth / 2, logo_icon.naturalHeight / 2)
        }
        //loader end

        //idle screen
        if (pointer_idle) {
            ctx.fillStyle = background_color;
            ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
            ctx.fillStyle = "#FFF6";
            ctx.font = "128px Arial";
            ctx.fillText((new Date()).getHours() + ":" + (new Date()).getMinutes() + ":" + ((new Date()).getSeconds() < 10 ? "0" + (new Date()).getSeconds() : (new Date()).getSeconds()), window.innerWidth / 2 - 250, window.innerHeight / 2);
            ctx.fillStyle = "#FFF6";
            ctx.font = "32px Arial";
            ctx.fillText("<?php echo $_SESSION["username"]; ?>", 10, 35);
        }
        //idle screen end

        ctx.stroke();
    }

    //update pointer data
    function pointer_stats(e) {
        pointer.pointer_position_x = e.clientX;
        pointer.pointer_position_y = e.clientY;

        //if a file selected then set file position
        if (pointer.is_dragging) {
            if (selected_file != -1) {
                files[selected_file].position_x = pointer.pointer_position_x - (75 / 2);
                files[selected_file].position_y = pointer.pointer_position_y - (100 / 2);
            }
        }

        refresh();
    }

    //close panel
    function close_center_div() {
        document.getElementById("body").innerHTML = "";
    }

    //mouse down/up events
    function switch_drag() {
        //start menu events
        if (settings_menu_active) {
            if (pointer.pointer_position_x >= 70 && pointer.pointer_position_x <= 270 && pointer.pointer_position_y >= canvas.height - 30 && pointer.pointer_position_y <= canvas.height) {
                document.getElementById("body").innerHTML = "<div class='center-div'><h3>Change Desktop Name</h3><hr><form action='change_desktop_name.php' method='POST'><table><tr><td>New Desktop Name</td><td><input type='text' name = 'desktopname'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='submit' value='Change'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='button' onclick='close_center_div()' value='Close'></td></tr></table></form></div>";
            }
            if (pointer.pointer_position_x >= 70 && pointer.pointer_position_x <= 270 && pointer.pointer_position_y >= canvas.height - 60 && pointer.pointer_position_y <= canvas.height - 30) {
                document.getElementById("body").innerHTML = "<div class='center-div'><h3>Change Background Color</h3><hr><form action='change_background_color.php' method='POST'><table><tr><td>New Background Color</td><td><input type='color' name = 'color'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='submit' value='Change'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='button' onclick='close_center_div()' value='Close'></td></tr></table></form></div>";
            }
        }
        //start menu events end

        //start menu activity
        if (pointer.pointer_position_x >= 0 && pointer.pointer_position_x <= 70 && pointer.pointer_position_y >= canvas.height - 80 && pointer.pointer_position_y <= canvas.height) {
            settings_menu_active = true;
        } else {
            settings_menu_active = false;
        }
        //start menu activity end

        //desktop context menu
        if (opened_folder != "") {
            if (pointer.pointer_position_x >= window.innerWidth - 100 && pointer.pointer_position_x <= window.innerWidth && pointer.pointer_position_y >= 0 && pointer.pointer_position_y <= 40) {
                opened_folder = "";
            }
        } 
        
            if (desktop_context_menu_active) {
                if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 110 && pointer.pointer_position_y >= pointer.click_position_y && pointer.pointer_position_y <= pointer.click_position_y + 30) {
                    document.getElementById("body").innerHTML = "<div class='center-div'><h3>Create Folder</h3><hr><form action='create_folder.php' method='POST'><input type='hidden' name='openedfoldername' value='" + opened_folder + "'><input type='hidden' name='position_x' value='" + pointer.click_position_x + "'><input type='hidden' name='position_y' value='" + pointer.click_position_y + "'><table><tr><td>Folder Name</td><td><input type='text' name = 'foldername'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='submit' value='Create'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='button' onclick='close_center_div()' value='Close'></td></tr></table></form></div>";
                }
                desktop_context_menu_active = false;
            }
        
        //desktop context menu end

        //file context menu
        if (selected_context_menu_file != -1) {
            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y && pointer.pointer_position_y <= pointer.click_position_y + 30) {
                if (files[selected_context_menu_file].isfolder == 0) {
                    document.getElementById("body").innerHTML = "<a href='uploads/" + files[selected_context_menu_file].filename + "' download id='download-file-link' style='display:none;'>";
                    document.getElementById("download-file-link").click();
                    document.getElementById("body").innerHTML = "";
                }
            }
            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y + 30 && pointer.pointer_position_y <= pointer.click_position_y + 60) {
                document.getElementById("body").innerHTML = "<div class='center-div'><h3>Rename File</h3><hr><form action='rename_file.php' method='POST'><input type='hidden' name='isfolder' value = '" + files[selected_context_menu_file].isfolder + "'><table><tr><td><input name='filename' type='hidden' value = '" + files[selected_context_menu_file].filename + "'></td></tr><tr><td>From</td><td>" + (files[selected_context_menu_file].isfolder == 0 ? files[selected_context_menu_file].filename.split("_")[2] : files[selected_context_menu_file].filename) + "</td></tr><tr><td>To</td><td><input type='text' name = 'tofilename' value = '" + (files[selected_context_menu_file].isfolder == 0 ? files[selected_context_menu_file].filename.split("_")[2] : files[selected_context_menu_file].filename) + "'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='submit' value='Rename'></td></tr><tr><td colspan='2'><input style='width:100%;padding:5px;' type='button' onclick='close_center_div()' value='Close'></td></tr></table></form></div>";
            }
            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y + 60 && pointer.pointer_position_y <= pointer.click_position_y + 90) {
                let form_data = new FormData();
                temp = selected_context_menu_file;
                form_data.append('filename', files[selected_context_menu_file].filename);

                let xhttp = new XMLHttpRequest();
                xhttp.open("POST", "delete_file.php", true);
                xhttp.onload = function (event) {
                    files.splice(temp, 1);
                }

                xhttp.send(form_data);
            }
            if (pointer.pointer_position_x >= pointer.click_position_x && pointer.pointer_position_x <= pointer.click_position_x + 100 && pointer.pointer_position_y >= pointer.click_position_y + 90 && pointer.pointer_position_y <= pointer.click_position_y + 120) {
                let temp = selected_context_menu_file;
                let form_data = new FormData();
                form_data.append('filename', files[selected_context_menu_file].filename);

                let xhttp = new XMLHttpRequest();
                xhttp.open("POST", "move_to_desktop.php", true);
                xhttp.onload = function (event) {
                    files[temp].foldername = "";
                }

                xhttp.send(form_data);
            }

            selected_context_menu_file = -1;
            refresh();
        }
        //file context menu end

        //set pointer data
        pointer.is_dragging = !pointer.is_dragging;

        pointer.click_position_x = pointer.pointer_position_x;
        pointer.click_position_y = pointer.pointer_position_y;

        //select file
        for (let i = 0; i < files.length; i++) {
            if (pointer.click_position_x >= files[i].position_x - 20 && pointer.click_position_x <= files[i].position_x + 90) {
                if (pointer.click_position_y >= files[i].position_y - 5 && pointer.click_position_y <= files[i].position_y + 140) {
                    if (pointer.is_dragging && selected_file == -1) {
                        if (files[i].foldername == opened_folder) {
                            selected_file = i;
                            break;
                        }
                    }
                }
            }
        }
        //select file end

        //add to folder and save desktop events
        if (!pointer.is_dragging) {
            if (selected_file != -1) {
                for (let i = 0; i < files.length; i++) {
                    if (pointer.click_position_x >= files[i].position_x - 20 && pointer.click_position_x <= files[i].position_x + 90) {
                        if (pointer.click_position_y >= files[i].position_y - 5 && pointer.click_position_y <= files[i].position_y + 140) {
                            if (files[i].isfolder == 1 && i != selected_file) {
                                if (opened_folder == files[i].foldername) {
                                    let temp = selected_file;
                                    let form_data = new FormData();
                                    form_data.append('foldername', files[i].filename);
                                    form_data.append('filename', files[selected_file].filename);

                                    let xhttp = new XMLHttpRequest();
                                    xhttp.open("POST", "add_to_folder.php", true);
                                    xhttp.onload = function (event) {
                                        files[temp].foldername = files[i].filename;
                                    }

                                    xhttp.send(form_data);
                                    break;
                                }
                            }
                        }
                    }
                }
                save_desktop_fn();
            }
            selected_file = -1;
        }
        //add to folder and save desktop events end

        refresh();
    }

    //file drop
    function drop(e) {
        e.preventDefault();
        file_obj = e.dataTransfer.files[0];

        let form_data = new FormData();
        form_data.append('file', file_obj);
        form_data.append('position_x', e.clientX);
        form_data.append('position_y', e.clientY);

        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "file_upload.php", true);
        xhttp.onload = function (event) {
            files.push({
                filename: this.responseText,
                position_x: e.clientX,
                position_y: e.clientY,
                foldername: "",
                isfolder: 0
            });
        }

        xhttp.send(form_data);
    }
    function allow_drop(e) {
        e.preventDefault();
        file_dropping = true;
    }

    //update all file data to database
    function save_desktop_fn() {
        files.forEach(item => {
            let form_data = new FormData();
            form_data.append('filename', item.filename);
            form_data.append('position_x', item.position_x);
            form_data.append('position_y', item.position_y);

            let xhttp = new XMLHttpRequest();
            xhttp.open("POST", "save_desktop.php", true);
            xhttp.send(form_data);
        });
    }

    //double click file open 
    function open_file() {
        for (let i = 0; i < files.length; i++) {
            if (pointer.click_position_x >= files[i].position_x - 20 && pointer.click_position_x <= files[i].position_x + 90) {
                if (pointer.click_position_y >= files[i].position_y - 5 && pointer.click_position_y <= files[i].position_y + 140) {
                    if (opened_folder == files[i].foldername) {
                        if (files[i].isfolder == 0) {
                            window.open("uploads/" + files[i].filename, "_blank");
                        } else {
                            opened_folder = files[i].filename;
                        }
                        break;
                    }
                }
            }
        }
    }

    //custom context menu for canvas
    window.addEventListener('contextmenu', (event) => {
        event.preventDefault();
        //set file context menu activity
        for (let i = 0; i < files.length; i++) {
            if (opened_folder == files[i].foldername) {
                if (pointer.click_position_x >= files[i].position_x - 20 && pointer.click_position_x <= files[i].position_x + 90) {
                    if (pointer.click_position_y >= files[i].position_y - 5 && pointer.click_position_y <= files[i].position_y + 140) {
                        selected_context_menu_file = i;
                        break;
                    }
                }
            }
        }
        //set file context menu activity end

        //set desktop context menu activity
        if (selected_context_menu_file == -1) {
                desktop_context_menu_active = true;
            
        }
        //set desktop context menu activity end

        refresh();
    });

    //refresh every one second
    refresh();
    setInterval(() => {
        refresh();
    }, 1000);

    //window resize event
    window.onresize = function (event) {
        if (window.innerWidth < 500) {
            window.location = "desktop_responsive.php";
        }
    };
</script>