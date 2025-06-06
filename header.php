<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- This is the style for the header -->
    <link rel="stylesheet" href="style_header.css">

    <!-- This is just a font that we'll be using. You can remove lines 12-14 if you don't want to use Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <!-- Start of the header -->
    <header>
        <div class="inner">
            <div class="logo">
                <div>
                    <!-- The below line can be an image or a h1, either will work -->
                    <p>RifaOnline</p>
                    <!-- <h1>My Logo</h1> -->
                </div>
            </div>

            <nav>
                <!-- Each of the below lines look complicated. There is a reason for this markup though!
                <li> tag will be the container for the table.
                <span> will be the part that centers the content inside it
                <a> is the actual clickable part -->
                <li><span><a href="">Home</a></span></li>
                <li><span><a href="">Criar</a></span></li>
                <li><span><a href="">Buscar</a></span></li>
                <li><span><a href="">Sobre</a></span></li>
                <!-- On the line above, remove the class="button" if you don't want the final
                element to be a button -->
            </nav>
        </div>
    </header>
    <!-- End of the header --> 
</body>
</html>