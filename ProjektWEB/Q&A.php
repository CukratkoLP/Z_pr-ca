<?php
    include_once('Partials\header.php');
?>
     <link rel="stylesheet" href="CSS/Q&A.css">
    <main>  
        <section class="formular">     
           <form id="fo"action="typage.html" method="get" target="_blank" autocomplete>
               <input type="text" id="name" name="name" required placeholder="Meno"><br>
               <input type="text" id="surname" name="surname" required placeholder="Priezvisko"><br>
               <input type="email" id="email" name="email" required placeholder="E-mail"><br>
               <textarea id="text" name="text" placeholder="Ozázky na mňa"></textarea><br>
               <label for="check">Súhlasím so spracovaním osobných údajov</label>
               <input type="checkbox" id="check2" name="check2" required><br>
               <input type="submit" value="Odoslať" onclick="odoslat()">
           </form>
        </section>
       </main>

<?php
    include_once('Partials\footer.php');
?>