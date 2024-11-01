            <footer>
                <div class="pull-right">
                    Boss Cafe Management System. &copy;2024 All Rights Reserved.
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    </div>

    <?php include_once "../app/views/components/about_us.php" ?>
    <?php include_once "../app/views/components/account_settings.php" ?>

    <script>
        var user_id = "<?= session("user_id") ?>";
        var notification = <?= session("notification") ? json_encode(session("notification")) : json_encode(null) ?>;
    </script>

    <script src="./assets/plugins/jquery/dist/jquery.min.js"></script>
    <script src="./assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/plugins/fastclick/lib/fastclick.js"></script>
    <script src="./assets/plugins/sweetalert2/js/sweetalert2.min.js"></script>
    <script src="./assets/js/custom.min.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>

<?php session("notification", "unset") ?>