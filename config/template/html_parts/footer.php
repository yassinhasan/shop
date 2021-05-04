    <div class="footer">
        &copy; 2020 made by <i class="fas fa-heart icon-footer"></i> by yassin
    </div>
        <script src= <?= JS_PATH."bootstrap.min.js.map" ?>></script>
        <script src= <?= JS_PATH."bootstrap.min.js" ?>></script>
        <script src= <?= JS_PATH."all.min.js" ?>></script>
        <script src= <?= JS_PATH."js.js" ?>></script>
        <?php global $title;
      
      echo (isset($title) && $title == 'login') ? "<script src='./themes/js/login.js' ?>></script>" : ''?>
    </body>
</html>