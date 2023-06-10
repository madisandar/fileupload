<?php

    $filenames = $_FILES['coverphoto']['name'];
    $filetmps = $_FILES['coverphoto']['tmp_name'];
    $fileerrs = $_FILES['coverphoto']['error'];
    $filesizes = $_FILES['coverphoto']['size'];

    $uploaddir = "./assets/";
    $allowextensions = ['jpg','png','jpeg','gif'];

    if(isset($_POST['submit'])){
        foreach($fileerrs as $idx=>$fileerr){
            // echo $fileerr."<br/>";
            // echo $key."<br/>";

            if($fileerr === UPLOAD_ERR_OK){
                $uploadfile = $uploaddir.basename($filenames[$idx]);
                $uploadtype = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
                $uplodtemp = $filetmps[$idx];
                $uploadsize = $filesizes[$idx];
                $errors = [];
                // echo $uploadfile."<br/>";
                // echo $uploadtype."<br/>";
                if(file_exists($uploadfile)){
                    $errors[] = "Your file already exists";
                }

               if(in_array($uploadtype,$allowextensions) === false){
                $errors[] = "Sorry,we do not allow this file types <br/>";
               }

               if($uploadsize > 300000){
                $errors[] = "Your file is too large <br/>";
               }

               if(empty($errors)){
                  move_uploaded_file($uplodtemp,$uploadfile);
                //   echo "File Successfully Uploaded";
               }

            }
        }

    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>File Upload</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style type="text/css">
            .removetxt span{
                display: none;
            }
            
            .gallery{
                width: 100%;
                background-color: #eee;
                color: #aaa;

                text-align: center;
                padding: 10px;
                margin: auto;
            }
            .gallery img{
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                
                padding: 5px;
                margin: 0 5px;
            }
        </style>
    </head>
    <body class="bg-stone-900">

         <div class="h-screen flex justify-center items-center">
            <div class="w-[300px] h-4/6 bg-white rounded px-3 py-2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                   <div class="flex justify-between items-center" >
                      <div>
                        <label for="coverphoto" class="text-lg font-bold">Upload photo</label>
                        <input type="file" name="coverphoto[]" id="coverphoto[]" class="w-full opacity-75 py-3" autocomplete="off" multiple />
                      </div>

                      <input type="submit" name="submit" id="submit" class="w-32 h-8 bg-[steelblue] text-white text-sm border border-6 cursor-pointer" value="Upload">
                  </div>
                </form>

                <div class="gallery removetxt my-5 py-5">
                    <span>Choose Images</span>
                </div>

                <div class="space-x-3 px-4 py-3">
                    <i class="fas fa-envelope text-pink-500"></i>
                    <span class="text-md text-[blue]">thiris613@gmail.com</span>
                </div>

                <div class="space-x-3 px-4 py-3">
                    <i class="fas fa-phone text-pink-500"></i>
                    <span class="text-md text-[blue]">+959 892550847</span>
                </div>

                <div class="space-x-3 px-4 py-3">
                    <i class="fas fa-globe text-pink-500"></i>
                    <span class="text-md text-[blue]">www.profile.com</span>
                </div>
            </div>
         </div>
           
         <script src="https://code.jquery.com/jquery-3.7.0.min.js" type="text/javascript"></script>
        <script  type="text/javascript">
            $(document).ready(function(){
                // console.log('hay');


                function previewimages(input,output){
                    //  console.log(input,output);
                    if(input.files){
                        var totalfiles = input.files.length;

                        if(totalfiles > 0){
                         $('.gallery').addClass('removetxt');
                        }else{
                         $('.gallery').removeClass('removetxt');
                       }

                       for(var i=0; i<totalfiles; i++){
                         var filereader = new FileReader();

                         filereader.onload = function(e){
                            $($.parseHTML('<img/>')).attr("src",e.target.result).appendTo(output);
                         }
                         filereader.readAsDataURL(input.files[i]);
                       }
                     }
                     
                }


                $('#coverphoto\\[\\]').change(function(){
                    previewimages(this,'.gallery');
                    $('#submit').click(function(){
                        window.confirm("Are your sure insert this photo?");
                    })
                })
                

               
            })
        </script>
    </body>
</html>