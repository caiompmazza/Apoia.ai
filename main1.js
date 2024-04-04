class MyHeader extends HTMLElement {
	connectedCallback(){
		this.innerHTML = `




   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- This is the style for the header -->
    <link rel="stylesheet" href="style_header.css">

   
    <title>Document</title>
</head>
<body>
    <!-- Start of the header -->
    <header>
        <div class="inner">
            <div class="logo">
                <div>
                    
                    <z ><font color="#ffffff">RifasOnline</font></z>
                    <style>
                    z{

                    	font-size: 50px;
                    }
                    </style>
                   
                </div>
            </div>

            <nav>
                <!-- Each of the below lines look complicated. There is a reason for this markup though!
                <li> tag will be the container for the table.
                <span> will be the part that centers the content inside it
                <a> is the actual clickable part -->
                <li><span><a href="home1.php"><font color="#ffffff">Home</font></a></span></li>
                
                <li><span><a href="criar_rifa.php"><font color="#ffffff">Criar</font></a></span></li>
                
                <li><span><a href="minhas_rifas2.php"><font color="#ffffff">Minhas Rifas</font></a></span></li>
                <li><span><a href="comprar_rifa.php"><font color="#ffffff">Comprar</font></a></span></li>
                <!-- On the line above, remove the class="button" if you don't want the final
                element to be a button -->
            </nav>
        </div>
    </header>
    <!-- End of the header --> 
</body>
</html>
   `
	}
}

customElements.define('my-header', MyHeader)